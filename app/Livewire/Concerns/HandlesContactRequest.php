<?php

namespace App\Livewire\Concerns;

use App\Models\ContactRequest;
use App\Support\SiteContent;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

/**
 * Shared fields, validation and persistence of the site's request forms.
 */
trait HandlesContactRequest
{
    public string $name = '';

    /** Nine local digits; the +992 prefix is shown in the input. */
    public string $phone = '';

    public string $email = '';

    public bool $sent = false;

    /** Livewire requests have no locale prefix, so keep the page locale. */
    public string $locale = '';

    public function mountHandlesContactRequest(): void
    {
        $this->locale = app()->getLocale();
    }

    public function hydrateHandlesContactRequest(): void
    {
        app()->setLocale($this->locale);
    }

    /**
     * After a failed submit, re-checks a field as it is corrected, so its error
     * (and the grey submit button) goes away without submitting again.
     */
    public function updated(string $property): void
    {
        if (! array_key_exists($property, $this->rules())) {
            return;
        }

        // Typing a new request hides the "sent" message of the previous one.
        $this->sent = false;

        if (! $this->getErrorBag()->any()) {
            return;
        }

        // Phone and email depend on each other (one of them is enough).
        $fields = in_array($property, ['phone', 'email'], true) ? ['phone', 'email'] : [$property];

        $validator = Validator::make(
            $this->only($fields),
            array_intersect_key($this->rules(), array_flip($fields)),
            $this->messages(),
            $this->validationAttributes(),
        );

        $this->resetValidation($fields);

        foreach ($validator->errors()->messages() as $field => $messages) {
            $this->addError($field, $messages[0]);
        }
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function contactRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s.\'’-]+$/u'],
            'phone' => ['required_without:email', 'nullable', 'string', 'regex:/^(\d\s*){9}$/'],
            'email' => ['required_without:phone', 'nullable', 'email', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.required_without' => __('Укажите телефон или email'),
            'email.required_without' => __('Укажите телефон или email'),
            'name.regex' => __('Поле имеет неверный формат'),
            'phone.regex' => __('Поле имеет неверный формат'),
            'email.email' => __('Поле имеет неверный формат'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function validationAttributes(): array
    {
        return [
            'name' => SiteContent::text('form.name'),
            'phone' => __('Тел'),
            'email' => SiteContent::text('form.email'),
            'message' => SiteContent::text('form.message'),
        ];
    }

    /**
     * Validates the form and stores the request; returns false when rate limited.
     *
     * @param  array{message?: string|null, course_id?: int|null}  $attributes
     */
    protected function storeContactRequest(array $attributes = []): bool
    {
        $this->validate();

        $key = 'contact-form:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('name', __('Слишком много заявок. Попробуйте позже.'));

            return false;
        }

        RateLimiter::hit($key, 600);

        ContactRequest::create([
            'name' => $this->name,
            'phone' => $this->phone ? '+992 '.preg_replace('/\D/', '', $this->phone) : null,
            'email' => $this->email ?: null,
            'locale' => app()->getLocale(),
            ...$attributes,
        ]);

        $this->reset('name', 'phone', 'email');
        $this->sent = true;

        return true;
    }
}
