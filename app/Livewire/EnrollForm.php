<?php

namespace App\Livewire;

use App\Livewire\Concerns\HandlesContactRequest;
use App\Models\Course;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * "Регистрация на курс" modal, opened by the "Записаться" buttons.
 */
class EnrollForm extends Component
{
    use HandlesContactRequest;

    public ?int $courseId = null;

    public bool $open = false;

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return $this->contactRules();
    }

    #[On('enroll')]
    public function enroll(int $course): void
    {
        if (! Course::whereKey($course)->exists()) {
            return;
        }

        $this->courseId = $course;
        $this->sent = false;
        $this->open = true;
        $this->resetValidation();
    }

    public function close(): void
    {
        $this->open = false;
    }

    public function submit(): void
    {
        $course = Course::find($this->courseId);

        $this->storeContactRequest([
            'course_id' => $course?->id,
            'message' => $course ? __('Хочу записаться на курс «:course»', ['course' => $course->title]) : null,
        ]);
    }

    public function render()
    {
        return view('livewire.enroll-form');
    }
}
