@extends('layouts.app')

@section('title', $employee->name)

@section('content')
    <main class="courses-page container">
        <x-back-link :href="route('employees')" :title="$employee->name">
            {{ __('Вернуться') }}
        </x-back-link>

        <div class="mb-8 md:mb-16 xl:mb-20 md:grid md:grid-cols-[290px_1fr] md:border md:border-gray-300 md:rounded-[28px] md:shadow md:gap-7 md:min-h-[420px] xl:pr-20 xl:grid-cols-[330px_1fr]">
            <img class="w-full md:rounded-[28px] h-auto bg-gray-300 border border-gray-400 rounded-xl md:h-full object-cover" src="{{ $employee->photo_url }}" width="1118" height="572" alt="{{ $employee->name }}">

            <div class="rich xl:py-10 xl:pl-12">
                {!! str($employee->bio)->sanitizeHtml() !!}
            </div>
        </div>

        @if ($employee->certificates->isNotEmpty())
            <section class="mb-8 md:mb-16 xl:mb-20">
                <h2 class="text-lg mt-0 font-semibold mb-6 leading-[1.2] md:text-[32px] md:mb-8 xl:text-[40px] xl:mb-10">
                    {{ __('Сертификаты') }}
                </h2>

                <ul class="list-none p-0 m-0 flex flex-col gap-3 md:grid md:grid-cols-2">
                    @foreach ($employee->certificates as $certificate)
                        <li class="flex flex-col p-6 gap-4 rounded-2xl border border-gray-300">
                            <img class="flex w-full h-auto" src="{{ $certificate->image_url }}" alt="{{ $certificate->title }}">
                            <h3 class="font-semibold text-lg mt-0 pb-4 mb-0 border-gray-400 border-b leading-none">
                                {{ $certificate->title }}
                            </h3>
                            @if ($certificate->description)
                                <p class="m-0">
                                    {{ $certificate->description }}
                                </p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if ($employee->courses->isNotEmpty())
            <section class="mb-8 md:mb-16 xl:mb-20">
                <h2 class="text-lg mt-0 font-semibold mb-6 leading-[1.2] md:text-[32px] md:mb-8 xl:text-[40px] xl:mb-10">
                    {{ __('Курсы') }}
                </h2>

                <ul class="list-none p-6 m-0 rounded-2xl border border-gray-300 shadow bg-yellow-50 flex flex-col gap-2 xl:grid xl:grid-cols-3 xl:gap-4 xl:bg-transparent xl:p-0 xl:shadow-none xl:border-none">
                    @foreach ($employee->courses as $course)
                        <x-course-card :course="$course" />
                    @endforeach
                </ul>
            </section>
        @endif
    </main>
@endsection
