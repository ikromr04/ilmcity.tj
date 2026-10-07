@extends('layouts.app')

@section('title', __('Лагерь'))

@php
  $features = [
    ['image' => 'images/camp-1.png', 'title' => __('Образовательная программа'), 'text' => __('Мы разработали увлекательные занятия, которые помогут детям развивать интеллект, творчество и навыки общения.')],
    ['image' => 'images/camp-2.png', 'title' => __('Комфорт и забота'), 'text' => __('Мы разработали увлекательные занятия, которые помогут детям развивать интеллект, творчество и навыки общения.')],
  ];

  $activities = [
    [__('Информатика'), __('Знакомство с технологиями и основами программирования.')],
    [__('Английский язык'), __('Развитие языковых навыков в игровой форме.')],
    [__('Творчество'), __('Рисование, лепка и рукоделие для развития фантазии.')],
    [__('Спорт и игры'), __('Подвижные игры и спортивные состязания на свежем воздухе.')],
    [__('Экскурсии'), __('Познавательные поездки и знакомство с родным городом.')],
  ];

  $meals = [
    ['image' => 'images/camp-1.png', 'title' => __('Завтрак, обед и полдник включены в стоимость!'), 'text' => __('Все для комфорта вашего ребенка: уют и вкусное питание!'), 'price' => __('От 150-170 сомони в день')],
    ['image' => 'images/camp-2.png', 'title' => __('Завтрак, обед и полдник включены в стоимость!'), 'text' => __('Все для комфорта вашего ребенка: уют и вкусное питание!'), 'price' => __('От 150-170 сомони в день')],
  ];
@endphp

@section('content')
  <main class="courses-page container">
    <h1 class="title-1">
      {{ __('ВЕСЕННИЙ, ЛЕТНИЙ, ОСЕННИЙ И ЗИМНИЙ ЛАГЕРЬ ДЛЯ ДЕТЕЙ 7-13 ЛЕТ') }}
    </h1>

    <x-banner :image="asset('images/camp.png')" alt="Camp">
      <h2 class="text-lg font-semibold mt-0 mb-3 leading-[1.2] xl:text-[20px] 2xl:text-[24px] 2xl:mb-4">
        {{ __('Детский лагерь IlmCity – это увлекательное путешествие в мир знаний, творчества и веселья!') }}
      </h2>

      <p class="m-0">
        {{ __('Мы организуем сезонные лагеря (весенний, летний, осенний и зимний) для детей от 7 до 13 лет, где каждый день наполнен интересными занятиями и активностями.') }}
      </p>
    </x-banner>

    <section class="section">
      <h2 class="title-2">
        {{ __('Что ждет вашего ребенка в лагере IlmCity?') }}
      </h2>

      <ul class="list-none p-0 m-0 flex flex-col gap-3 md:grid md:grid-cols-2 xl:gap-4">
        @foreach ($features as $feature)
          <li>
            <article class="card h-full bg-gray-50">
              <img class="card-image aspect-[573/290]" src="{{ asset($feature['image']) }}" width="306" height="256" alt="{{ $feature['title'] }}">

              <h3 class="card-title">
                {{ $feature['title'] }}
              </h3>

              <p class="card-text">
                {{ $feature['text'] }}
              </p>
            </article>
          </li>
        @endforeach
      </ul>

      <ul class="list-none p-0 m-0 mt-3 flex flex-col gap-3 md:grid md:grid-cols-2 xl:grid-cols-3 xl:gap-4 xl:mt-11">
        @foreach ($activities as [$title, $text])
          <li>
            <article class="card h-full bg-yellow-50">
              <h3 class="card-title xl:min-h-[58px]">
                {{ $title }}
                <svg class="shrink-0" width="51" height="44">
                  <use xlink:href="#chat-bubble" />
                </svg>
              </h3>

              <p class="card-text">
                {{ $text }}
              </p>
            </article>
          </li>
        @endforeach
      </ul>
    </section>

    <section class="section">
      <h2 class="title-2">
        {{ __('Лагерь с заботой: трехразовое питание и комфортная атмосфера!') }}
      </h2>

      <ul class="list-none p-0 m-0 flex flex-col gap-3 md:grid md:grid-cols-2 xl:gap-4">
        @foreach ($meals as $meal)
          <li>
            <article class="card h-full bg-gray-50">
              <img class="card-image aspect-[573/290]" src="{{ asset($meal['image']) }}" width="306" height="256" alt="{{ $meal['title'] }}">

              <h3 class="card-title">
                {{ $meal['title'] }}
              </h3>

              <p class="card-text">
                {{ $meal['text'] }}
              </p>

              <div class="btn btn-yellow cursor-auto hover:shadow mt-6">
                {{ $meal['price'] }}
              </div>
            </article>
          </li>
        @endforeach
      </ul>
    </section>
  </main>
@endsection
