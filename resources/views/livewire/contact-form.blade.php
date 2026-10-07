<form
  class="bg-yellow-300 text-gray-800 p-6 flex flex-col rounded-2xl xl:py-11 xl:pl-[90px] xl:pr-[60px] xl:grid xl:grid-cols-3 gap-3"
  id="contact"
  wire:submit="submit"
  x-data
  x-on:enroll.window="$nextTick(() => $el.scrollIntoView({ behavior: 'smooth' }))"
>
  <h2 class="text-lg font-semibold mb-6 mt-0 md:text-[32px] xl:col-span-3">{{ __('Свяжитесь с нами') }}</h2>

  @if ($sent)
    <p class="m-0 -mt-3 mb-3 font-medium xl:col-span-3" role="status">
      {{ __('Спасибо! Ваша заявка отправлена, мы скоро свяжемся с вами.') }}
    </p>
  @endif

  <div class="mb-3">
    <label class="flex leading-none font-medium mb-2 text-xs" for="name">{{ __('ФИО') }}</label>
    <input class="flex w-full min-h-10 md:min-h-[52px] items-center px-3 shadow bg-white border-none rounded-[10px]" id="name" type="text" wire:model="name" autocomplete="name">
    @error('name') <span class="flex mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
  </div>

  <div class="md:grid md:grid-cols-2 md:gap-3 xl:col-span-2">
    <div class="mb-3">
      <label class="flex leading-none font-medium mb-2 text-xs" for="tel">{{ __('Тел:') }}</label>
      <input class="flex w-full min-h-10 md:min-h-[52px] items-center px-3 shadow bg-white border-none rounded-[10px] placeholder:text-gray-300" type="tel" id="tel" placeholder="987 65 43 21" wire:model="phone" autocomplete="tel">
      @error('phone') <span class="flex mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
      <label class="flex leading-none font-medium mb-2 text-xs" for="email">Email</label>
      <input class="flex w-full min-h-10 md:min-h-[52px] items-center px-3 shadow bg-white border-none rounded-[10px]" id="email" type="text" wire:model="email" autocomplete="email">
      @error('email') <span class="flex mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
    </div>
  </div>

  <div class="mb-8 xl:col-span-3 xl:mb-0">
    <label class="flex leading-none font-medium mb-2 text-xs" for="message">{{ __('Сообщение') }}</label>
    <textarea class="flex w-full xl:h-[52px] min-h-10 md:min-h-[52px] items-center px-3 shadow bg-white border-none rounded-[10px] resize-y" id="message" cols="30" rows="10" wire:model="message"></textarea>
    @error('message') <span class="flex mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
  </div>

  <button class="flex items-center min-h-10 md:min-h-[52px] text-white bg-blue-600 p-0 border-none justify-center rounded-[10px] font-bold text-[16px] mb-2 xl:col-start-2 cursor-pointer disabled:opacity-70" type="submit" wire:loading.attr="disabled">
    {{ __('Отправить') }}
  </button>
</form>
