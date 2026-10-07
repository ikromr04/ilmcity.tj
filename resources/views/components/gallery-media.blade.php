@props(['item', 'alt' => ''])

@if ($item['is_video'])
    <span class="relative flex w-full h-full">
        <video {{ $attributes->class('w-full h-full object-cover') }} src="{{ $item['url'] }}#t=0.1" preload="metadata" muted playsinline></video>
        <span class="absolute inset-0 m-auto flex items-center justify-center size-12 rounded-full bg-gray-800/60 text-white md:size-24" aria-hidden="true">
            <svg class="ml-1 w-4 md:w-8" viewBox="0 0 24 28" fill="currentColor">
                <path d="M24 14 0 28V0z" />
            </svg>
        </span>
    </span>
@else
    <img {{ $attributes->class('w-full h-full object-cover') }} src="{{ $item['url'] }}" alt="{{ $alt }}" loading="lazy">
@endif
