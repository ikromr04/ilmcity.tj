@extends('layouts.app')

@section('title', __('FAQs'))

@section('content')
  <main class="courses-page container">
    <div class="mb-8 md:mb-16 xl:mb-20">
      <h1 class="text-lg font-semibold leading-[1.2] mt-11 mb-6 md:mt-16 md:mb-8 xl:mt-20 xl:mb-10 md:text-[32px] xl:text-[48px]">
        {{ __('Часто задаваемые вопросы') }}
      </h1>

      <ul class="list-none p-0 m-0 flex flex-col">
        @foreach ($faqs as $faq)
          <li class="group border-t border-gray-400">
            <div class="flex justify-between cursor-pointer py-4 px-6 text-lg font-semibold" onclick="this.closest('li').classList.toggle('shown')">
              {{ $faq->question }}
              <svg class="text-gray-300 rotate-90 group-[.shown]:rotate-270 duration-150 shrink-0" width="16" height="24">
                <use xlink:href="#arrow-right" />
              </svg>
            </div>
            <div class="duration-150 max-h-0 group-[.shown]:max-h-[500px] overflow-hidden">
              <div class="py-4 px-6">
                {!! nl2br(e($faq->answer)) !!}
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </main>
@endsection
