@extends('layouts.app')

@section('title', __('Курсы'))

@section('content')
    <main class="courses-page container">
        <h1 class="title-1">
            {{ __('Дайте ребенку шанс на успешное будущее с') }}
            <x-brand />
            !
        </h1>

        <x-banner :image="asset('images/courses.png')" alt="Courses">
            <h2 class="text-lg font-semibold mt-0 mb-3 leading-[1.2] xl:text-[20px] 2xl:text-[24px] 2xl:mb-4">
                {{ __('Ищете курсы, которые раскроют лучшие качества вашего ребенка?') }}
            </h2>

            <p class="m-0">
                {{ __('Наши курсы созданы с учетом потребностей современного образования, помогают развить критическое мышление, креативность и лидерские качества. Программы IlmCity помогут вашему ребенку уверенно идти к успеху и раскрыть свой потенциал на максимум.') }}
            </p>
        </x-banner>

        @if ($courses->isNotEmpty())
            <section class="section">
                <h2 class="title-2">
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
