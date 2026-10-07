@extends('layouts.app')

@section('title', __('Главная'))

@php
    use App\Helper;
    use App\Models\Setting;

    $locale = app()->getLocale();
    $stats = Setting::get('stats') ?: [
        ['value' => '130+', 'label_ru' => 'Постоянных учеников', 'label_tj' => 'Хонандагони доимӣ'],
        ['value' => '60+', 'label_ru' => 'Илмсити клаб', 'label_tj' => 'Илмсити клаб'],
        ['value' => '60+', 'label_ru' => 'Лагеря', 'label_tj' => 'Лагер'],
    ];

    /** Advantage cards cycle through these accents in the design. */
    $accents = [
        ['bg' => 'bg-green-50', 'icon' => 'rocket', 'size' => [52, 52]],
        ['bg' => 'bg-blue-50', 'icon' => 'pencil-bubble', 'size' => [49, 55]],
        ['bg' => 'bg-red-50', 'icon' => 'heart-care', 'size' => [55, 55]],
    ];
@endphp

@section('content')
    <main class="home main-page">
        <h1 class="title-1 container">
            {{ __('Центр интеллекта, творчества и саморазвития!') }}
        </h1>

        <div class="container grid grid-cols-[auto_1fr_1fr] gap-2 md:grid-cols-[1fr_1fr_1fr] md:gap-3 xl:grid-cols-[286px_1fr] xl:gap-4 xl:mb-20 2xl:grid-cols-[320px_1fr]">
            @foreach ($stats as $stat)
                <div class="{{ $loop->first ? 'bg-blue-600 text-gray-50' : 'bg-yellow-300' }} flex flex-col justify-center gap-1 rounded-xl border border-gray-300 shadow py-3 px-4 md:rounded-[20px] md:p-6 xl:h-32 2xl:h-36 2xl:p-8 2xl:rounded-[28px]">
                    <div class="text-xl font-semibold leading-none md:text-[32px] xl:text-[40px] 2xl:text-[48px]">{{ $stat['value'] }}</div>
                    <div class="text-sm leading-[1.2] md:text-[20px]">
                        {{ ($stat["label_{$locale}"] ?? null) ?: $stat['label_ru'] }}
                    </div>
                </div>
            @endforeach

            <div
                class="relative col-span-3 rounded-xl border border-gray-300 shadow overflow-hidden mb-6 bg-gray-800 md:mb-16 md:rounded-[20px] xl:col-start-2 xl:row-start-1 xl:row-span-3 xl:m-0 xl:h-[416px] 2xl:h-[464px] 2xl:rounded-[28px]"
                x-data="{ playing: false }"
            >
                <video class="flex w-full h-full object-cover" src="{{ Helper::media(Setting::get('video'), 'vitrin.mp4') }}" playsinline preload="metadata" x-ref="video" x-bind:controls="playing" x-on:pause="playing = false" x-on:play="playing = true"></video>

                <button
                    class="absolute inset-0 m-auto flex items-center justify-center size-16 rounded-full bg-gray-800/60 border-none text-white cursor-pointer duration-150 hover:bg-gray-800/80 md:size-24"
                    type="button"
                    aria-label="{{ __('Смотреть видео') }}"
                    x-show="!playing"
                    x-on:click="$refs.video.play()"
                >
                    <svg class="ml-1 w-6 md:w-8" viewBox="0 0 24 28" fill="currentColor" aria-hidden="true">
                        <path d="M24 14 0 28V0z" />
                    </svg>
                </button>
            </div>
        </div>

        <a class="flex items-center justify-center min-h-10 rounded-lg font-medium text-sm no-underline text-inherit bg-yellow-300 md:hidden container mb-11" href="#contact">
            {{ App\Support\SiteContent::text('header.button') }}
        </a>

        @if ($courses->isNotEmpty())
            <section class="section container">
                <h2 class="title-2">
                    {{ __('Подарите ребенку яркое будущее с нашими курсами!') }}
                </h2>

                <ul class="list-none p-6 m-0 rounded-2xl border border-gray-300 shadow bg-yellow-50 flex flex-col gap-2 xl:grid xl:grid-cols-3 xl:gap-4 xl:bg-transparent xl:p-0 xl:shadow-none xl:border-none">
                    @foreach ($courses as $course)
                        <x-course-card :course="$course" />
                    @endforeach
                </ul>
            </section>
        @endif

        <section class="section container">
            <h2 class="title-2">
                {{ __('Потенциал каждого ребенка — путь к успеху в IlmCity') }}
            </h2>

            <div class="flex flex-col gap-3 md:grid md:grid-cols-3 xl:grid-cols-[1fr_596px] xl:gap-4 xl:items-center 2xl:grid-cols-[680px_1fr]">
                <img class="flex aspect-square object-cover w-full h-auto rounded-2xl border border-gray-300 shadow md:row-span-2 md:h-full xl:aspect-auto xl:h-[340px] xl:rounded-[20px] 2xl:h-[368px] 2xl:rounded-[28px]" src="{{ asset('images/girl.jpg') }}" width="252" height="252" alt="{{ __('Девочка рисует') }}">

                <p class="card m-0 md:col-span-2 xl:col-span-1 md:self-end card-text">
                    {{ __('"IlmCity" — это пространство, где каждый ребенок получает поддержку, мотивацию и знания, необходимые для достижения своих целей и уверенного движения в будущее.') }}
                </p>

                <p class="card m-0 md:col-span-2 xl:col-span-1 md:self-start card-text xl:-mt-4 xl:self-start">
                    {{ __('Мы стремимся к тому, чтобы каждый наш ученик чувствовал себя важной частью общества и был готов вносить свой вклад в его развитие, реализуя свои мечты и амбиции.') }}
                </p>
            </div>
        </section>

        @if ($advantages->isNotEmpty())
            <section class="section container">
                <h2 class="title-2">
                    {{ __('Инвестиции в будущее: ценности, формирующие личность в IlmCity') }}
                </h2>

                <div class="invest lift swiper">
                    <x-carousel-arrows name="invest" />

                    <div class="swiper-wrapper">
                        @foreach ($advantages as $advantage)
                            @php($accent = $accents[$loop->index % count($accents)])

                            <div class="swiper-slide h-auto!">
                                <article class="card h-full {{ $accent['bg'] }}">
                                    <h3 class="card-title">
                                        {{ $advantage->title }}

                                        <svg class="shrink-0" width="{{ $accent['size'][0] }}" height="{{ $accent['size'][1] }}">
                                            <use xlink:href="#{{ $accent['icon'] }}" />
                                        </svg>
                                    </h3>

                                    <p class="card-text">
                                        {{ $advantage->text }}
                                    </p>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if ($teachers->isNotEmpty())
            <section class="section container">
                <h2 class="title-2">
                    {{ __('Лучшие преподаватели для вашего ребенка') }}
                </h2>

                <ul class="list-none p-0 m-0 gap-3 flex flex-col md:grid md:grid-cols-2 xl:grid-cols-3 xl:gap-4">
                    @foreach ($teachers as $teacher)
                        <x-employee-card :employee="$teacher" />
                    @endforeach
                </ul>
            </section>
        @endif

        @if ($news->isNotEmpty())
            <section class="section container">
                <h2 class="title-2">
                    {{ __('Новости IlmCity: мы растем и развиваемся для ваших детей!') }}
                </h2>

                <div class="news lift swiper">
                    <x-carousel-arrows name="news" />

                    <div class="swiper-wrapper">
                        @foreach ($news as $item)
                            <div class="swiper-slide h-auto!">
                                <article class="card h-full bg-gray-50 duration-300 [.is-center_&]:bg-blue-50">
                                    <img class="card-image aspect-[346/290]" src="{{ $item->image_url }}" width="346" height="290" alt="{{ $item->title }}">

                                    <h3 class="card-title">
                                        {{ $item->title }}
                                    </h3>

                                    <p class="card-text">
                                        {{ $item->excerpt }}
                                    </p>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if ($partners->isNotEmpty())
            <section class="section">
                <h2 class="title-2 container">
                    {{ __('Мы сотрудничаем с лучшими') }}
                </h2>

                <div class="partners swiper bg-green-100">
                    <div class="swiper-wrapper p-4">
                        {{-- Repeat logos so the looped slider always has enough slides to fill wide screens --}}
                        @foreach (range(1, max(1, (int) ceil(12 / $partners->count()))) as $round)
                            @foreach ($partners as $partner)
                                <div class="swiper-slide w-auto!">
                                    @if ($partner->url)
                                        <a class="flex" href="{{ $partner->url }}" target="_blank" rel="noopener">
                                    @endif
                                    <img class="flex w-[232px] h-32 object-contain p-2 border border-gray-300 rounded-xl" src="{{ $partner->logo_url }}" width="232" height="128" alt="{{ $partner->name }}">
                                    @if ($partner->url)
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if ($reviews->isNotEmpty())
            <section class="section container">
                <h2 class="title-2">
                    {{ __('Отзывы родителей:') }} <br>
                    {{ __('IlmCity — выбор профессионалов') }}
                </h2>

                <div class="reviews lift swiper">
                    <x-carousel-arrows name="reviews" />

                    <div class="swiper-wrapper">
                        @foreach ($reviews as $review)
                            <div class="swiper-slide h-auto!">
                                <article class="card h-full bg-yellow-50">
                                    <h3 class="card-title">
                                        {{ $review->title }}

                                        <svg class="shrink-0" width="52" height="52">
                                            <use xlink:href="#rocket" />
                                        </svg>
                                    </h3>

                                    <p class="card-text">
                                        {{ $review->text }}
                                    </p>

                                    <div class="flex items-center gap-4 mt-auto pt-6">
                                        <img class="flex border border-gray-400 rounded-full bg-gray-300 object-cover w-20 h-20 min-w-20" src="{{ $review->photo_url }}" width="80" height="80" alt="{{ $review->author_name }}">
                                        <div class="leading-[1.2]">
                                            <div class="text-lg font-semibold mb-1 2xl:text-[24px] 2xl:mb-2">{{ $review->author_name }}</div>
                                            <div class="2xl:text-[20px]">{{ $review->author_caption }}</div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection
