<?php

namespace App\Livewire;

use App\Models\ContactRequest;
use App\Models\Course;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required_without:email|nullable|string|max:50')]
    public string $phone = '';

    #[Validate('required_without:phone|nullable|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:5000')]
    public string $message = '';

    public ?int $courseId = null;

    public bool $sent = false;

    /** Livewire requests have no locale prefix, so keep the page locale. */
    public string $locale = '';

    public function mount(): void
    {
        $this->locale = app()->getLocale();
    }

    public function hydrate(): void
    {
        app()->setLocale($this->locale);
    }

    /**
     * Fired by the "Записаться" buttons: prefill the message with the chosen course.
     */
    #[On('enroll')]
    public function enroll(int $course): void
    {
        $course = Course::find($course);

        if (! $course) {
            return;
        }

        $this->courseId = $course->id;
        $this->message = __('Хочу записаться на курс «:course»', ['course' => $course->title]);
        $this->sent = false;
    }

    public function submit(): void
    {
        $this->validate();

        $key = 'contact-form:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('name', __('Слишком много заявок. Попробуйте позже.'));

            return;
        }

        RateLimiter::hit($key, 600);

        ContactRequest::create([
            'name' => $this->name,
            'phone' => $this->phone ?: null,
            'email' => $this->email ?: null,
            'message' => $this->message ?: null,
            'course_id' => $this->courseId,
            'locale' => app()->getLocale(),
        ]);

        $this->reset('name', 'phone', 'email', 'message', 'courseId');
        $this->sent = true;
    }

    public function validationAttributes(): array
    {
        return [
            'name' => __('ФИО'),
            'phone' => __('Тел'),
            'email' => 'Email',
            'message' => __('Сообщение'),
        ];
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
