@props(['id', 'model' => 'phone', 'label' => null])

<div {{ $attributes->class('flex flex-col') }}>
    @if ($label)
        <label class="field-label" for="{{ $id }}">{{ $label }}</label>
    @endif

    <div class="field-input relative p-0 overflow-hidden focus-within:border-blue-600 @error($model) field-input-invalid @enderror">
        <span class="flex items-center gap-2 self-stretch shrink-0 pl-2 pr-2.5 bg-gray-200 text-[16px] font-medium leading-[1.2] md:pl-[9px] md:w-[109px]">
            <span class="flex flex-col shrink-0 size-6 overflow-hidden rounded-md border-[0.25px] border-neutral-700 md:size-8" aria-hidden="true">
                <span class="grow bg-[#fe0000]"></span>
                <span class="grow bg-gray-50"></span>
                <span class="grow bg-[#006600]"></span>
            </span>
            +992
            <svg class="hidden md:block" width="7" height="5" viewBox="0 0 7 5" aria-hidden="true">
                <path d="M3.5 5 0 0h7z" fill="currentColor" />
            </svg>
        </span>

        <input class="grow min-w-0 self-stretch px-3 border-none bg-transparent outline-none text-[length:inherit] placeholder:text-gray-300 md:px-5 md:tracking-[0.05em] @error($model) pr-10 @enderror" id="{{ $id }}" type="tel" inputmode="numeric" placeholder="987 65 43 21" wire:model.live.debounce.400ms="{{ $model }}" autocomplete="tel-national">

        @error($model)
            <x-field-error-icon />
        @enderror
    </div>

    @error($model)
        <span class="field-error">{{ $message }}</span>
    @enderror
</div>
