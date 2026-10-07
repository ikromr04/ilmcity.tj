@extends('layouts.app')

@section('title', __('Галерея'))

@section('content')
    <main class="courses-page container">
        <h1 class="text-lg font-semibold leading-[1.2] mt-11 mb-6 md:mt-16 md:mb-8 xl:mt-20 xl:mb-10 md:text-[32px] xl:text-[48px]">
            {{ __('Фотогалерея') }}
        </h1>

        <div class="mb-8 md:mb-16 xl:mb-20 grid gap-4 xl:grid-cols-2">
            @foreach ($galleries as $gallery)
                @php($images = $gallery->image_urls)

                <a class="grid p-6 text-inherit no-underline border-gray-300 border rounded-xl group" href="{{ route('galleries.show', $gallery) }}">
                    <div class="md:grid md:grid-cols-5 md:gap-1 md:rounded-xl overflow-hidden">
                        <div class="overflow-hidden relative rounded-lg flex flex-col gap-1 group md:col-span-2 md:rounded-none">
                            <div class="relative overflow-hidden grow">
                                @if ($images)
                                    <img class="w-full h-full object-cover duration-150 group-hover:scale-[1.2]" src="{{ $images[0] }}" alt="{{ $gallery->title }}">
                                @endif
                            </div>

                            <div class="grid grid-cols-[1fr_56px] bg-gray-100">
                                <div class="text-xs py-2 px-3">
                                    <div class="font-bold">
                                        {{ $gallery->date?->format('d.m.Y') }}
                                    </div>
                                    <div>
                                        {{ $gallery->title }}
                                    </div>
                                </div>
                                <div class="flex items-center justify-center bg-yellow-300 text-[8px] text-center">
                                    {{ count($images) }} {{ __('фото') }} <br> {{ __('и видео') }}
                                </div>
                            </div>
                        </div>

                        <div class="grid-cols-3 gap-1 overflow-hidden hidden md:grid md:col-span-3">
                            @foreach (array_slice($images, 1, 6) as $image)
                                <div class="relative overflow-hidden">
                                    <img class="w-full h-full object-cover duration-150 group-hover:scale-[1.2]" src="{{ $image }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </main>
@endsection
