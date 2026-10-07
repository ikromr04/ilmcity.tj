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
@endphp

@section('content')
    <main class="home main-page">
        <h1 class="text-lg font-semibold container mt-11 mb-6 uppercase leading-none md:text-[32px] md:mt-16 md:mb-8 xl:text-[48px] xl:mt-20 xl:mb-10">
            {{ __('Центр интеллекта, творчества и саморазвития!') }}
        </h1>

        <div class="container grid grid-cols-[auto_1fr_1fr] gap-2 md:grid-cols-[1fr_1fr_1fr] md:gap-3 xl:grid-cols-[300px_1fr] xl:gap-4 xl:mb-20">
            @foreach ($stats as $stat)
                <div class="{{ $loop->first ? 'bg-blue-600 text-white' : 'bg-yellow-300' }} rounded-xl py-3 px-4 xl:p-7 xl:rounded-[20px]">
                    <div class="text-xl font-bold md:text-[32px] xl:text-[40px]">{{ $stat['value'] }}</div>
                    <div class="text-sm md:text-[16px]">
                        {{ ($stat["label_{$locale}"] ?? null) ?: $stat['label_ru'] }}
                    </div>
                </div>
            @endforeach

            <div class="col-span-3 rounded-xl overflow-hidden mb-6 md:mb-16 xl:col-start-2 xl:row-start-1 xl:row-span-3 xl:m-0 xl:h-[437px] xl:rounded-[20px]">
                <video class="flex w-full h-full max-w-full xl:w-full xl:h-auto" controls src="{{ Helper::media(Setting::get('video'), 'vitrin.mp4') }}" muted autoplay playsinline></video>
            </div>
        </div>

        <a class="flex items-center justify-center min-h-10 rounded-lg font-medium text-sm no-underline text-inherit bg-yellow-300 md:hidden container mb-11" href="#contact">
            {{ __('Связаться с нами') }}
        </a>

        @if ($courses->isNotEmpty())
            <section class="container mb-11 md:mb-16 xl:mb-20">
                <h2 class="font-semibold text-lg mt-0 mb-6 md:text-[32px] md:mb-8 leading-none xl:mb-10">
                    {{ __('Подарите ребенку яркое будущее с нашими курсами!') }}
                </h2>

                <ul class="list-none p-6 m-0 rounded-2xl border border-gray-300 shadow bg-yellow-50 flex flex-col gap-2 xl:grid xl:grid-cols-3 xl:gap-4 xl:bg-transparent xl:p-0 xl:shadow-none xl:border-none">
                    @foreach ($courses as $course)
                        <x-course-card :course="$course" />
                    @endforeach
                </ul>
            </section>
        @endif

        <section class="container mb-11 md:mb-16 xl:mb-20">
            <h2 class="font-semibold text-lg mt-0 mb-6 md:text-[32px] md:mb-8 leading-none xl:mb-10">
                {{ __('Потенциал каждого ребенка — путь к успеху в IlmCity') }}
            </h2>

            <div class="flex flex-col gap-3 md:grid md:grid-cols-3 xl:grid-cols-2">
                <img class="flex aspect-square object-cover w-full shadow h-auto rounded-2xl md:row-span-2 md:h-full xl:h-[340px] xl:w-full" src="{{ asset('images/girl.jpg') }}" width="252" height="252" alt="{{ __('Девочка рисует') }}">

                <p class="my-0 border border-gray-200 rounded-2xl p-6 shadow md:col-span-2 xl:col-span-1 md:self-end">
                    {{ __('"IlmCity" — это пространство, где каждый ребенок получает поддержку, мотивацию и знания, необходимые для достижения своих целей и уверенного движения в будущее.') }}
                </p>

                <p class="my-0 border border-gray-200 rounded-2xl p-6 shadow md:col-span-2 xl:col-span-1 md:self-start">
                    {{ __('Мы стремимся к тому, чтобы каждый наш ученик чувствовал себя важной частью общества и был готов вносить свой вклад в его развитие, реализуя свои мечты и амбиции.') }}
                </p>
            </div>
        </section>

        @if ($advantages->isNotEmpty())
            <section class="container mb-11 md:mb-16 xl:mb-20">
                <h2 class="font-semibold text-lg mt-0 mb-6 md:text-[32px] md:mb-8 leading-none xl:mb-10">
                    {{ __('Инвестиции в будущее: ценности, формирующие личность в IlmCity') }}
                </h2>

                <div class="invest swiper">
                    <div class="swiper-wrapper">
                        @foreach ($advantages as $advantage)
                            <div class="swiper-slide">
                                <article class="flex flex-col p-6 rounded-2xl border border-gray-200 bg-blue-50">
                                    <h2 class="text-lg w-full font-semibold flex justify-between items-center border-b border-gray-400 pb-4 mb-4">
                                        {{ $advantage->title }}

                                        <svg width="48" height="44">
                                            <use xlink:href="#rocket" />
                                        </svg>
                                    </h2>

                                    <p class="m-0">
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
            <section class="container mb-11 md:mb-16 xl:mb-20">
                <h2 class="font-semibold text-lg mt-0 mb-6 md:text-[32px] md:mb-8 leading-none xl:mb-10">
                    {{ __('Лучшие преподаватели для вашего ребенка') }}
                </h2>

                <ul class="list-none p-0 m-0 gap-3 flex flex-col md:grid md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($teachers as $teacher)
                        <x-employee-card :employee="$teacher" />
                    @endforeach
                </ul>
            </section>
        @endif

        @if ($news->isNotEmpty())
            <section class="container mb-11 md:mb-16 xl:mb-20">
                <h2 class="font-semibold text-lg mt-0 mb-6 md:text-[32px] md:mb-8 leading-none xl:mb-10">
                    {{ __('Новости IlmCity: мы растем и развиваемся для ваших детей!') }}
                </h2>

                <div class="news swiper">
                    <div class="swiper-wrapper">
                        @foreach ($news as $item)
                            <div class="swiper-slide">
                                <article class="flex flex-col p-6 rounded-2xl border border-gray-200 bg-blue-50">
                                    <img class="flex w-full object-cover mb-4 rounded-xl" src="{{ $item->image_url }}" width="306" height="256" alt="{{ $item->title }}">

                                    <h2 class="text-lg w-full font-semibold flex justify-between items-center border-b border-gray-400 pb-4 mt-0 mb-4 leading-[1.2]">
                                        {{ $item->title }}
                                    </h2>

                                    <p class="m-0">
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
            <section class="mb-11 md:mb-16 xl:mb-20">
                <h2 class="container font-semibold text-lg mt-0 mb-6 md:text-[32px] md:mb-8 leading-none xl:mb-10">
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
            <section class="container mb-11 md:mb-16 xl:mb-20">
                <h2 class="font-semibold text-lg mt-0 mb-6 md:text-[32px] md:mb-8 leading-none xl:mb-10">
                    {{ __('Отзывы родителей:') }} <br>
                    {{ __('IlmCity — выбор профессионалов') }}
                </h2>

                <div class="reviews swiper">
                    <div class="swiper-wrapper">
                        @foreach ($reviews as $review)
                            <div class="swiper-slide">
                                <article class="flex flex-col p-6 rounded-2xl border border-gray-200 bg-yellow-50">
                                    <h2 class="text-lg w-full font-semibold flex justify-between items-center border-b border-gray-400 pb-4 mb-4">
                                        {{ $review->title }}

                                        <svg width="48" height="44">
                                            <use xlink:href="#rocket" />
                                        </svg>
                                    </h2>

                                    <p class="m-0">
                                        {{ $review->text }}
                                    </p>

                                    <div class="flex items-center rounded-2xl gap-3 mt-4">
                                        <img class="flex border border-gray-400 rounded-full bg-gray-300 object-cover w-20 h-20 min-w-20" src="{{ $review->photo_url }}" width="80" height="80" alt="{{ $review->author_name }}">
                                        <div>
                                            <h2 class="text-lg font-semibold m-0 mb-1">{{ $review->author_name }}</h2>
                                            <div>{{ $review->author_caption }}</div>
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
