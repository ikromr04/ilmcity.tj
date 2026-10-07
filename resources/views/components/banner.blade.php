@props(['image', 'alt' => '', 'position' => 'object-left'])

<div class="mb-11 md:relative md:py-14 md:px-12 md:grid-cols-2 md:mb-16 md:grid md:items-center md:min-h-[340px] xl:mb-20">
    <img class="w-full h-[252px] object-cover {{ $position }} rounded-xl border md:mb-0 border-gray-300 {{ $slot->isEmpty() ? '' : 'mb-6 ' }}md:absolute md:left-0 md:top-0 md:h-full md:w-full" src="{{ $image }}" width="1118" height="572" alt="{{ $alt }}">

    @if ($slot->isNotEmpty())
        <div class="md:z-10 md:col-start-2 md:flex md:flex-col md:justify-center md:max-w-[500px] md:ml-auto">
            {{ $slot }}
        </div>
    @endif
</div>
