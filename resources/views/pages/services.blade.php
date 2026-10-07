@extends('layouts.app')

@section('title', __('Услуги'))

@section('content')
  <main class="courses-page container">
    <div class="section">
      <h1 class="title-1">
        {{ __('В') }}
        <x-brand />
        {{ __('мы СОЗДАЁМ УСЛОВИЯ ДЛЯ УЮТА И РАЗВИТИЯ!') }}
      </h1>

      <ul class="list-none p-0 m-0 flex flex-col gap-3 md:grid md:grid-cols-2 xl:gap-4">
        @foreach ($services as $service)
          <li>
            <article class="card h-full bg-gray-50">
              <img class="card-image aspect-[573/290]" src="{{ $service->image_url }}" width="306" height="256" alt="{{ $service->title }}">

              <h3 class="card-title">
                {{ $service->title }}
              </h3>

              <p class="card-text">
                {{ $service->text }}
              </p>
            </article>
          </li>
        @endforeach
      </ul>
    </div>
  </main>
@endsection
