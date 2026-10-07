@extends('layouts.app')

@section('title', __('FAQs'))

@section('content')
  <main class="courses-page container">
    <div class="section">
      <h1 class="title-1 normal-case">
        {{ __('Часто задаваемые вопросы') }}
      </h1>

      <ul class="list-none p-0 m-0 flex flex-col">
        @foreach ($faqs as $faq)
          <li class="group border-t border-gray-300">
            <div class="flex justify-between items-center gap-4 cursor-pointer py-4 px-6 text-lg font-semibold leading-[1.2] 2xl:px-8 2xl:text-[24px]" onclick="this.closest('li').classList.toggle('shown')">
              {{ $faq->question }}
              <svg class="text-gray-300 rotate-90 group-[.shown]:rotate-270 duration-150 shrink-0" width="16" height="24">
                <use xlink:href="#arrow-right" />
              </svg>
            </div>
            <div class="duration-150 max-h-0 group-[.shown]:max-h-[500px] overflow-hidden">
              <div class="pb-4 px-6 leading-[1.2] xl:text-lg 2xl:px-8 2xl:text-[20px]">
                {!! nl2br(e($faq->answer)) !!}
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </main>
@endsection
