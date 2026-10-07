<div>
  @if ($open)
    <div
      class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto px-3 py-20 bg-gray-50/60 backdrop-blur-sm md:items-center"
      role="dialog"
      aria-modal="true"
      aria-labelledby="enroll-title"
      wire:click.self="close"
      x-data
      x-on:keydown.escape.window="$wire.close()"
      x-init="$nextTick(() => $el.querySelector('input')?.focus())"
    >
      <form class="flex flex-col gap-6 w-full max-w-[507px] p-6 bg-yellow-300 rounded-[20px] shadow md:p-11 md:rounded-[28px]" wire:submit="submit">
        <div class="flex items-center justify-between gap-4">
          <h2 class="m-0 text-lg font-semibold leading-[1.2] md:text-[24px]" id="enroll-title">{{ __('Регистрация на курс') }}</h2>

          <button class="flex items-center justify-center shrink-0 w-8 h-[29px] p-0 border-none bg-transparent text-gray-800 cursor-pointer" type="button" aria-label="{{ __('Закрыть') }}" wire:click="close">
            <svg width="16" height="14">
              <use xlink:href="#close" />
            </svg>
          </button>
        </div>

        @if ($sent)
          <x-form-success :after="4000" then="$wire.close()" />
        @else
          <div class="flex flex-col gap-4">
            <x-field id="enroll-name" model="name" :label="App\Support\SiteContent::text('form.name')" autocomplete="name" />
            <x-phone-field id="enroll-phone" />
            <x-field id="enroll-email" model="email" :label="App\Support\SiteContent::text('form.email')" autocomplete="email" />
          </div>

          <x-submit-button />
        @endif
      </form>
    </div>
  @endif
</div>
