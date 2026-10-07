@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <main class="courses-page container">
        <x-back-link :href="route('courses')" :title="$course->title">
            {{ __('Вернуться') }}
        </x-back-link>

        <x-banner :image="$course->banner_url" :alt="$course->title">
            <div class="flex flex-col gap-3 mb-6 2xl:gap-4">
                @if ($course->banner_title)
                    <h2 class="text-lg font-semibold m-0 leading-[1.2] xl:text-[20px] 2xl:text-[24px]">{{ $course->banner_title }}</h2>
                @endif
                @if ($course->banner_text)
                    <p class="m-0">{{ $course->banner_text }}</p>
                @endif
                @if ($course->price)
                    <p class="m-0">{{ __('Цена:') }} <span class="font-medium">{{ $course->price }}</span></p>
                @endif
                @if ($course->duration)
                    <p class="m-0">{{ __('Длительность:') }} <span class="font-medium">{{ $course->duration }}</span></p>
                @endif
            </div>

            <button
                class="btn btn-yellow"
                type="button"
                x-data
                x-on:click="Livewire.dispatch('enroll', { course: {{ $course->id }} })"
            >
                {{ __('Записаться на курс') }}
            </button>
        </x-banner>

        @if ($course->content_title || filled($course->blocks))
            <div class="section">
                <section>
                    @if ($course->content_title)
                        <h2 class="title-2">
                            {{ $course->content_title }}
                        </h2>
                    @endif

                    <ul class="list-none p-0 m-0 flex flex-col gap-3 md:grid md:grid-cols-2 xl:gap-4">
                        @foreach ($course->blocks ?? [] as $block)
                            <li class="card bg-gray-50">
                                <img class="card-image h-auto" src="{{ \App\Helper::media($block['image'] ?? null, 'images/cert.png') }}" alt="{{ \App\Helper::tr($block['title'] ?? null) }}">
                                <h3 class="card-title">
                                    {{ \App\Helper::tr($block['title'] ?? null) }}
                                </h3>
                                <ul class="card-text pl-7 list-disc marker:text-xs">
                                    @foreach (preg_split('/\R/', trim(\App\Helper::tr($block['items'] ?? null) ?? '')) as $item)
                                        @if (filled($item))
                                            <li>{{ $item }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </section>
            </div>
        @endif

        @if ($course->employees->isNotEmpty())
            <section class="section">
                <h2 class="title-2">
                    {{ __('Преподаватели') }}
                </h2>

                <ul class="list-none p-0 m-0 flex flex-col gap-3 md:grid md:grid-cols-2 xl:grid-cols-3 xl:gap-4">
                    @foreach ($course->employees as $employee)
                        <x-employee-card :employee="$employee" />
                    @endforeach
                </ul>
            </section>
        @endif
    </main>
@endsection
