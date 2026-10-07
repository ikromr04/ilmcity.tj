@props(['image', 'alt' => '', 'position' => 'object-left'])

<div class="section md:relative md:py-14 md:px-12 md:grid-cols-2 md:grid md:items-center md:min-h-[340px] xl:min-h-[416px] 2xl:min-h-[464px] 2xl:px-16">
    <img class="w-full h-[252px] object-cover {{ $position }} rounded-xl border md:mb-0 border-gray-300 shadow {{ $slot->isEmpty() ? '' : 'mb-6 ' }}md:absolute md:left-0 md:top-0 md:h-full md:w-full md:rounded-[20px] 2xl:rounded-[28px]" src="{{ $image }}" width="1118" height="572" alt="{{ $alt }}">

    @if ($slot->isNotEmpty())
        <div class="leading-[1.2] md:z-10 md:col-start-2 md:flex md:flex-col md:justify-center md:max-w-[500px] md:ml-auto xl:text-lg 2xl:text-[20px] 2xl:max-w-[500px]">
            {{ $slot }}
        </div>
    @endif
</div>
