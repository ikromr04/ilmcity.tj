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
    <h1 class="text-lg uppercase font-semibold leading-[1.2] mt-11 mb-6 md:mt-16 md:mb-8 xl:mt-20 xl:mb-10 md:text-[32px] xl:text-[48px]">
      {{ __('ВЕСЕННИЙ, ЛЕТНИЙ, ОСЕННИЙ И ЗИМНИЙ ЛАГЕРЬ ДЛЯ ДЕТЕЙ 7-13 ЛЕТ') }}
    </h1>

    <x-banner :image="asset('images/camp.png')" alt="Camp">
      <h2 class="text-lg font-semibold mt-0 mb-3 leading-[1.2]">
        {{ __('Детский лагерь IlmCity – это увлекательное путешествие в мир знаний, творчества и веселья!') }}
      </h2>

      <p class="m-0">
        {{ __('Мы организуем сезонные лагеря (весенний, летний, осенний и зимний) для детей от 7 до 13 лет, где каждый день наполнен интересными занятиями и активностями.') }}
      </p>
    </x-banner>

    <section class="mb-8 md:mb-16 xl:mb-20">
      <h2 class="text-lg mt-0 font-semibold mb-6 leading-[1.2] md:text-[32px] md:mb-8 xl:text-[40px] xl:mb-10">
        {{ __('Что ждет вашего ребенка в лагере IlmCity?') }}
      </h2>

      <ul class="list-none p-0 m-0 flex flex-col gap-2 xl:grid xl:grid-cols-2 xl:gap-4 xl:bg-transparent xl:p-0 xl:shadow-none xl:border-none">
        @foreach ($features as $feature)
          <li>
            <article class="flex flex-col p-6 rounded-2xl border border-gray-200 shadow">
              <img class="flex w-full object-cover mb-4 rounded-xl" src="{{ asset($feature['image']) }}" width="306" height="256" alt="{{ $feature['title'] }}">

              <h2 class="text-lg w-full font-semibold flex justify-between items-center border-b border-gray-400 pb-4 mt-0 mb-4 leading-[1.2]">
                {{ $feature['title'] }}
              </h2>

              <p class="m-0 xl:text-[20px]">
                {{ $feature['text'] }}
              </p>
            </article>
          </li>
        @endforeach
      </ul>

      <ul class="list-none p-0 m-0 mt-10 flex flex-col gap-2 xl:grid xl:grid-cols-3 xl:gap-4 md:grid md:grid-cols-2 xl:bg-transparent xl:p-0 xl:shadow-none xl:border-none">
        @foreach ($activities as [$title, $text])
          <li>
            <article class="flex items-center justify-between bg-yellow-50 rounded-[20px] border border-gray-200 shadow p-6 flex-col">
              <h2 class="text-lg font-semibold md:text-lg flex items-center justify-between xl:text-[20px] w-full m-0 pb-5 border-b xl:border-gray-400 mb-5">
                {{ $title }}
                <svg width="51" height="44">
                  <use xlink:href="#chat-bubble" />
                </svg>
              </h2>

              <p class="mt-0 xl:mb-5 text-lg">
                {{ $text }}
              </p>
            </article>
          </li>
        @endforeach
      </ul>
    </section>

    <section class="mb-8 md:mb-16 xl:mb-20">
      <h2 class="text-lg mt-0 font-semibold mb-6 leading-[1.2] md:text-[32px] md:mb-8 xl:text-[40px] xl:mb-10">
        {{ __('Лагерь с заботой: трехразовое питание и комфортная атмосфера!') }}
      </h2>

      <ul class="list-none p-0 m-0 flex flex-col gap-2 xl:grid xl:grid-cols-2 xl:gap-4 xl:bg-transparent xl:p-0 xl:shadow-none xl:border-none">
        @foreach ($meals as $meal)
          <li>
            <article class="flex flex-col p-6 rounded-2xl border border-gray-200 shadow">
              <img class="flex w-full object-cover mb-4 rounded-xl" src="{{ asset($meal['image']) }}" width="306" height="256" alt="{{ $meal['title'] }}">

              <h2 class="text-lg w-full font-semibold flex justify-between items-center border-b border-gray-400 pb-4 mt-0 mb-4 leading-[1.2]">
                {{ $meal['title'] }}
              </h2>

              <p class="m-0 xl:text-[20px]">
                {{ $meal['text'] }}
              </p>

              <div class="flex p-3 bg-yellow-300 rounded-lg w-max font-semibold mt-6">
                {{ $meal['price'] }}
              </div>
            </article>
          </li>
        @endforeach
      </ul>
    </section>
  </main>
@endsection
