@props(['href', 'title', 'aside' => null])

<div class="grid grid-cols-[auto_1fr] items-center gap-4 mt-11 mb-6 md:mt-16 md:mb-8 xl:mt-20 xl:mb-20 2xl:text-[20px] {{ $aside ? 'md:grid-cols-3' : '' }}">
    <a class="flex items-center no-underline text-inherit gap-2" href="{{ $href }}">
        <svg class="text-gray-300 rotate-180" width="16" height="24">
            <use xlink:href="#arrow-right" />
        </svg>
        {{ $slot }}
    </a>
    <h1 class="text-[length:inherit] font-normal m-0 text-right {{ $aside ? 'md:text-center' : '' }}">{{ $title }}</h1>
    @if ($aside)
        <div class="hidden md:block text-right">{{ $aside }}</div>
    @endif
</div>
