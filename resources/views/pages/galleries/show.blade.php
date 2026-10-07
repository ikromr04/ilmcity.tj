@extends('layouts.app')

@section('title', $gallery->title)

@section('content')
    <main class="courses-page container">
        <x-back-link
            :href="route('galleries')"
            :title="$gallery->date?->format('d.m.Y') ?? $gallery->title"
            :aside="count($gallery->items).' '.__('фото').' '.__('и видео')"
        >
            {{ __('Вернуться в галерею') }}
        </x-back-link>

        <div class="section grid grid-cols-3 gap-1 md:grid-cols-4 md:gap-2">
            @foreach ($gallery->items as $item)
                <a class="flex aspect-square overflow-hidden" href="{{ $item['url'] }}" target="_blank">
                    <x-gallery-media :item="$item" :alt="$gallery->title" />
                </a>
            @endforeach
        </div>
    </main>
@endsection
