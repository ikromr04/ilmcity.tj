<?php

namespace Tests\Feature;

use App\Filament\Pages\ManageSettings;
use App\Livewire\ContactForm;
use App\Models\ContactRequest;
use App\Models\Course;
use App\Models\Employee;
use App\Models\Gallery;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->seed(DatabaseSeeder::class);
    }

    public static function publicPages(): array
    {
        return [
            ['/'], ['/about'], ['/courses'], ['/employees'], ['/camp'],
            ['/services'], ['/galleries'], ['/faq'],
        ];
    }

    #[DataProvider('publicPages')]
    public function test_public_pages_render(string $uri): void
    {
        $this->get($uri)->assertOk()->assertSee('Свяжитесь с нами');
    }

    public function test_detail_pages_render(): void
    {
        $course = Course::visible()->first();
        $employee = Employee::visible()->first();
        $gallery = Gallery::visible()->first();

        $this->get(route('courses.show', $course))->assertOk()->assertSee($course->title)->assertSee('В программе');
        $this->get(route('employees.show', $employee))->assertOk()->assertSee($employee->name)->assertSee('Сертификаты');
        $this->get(route('galleries.show', $gallery))->assertOk()->assertSee('01.06.2024');
    }

    public function test_unpublished_records_are_hidden(): void
    {
        $course = Course::first();
        $course->update(['is_published' => false]);

        $this->get(route('courses.show', $course))->assertNotFound();
        $this->get('/courses')->assertDontSee(route('courses.show', $course).'"', false);
    }

    public function test_home_page_shows_stats_from_settings(): void
    {
        Setting::put(['stats' => [['value' => '999+', 'label_ru' => 'Тестовых учеников', 'label_tj' => null]]]);

        $this->get('/')->assertSee('999+')->assertSee('Тестовых учеников');
    }

    public function test_contact_form_creates_request(): void
    {
        $course = Course::first();

        Livewire::test(ContactForm::class)
            ->dispatch('enroll', course: $course->id)
            ->assertSet('courseId', $course->id)
            ->set('name', 'Иван Иванов')
            ->set('phone', '+992 900 00 00 00')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('sent', true);

        $request = ContactRequest::sole();
        $this->assertSame('Иван Иванов', $request->name);
        $this->assertSame($course->id, $request->course_id);
        $this->assertStringContainsString($course->title, $request->message);
    }

    public function test_contact_form_requires_name_and_contact(): void
    {
        Livewire::test(ContactForm::class)
            ->call('submit')
            ->assertHasErrors(['name', 'phone', 'email']);
    }

    public static function adminPages(): array
    {
        return [
            ['/admin'], ['/admin/courses'], ['/admin/courses/create'], ['/admin/courses/1/edit'],
            ['/admin/employees'], ['/admin/employees/create'], ['/admin/employees/1/edit'],
            ['/admin/galleries'], ['/admin/galleries/1/edit'], ['/admin/news'], ['/admin/news/1/edit'],
            ['/admin/reviews'], ['/admin/reviews/1/edit'], ['/admin/advantages'], ['/admin/advantages/1/edit'],
            ['/admin/services'], ['/admin/services/1/edit'], ['/admin/faqs'], ['/admin/faqs/1/edit'],
            ['/admin/partners'], ['/admin/partners/1/edit'], ['/admin/contact-requests'], ['/admin/settings'],
        ];
    }

    #[DataProvider('adminPages')]
    public function test_admin_pages_render(string $uri): void
    {
        $this->actingAs(User::first())->get($uri)->assertOk();
    }

    public function test_admin_requires_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_settings_page_saves(): void
    {
        $this->actingAs(User::first());

        Livewire::test(ManageSettings::class)
            ->assertSet('data.phone', '+992 987 65 43 21')
            ->set('data.phone', '+992 111 11 11 11')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('+992 111 11 11 11', Setting::get('phone'));
        $this->get('/')->assertSee('+992 111 11 11 11');
    }
}
