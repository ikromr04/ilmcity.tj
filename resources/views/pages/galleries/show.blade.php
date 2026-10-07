@extends('layouts.app')

@section('title', $gallery->title)

@section('content')
    <main class="courses-page container">
        <x-back-link :href="route('galleries')" :title="$gallery->date?->format('d.m.Y') ?? $gallery->title">
            {{ __('Вернуться в галерею') }}
        </x-back-link>

        <div class="grid grid-cols-3 gap-1 mb-6 md:mb-16 xl:mb-20 md:grid-cols-4">
            @foreach ($gallery->image_urls as $image)
                <a href="{{ $image }}" target="_blank">
                    <img class="object-cover flex w-full h-full" src="{{ $image }}" width="324" height="324" alt="{{ $gallery->title }}" loading="lazy">
                </a>
            @endforeach
        </div>
    </main>
@endsection
