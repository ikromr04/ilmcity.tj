@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <main class="courses-page container">
        <x-back-link :href="route('courses')" :title="$course->title">
            {{ __('Вернуться') }}
        </x-back-link>

        <x-banner :image="$course->banner_url" :alt="$course->title">
            <div class="mb-4">
                @if ($course->banner_title)
                    <h2 class="text-lg font-semibold mt-0 mb-3 leading-[1.2]">{{ $course->banner_title }}</h2>
                @endif
                @if ($course->banner_text)
                    <p class="m-0">{{ $course->banner_text }}</p>
                @endif
                @if ($course->price)
                    <br>
                    <p class="m-0">{{ __('Цена:') }} <span class="font-semibold">{{ $course->price }}</span></p>
                @endif
                @if ($course->duration)
                    <br>
                    <p class="m-0">{{ __('Длительность:') }} <span class="font-semibold">{{ $course->duration }}</span></p>
                @endif
            </div>

            <button
                class="flex items-center justify-center min-h-10 rounded-lg font-medium text-sm no-underline text-inherit bg-yellow-300 px-4 w-max border-none cursor-pointer"
                type="button"
                x-data
                x-on:click="Livewire.dispatch('enroll', { course: {{ $course->id }} }); $dispatch('enroll')"
            >
                {{ __('Записаться на курс') }}
            </button>
        </x-banner>

        @if ($course->content_title || filled($course->blocks))
            <div class="mb-8 md:mb-16 xl:mb-20">
                <section>
                    @if ($course->content_title)
                        <h2 class="text-lg mt-0 font-semibold mb-6 leading-[1.2] md:text-[32px] md:mb-8 xl:text-[40px] xl:mb-10">
                            {{ $course->content_title }}
                        </h2>
                    @endif

                    <ul class="list-none p-0 m-0 flex flex-col gap-3 md:grid md:grid-cols-2">
                        @foreach ($course->blocks ?? [] as $block)
                            <li class="flex flex-col p-6 gap-4 rounded-2xl border border-gray-300">
                                <img class="flex w-full h-auto" src="{{ \App\Helper::media($block['image'] ?? null, 'images/cert.png') }}" alt="{{ $block['title'] }}">
                                <h3 class="font-semibold text-lg mt-0 pb-4 mb-4 border-gray-400 border-b leading-none">
                                    {{ $block['title'] }}
                                </h3>
                                <ul>
                                    @foreach (preg_split('/\R/', trim($block['items'] ?? '')) as $item)
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
            <section class="mb-8 md:mb-16 xl:mb-20">
                <h2 class="text-lg mt-0 font-semibold mb-6 leading-[1.2] md:text-[32px] md:mb-8 xl:text-[40px] xl:mb-10">
                    {{ __('Преподаватели') }}
                </h2>

                <ul class="list-none p-0 m-0 flex flex-col gap-3 md:grid md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($course->employees as $employee)
                        <x-employee-card :employee="$employee" />
                    @endforeach
                </ul>
            </section>
        @endif
    </main>
@endsection
