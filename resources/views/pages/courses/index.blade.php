@extends('layouts.app')

@section('title', __('Курсы'))

@section('content')
    <main class="courses-page container">
        <h1 class="text-lg uppercase font-semibold leading-[1.2] mt-11 mb-6 md:mt-16 md:mb-8 xl:mt-20 xl:mb-10 md:text-[32px] xl:text-[48px]">
            {{ __('Дайте ребенку шанс на успешное будущее с') }}
            <x-brand />
            !
        </h1>

        <x-banner :image="asset('images/courses.png')" alt="Courses">
            <h2 class="text-lg font-semibold mt-0 mb-3 leading-[1.2]">
                {{ __('Ищете курсы, которые раскроют лучшие качества вашего ребенка?') }}
            </h2>

            <p class="m-0">
                {{ __('Наши курсы созданы с учетом потребностей современного образования, помогают развить критическое мышление, креативность и лидерские качества. Программы IlmCity помогут вашему ребенку уверенно идти к успеху и раскрыть свой потенциал на максимум.') }}
            </p>
        </x-banner>

        @if ($courses->isNotEmpty())
            <section class="mb-8 md:mb-16 xl:mb-20">
                <h2 class="text-lg mt-0 font-semibold mb-6 leading-[1.2] md:text-[32px] md:mb-8 xl:text-[40px] xl:mb-10">
                    {{ __('Инвестируйте в будущее вашего ребенка с нами!') }}
                </h2>

                <ul class="list-none p-6 m-0 rounded-2xl border border-gray-300 shadow bg-yellow-50 flex flex-col gap-2 xl:grid xl:grid-cols-3 xl:gap-4 xl:bg-transparent xl:p-0 xl:shadow-none xl:border-none">
                    @foreach ($courses as $course)
                        <x-course-card :course="$course" />
                    @endforeach
                </ul>
            </section>
        @endif
    </main>
@endsection
