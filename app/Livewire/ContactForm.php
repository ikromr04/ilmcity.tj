<?php

namespace App\Livewire;

use App\Livewire\Concerns\HandlesContactRequest;
use Livewire\Component;

class ContactForm extends Component
{
    use HandlesContactRequest;

    public string $message = '';

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            ...$this->contactRules(),
            'message' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function submit(): void
    {
        if ($this->storeContactRequest(['message' => $this->message ?: null])) {
            $this->reset('message');
        }
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
