@extends('layouts.app')

@section('title', __('Услуги'))

@section('content')
  <main class="courses-page container">
    <div class="mb-8 md:mb-16 xl:mb-20">
      <h1 class="text-lg uppercase font-semibold leading-[1.2] mt-11 mb-6 md:mt-16 md:mb-8 xl:mt-20 xl:mb-10 md:text-[32px] xl:text-[48px]">
        {{ __('В') }}
        <x-brand />
        {{ __('мы СОЗДАЁМ УСЛОВИЯ ДЛЯ УЮТА И РАЗВИТИЯ!') }}
      </h1>

      <ul class="list-none p-0 m-0 flex flex-col gap-2 xl:grid xl:grid-cols-2 xl:gap-4 xl:bg-transparent xl:p-0 xl:shadow-none xl:border-none">
        @foreach ($services as $service)
          <li>
            <article class="flex flex-col p-6 rounded-2xl border border-gray-200 shadow">
              <img class="flex w-full object-cover mb-4 rounded-xl" src="{{ $service->image_url }}" width="306" height="256" alt="{{ $service->title }}">

              <h2 class="text-lg w-full font-semibold flex justify-between items-center border-b border-gray-400 pb-4 mt-0 mb-4 leading-[1.2]">
                {{ $service->title }}
              </h2>

              <p class="m-0 xl:text-[20px]">
                {{ $service->text }}
              </p>
            </article>
          </li>
        @endforeach
      </ul>
    </div>
  </main>
@endsection
