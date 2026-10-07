@props(['href', 'title'])

<div class="mt-11 mb-6 md:mt-16 md:mb-8 xl:mt-20 xl:mb-10 flex items-center justify-between">
    <a class="flex items-center no-underline text-inherit gap-2" href="{{ $href }}">
        <svg class="text-gray-300 rotate-180" width="16" height="24">
            <use xlink:href="#arrow-right" />
        </svg>
        {{ $slot }}
    </a>
    <h1 class="text-[16px] font-normal m-0">{{ $title }}</h1>
</div>
