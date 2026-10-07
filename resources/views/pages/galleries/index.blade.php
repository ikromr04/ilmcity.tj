@extends('layouts.app')

@section('title', __('Галерея'))

@section('content')
    <main class="courses-page container">
        <h1 class="title-1 normal-case">
            {{ __('Фотогалерея') }}
        </h1>

        <div class="section grid gap-4 xl:grid-cols-2">
            @foreach ($galleries as $gallery)
                @php($items = $gallery->items)

                <a class="card bg-gray-50 text-inherit no-underline group 2xl:p-7" href="{{ route('galleries.show', $gallery) }}">
                    <div class="md:grid md:grid-cols-[2.68fr_1fr_1fr_1fr] md:grid-rows-2 md:gap-1 rounded-xl overflow-hidden md:aspect-[592/290] 2xl:rounded-2xl">
                        <div class="overflow-hidden relative rounded-lg flex flex-col gap-1 md:row-span-2 md:rounded-none">
                            <div class="relative overflow-hidden grow aspect-[4/3] md:aspect-auto">
                                @if ($items)
                                    <x-gallery-media class="absolute inset-0 duration-150 group-hover:scale-[1.2]" :item="$items[0]" :alt="$gallery->title" />
                                @endif
                            </div>

                            <div class="grid grid-cols-[1fr_56px] bg-gray-100">
                                <div class="text-xs py-2 px-3">
                                    <div class="font-semibold">
                                        {{ $gallery->date?->format('d.m.Y') }}
                                    </div>
                                    <div>
                                        {{ $gallery->title }}
                                    </div>
                                </div>
                                <div class="flex items-center justify-center bg-yellow-300 text-[8px] text-center leading-[1.2]">
                                    {{ count($items) }} {{ __('фото') }} <br> {{ __('и видео') }}
                                </div>
                            </div>
                        </div>

                        @foreach (array_slice($items, 1, 6) as $item)
                            <div class="relative overflow-hidden hidden md:block">
                                <x-gallery-media class="absolute inset-0 duration-150 group-hover:scale-[1.2]" :item="$item" />
                            </div>
                        @endforeach
                    </div>
                </a>
            @endforeach
        </div>
    </main>
@endsection
