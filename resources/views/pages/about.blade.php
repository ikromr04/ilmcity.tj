@extends('layouts.app')

@section('title', __('О нас'))

@section('content')
  <main class="about-page container">
    <h1 class="text-lg uppercase font-semibold leading-[1.2] mt-11 mb-6 md:mt-16 md:mb-8 xl:mt-20 xl:mb-10 md:text-[32px] xl:text-[48px]">
      {{ __('В') }}
      <x-brand />
      {{ __('мы не просто учим, мы вдохновляем!') }}
    </h1>

    <x-banner :image="asset('images/about.png')" alt="About">
      <h2 class="text-lg font-semibold mt-0 mb-3 leading-[1.2]">
        {{ __('Хотите, чтобы ваш ребенок стал лидером будущего?') }}
      </h2>

      <p class="m-0">
        {{ __('В нашем обучающем центре мы предлагаем нестандартные программы, которые помогут вашему ребенку раскрыть творческий потенциал и приобрести навыки, необходимые для успешной жизни. Давайте вместе сделаем мир лучше!') }}
      </p>
    </x-banner>

    <section class="mb-8 md:mb-16 xl:mb-20">
      <h2 class="text-lg mt-0 font-semibold mb-6 leading-[1.2] md:text-[32px] md:mb-8 xl:text-[40px] xl:mb-10">
        {{ __('Миссия, видение, ценности: кто мы есть') }}
      </h2>

      @php
        $cards = [
          [__('Миссия'), __('Предоставить качественные образовательные курсы, основанные на инновационных методиках, способствуя интеллектуальному, эмоциональному и социальному развитию каждого.')],
          [__('Видение'), __('Наше видение создать образовательное пространство в Таджикистане, где каждый может раскрыть свой уникальный потенциал, развиваться гармонично и стать ответственным гражданином.')],
          [__('Ценности'), __('Наше видение создать образовательное пространство в Таджикистане, где каждый может раскрыть свой уникальный потенциал, развиваться гармонично и стать ответственным гражданином.')],
        ];
      @endphp

      <ul class="list-none p-0 m-0 flex flex-col gap-3 xl:grid xl:grid-cols-3">
        @foreach ($cards as [$title, $text])
          <li class="flex flex-col border p-6 border-gray-300 rounded-2xl shadow">
            <h3 class="flex text-lg font-semibold border-b border-b-gray-400 pb-4 mt-0 mb-4">
              {{ $title }}
            </h3>
            <p class="m-0">
              {{ $text }}
            </p>
          </li>
        @endforeach
      </ul>
    </section>
  </main>
@endsection
