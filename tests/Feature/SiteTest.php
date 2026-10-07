<?php

namespace Tests\Feature;

use App\Filament\Pages\Content;
use App\Filament\Pages\ManageSettings;
use App\Filament\Resources\Courses\Pages\EditCourse;
use App\Filament\Resources\Faqs\Pages\CreateFaq;
use App\Livewire\ContactForm;
use App\Livewire\EnrollForm;
use App\Models\ContactRequest;
use App\Models\Course;
use App\Models\Employee;
use App\Models\Gallery;
use App\Models\Setting;
use App\Models\User;
use App\Support\SiteContent;
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
        Livewire::test(ContactForm::class)
            ->set('name', 'Иван Иванов')
            ->set('phone', '900 00 00 00')
            ->set('message', 'Перезвоните мне')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('sent', true)
            ->assertSet('message', '');

        $request = ContactRequest::sole();
        $this->assertSame('Иван Иванов', $request->name);
        $this->assertSame('+992 900000000', $request->phone);
        $this->assertSame('Перезвоните мне', $request->message);
        $this->assertNull($request->course_id);
    }

    public function test_contact_form_requires_name_and_contact(): void
    {
        Livewire::test(ContactForm::class)
            ->call('submit')
            ->assertHasErrors(['name', 'phone', 'email'])
            ->assertSee('Поле ФИО обязательно для заполнения.')
            ->assertSee('Укажите телефон или email')
            ->assertDontSee('validation.');
    }

    public function test_contact_form_errors_clear_as_fields_are_corrected(): void
    {
        Livewire::test(ContactForm::class)
            ->call('submit')
            ->assertHasErrors(['name', 'phone', 'email'])
            ->set('name', 'Иван Иванов')
            ->assertHasNoErrors('name')
            ->assertHasErrors(['phone', 'email'])
            ->set('phone', '900 00 00 00')
            ->assertHasNoErrors()
            ->assertSeeHtml('bg-blue-600')
            ->call('submit')
            ->assertSet('sent', true)
            ->set('name', 'Ещё одна заявка')
            ->assertSet('sent', false)
            ->assertHasNoErrors();
    }

    public function test_contact_form_rejects_invalid_formats(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', '1в@н0в')
            ->set('phone', '987 65 43 2')
            ->set('email', 'Ikrom.OVR!evolet.co.uk')
            ->call('submit')
            ->assertHasErrors(['name' => 'regex', 'phone' => 'regex', 'email' => 'email'])
            ->assertSee('Поле имеет неверный формат');

        $this->assertSame(0, ContactRequest::count());
    }

    public function test_enroll_modal_registers_for_the_chosen_course(): void
    {
        $course = Course::first();

        Livewire::test(EnrollForm::class)
            ->assertDontSee('Регистрация на курс')
            ->dispatch('enroll', course: $course->id)
            ->assertSet('open', true)
            ->assertSee('Регистрация на курс')
            ->set('name', 'Иван Иванов')
            ->set('email', 'ivan@example.com')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('sent', true);

        $request = ContactRequest::sole();
        $this->assertSame($course->id, $request->course_id);
        $this->assertNull($request->phone);
        $this->assertStringContainsString($course->title, $request->message);
    }

    public function test_enroll_modal_ignores_unknown_course(): void
    {
        Livewire::test(EnrollForm::class)
            ->dispatch('enroll', course: 999999)
            ->assertSet('open', false);
    }

    public function test_employee_video_block_is_shown_only_with_a_link(): void
    {
        $employee = Employee::visible()->first();

        $this->get(route('employees.show', $employee))->assertDontSee('youtube.com/watch');

        $employee->update(['video_title' => 'Уроки в начальной школе', 'video_url' => 'https://www.youtube.com/watch?v=test']);

        $this->get(route('employees.show', $employee))
            ->assertSee('Уроки в начальной школе')
            ->assertSee('https://www.youtube.com/watch?v=test', false);
    }

    public function test_gallery_shows_videos_with_a_player(): void
    {
        $gallery = Gallery::visible()->first();
        $gallery->update(['images' => [...$gallery->images, 'galleries/clip.mp4']]);

        $this->get(route('galleries.show', $gallery))
            ->assertSee('8 фото и видео')
            ->assertSee('<video', false)
            ->assertSee('galleries/clip.mp4', false);
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
            ['/admin/content'], ['/admin/users'], ['/admin/users/create'], ['/admin/users/1/edit'],
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
            ->set('data.stats', [['value' => '777+', 'label_ru' => 'Выпускников', 'label_tj' => null]])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('777+', Setting::get('stats')[0]['value'] ?? null);
        $this->get('/')->assertSee('777+')->assertSee('Выпускников');
    }

    public function test_content_is_shown_in_the_page_language_with_russian_fallback(): void
    {
        $course = Course::first();
        $course->update(['title' => ['ru' => 'Математика', 'tj' => 'Риёзиёт'], 'description' => ['ru' => 'Только по-русски']]);

        $this->assertSame(6, Course::count(), 'one record per course, not one per language');

        $this->get(route('courses.show', $course))->assertSee('Математика')->assertDontSee('Риёзиёт');

        app()->setLocale('tj');
        $course->refresh();

        $this->assertSame('Риёзиёт', $course->title);
        $this->assertSame('Только по-русски', $course->description);
    }

    public function test_admin_edits_all_languages_in_one_form(): void
    {
        $this->actingAs(User::first());
        $course = Course::first();

        Livewire::test(EditCourse::class, ['record' => $course->getRouteKey()])
            ->assertSet('data.title.ru', $course->tr('title', 'ru'))
            ->set('data.title.tj', 'Тайёрӣ ба мактаб')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('Тайёрӣ ба мактаб', $course->fresh()->tr('title', 'tj'));
        $this->assertSame($course->tr('title', 'ru'), $course->fresh()->tr('title', 'ru'));
    }

    public function test_admin_requires_the_russian_text(): void
    {
        $this->actingAs(User::first());

        Livewire::test(CreateFaq::class)
            ->set('data.question.tj', 'Савол')
            ->set('data.answer.ru', 'Ответ')
            ->call('create')
            ->assertHasErrors(['data.question.ru' => 'required']);
    }

    public function test_content_page_edits_header_and_footer(): void
    {
        $this->actingAs(User::first());

        Livewire::test(Content::class)
            ->assertSet('data.menu.about.title.tj', 'Дар бораи мо')
            ->assertSet('data.form.title.ru', 'Свяжитесь с нами')
            ->set('data.menu.courses.title.ru', 'Наши курсы')
            ->assertSet('data.header.locales.ru', 'Ru')
            ->set('data.header.button.ru', 'Позвоните нам')
            ->set('data.header.locales.ru', 'РУС')
            ->set('data.form.title.ru', 'Напишите нам')
            ->set('data.footer.services_title.ru', 'Ещё у нас есть')
            ->set('data.footer.services', [
                ['text' => ['ru' => 'Логопед', 'tj' => 'Логопед'], 'url' => '/services'],
                ['text' => ['ru' => 'Психолог', 'tj' => null], 'url' => 'https://example.com/psy'],
                ['text' => ['ru' => 'КафеСити', 'tj' => null], 'url' => null],
            ])
            ->set('data.phone', '+992 222 22 22 22')
            ->set('data.license_file', ['license/license.pdf'])
            ->call('save')
            ->assertHasNoErrors();

        $this->get('/faq')
            ->assertSee('Наши курсы')
            ->assertSee('Позвоните нам')
            ->assertSee('РУС')
            ->assertSee('Напишите нам')
            ->assertSee('Ещё у нас есть')
            ->assertSee('+992 222 22 22 22')
            ->assertSeeHtml('href="/services"')
            ->assertSeeHtml('href="https://example.com/psy"')
            ->assertSee('<div class="text-blue-600">КафеСити</div>', false)
            ->assertSee('Вск - выходной')
            ->assertSee('/storage/license/license.pdf', false);

        app()->setLocale('tj');
        $this->assertSame('/tj/services', SiteContent::link('/services'));
        $this->assertSame('https://example.com/psy', SiteContent::link('https://example.com/psy'));
    }

    public function test_unpublished_page_is_hidden_from_the_menu_and_not_available(): void
    {
        $this->actingAs(User::first());

        Livewire::test(Content::class)
            ->set('data.menu.camp.published', false)
            ->assertHasNoErrors()
            ->assertNotified('Страница скрыта');

        $this->assertFalse(Setting::get('menu.camp.published'), 'saved without the "Сохранить" button');
        $this->get('/camp')->assertNotFound();
        $this->get('/about')->assertOk()->assertDontSee(route('camp').'"', false);
    }
}
