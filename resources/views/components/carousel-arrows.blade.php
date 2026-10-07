@props(['name'])

<div class="hidden xl:flex absolute top-0 right-7 z-10 gap-2">
    <button class="{{ $name }}-prev flex p-0 border-none bg-transparent text-gray-300 cursor-pointer duration-150 hover:text-gray-500" type="button" aria-label="{{ __('Назад') }}">
        <svg class="rotate-180" width="16" height="24">
            <use xlink:href="#arrow-right" />
        </svg>
    </button>
    <button class="{{ $name }}-next flex p-0 border-none bg-transparent text-gray-300 cursor-pointer duration-150 hover:text-gray-500" type="button" aria-label="{{ __('Вперёд') }}">
        <svg width="16" height="24">
            <use xlink:href="#arrow-right" />
        </svg>
    </button>
</div>
