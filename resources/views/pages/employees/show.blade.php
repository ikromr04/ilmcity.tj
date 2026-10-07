@extends('layouts.app')

@section('title', $employee->name)

@section('content')
    <main class="courses-page container">
        <x-back-link :href="route('employees')" :title="$employee->name" :aside="__($employee->role === \App\Enums\Role::Admin ? 'Администрация' : 'Преподаватели')">
            {{ __('Вернуться') }}
        </x-back-link>

        <div class="section md:grid md:grid-cols-[290px_1fr] md:border md:border-gray-300 md:rounded-[20px] md:shadow md:gap-7 md:min-h-[420px] xl:pr-16 xl:grid-cols-[330px_1fr] 2xl:grid-cols-[464px_1fr] 2xl:min-h-[464px] 2xl:rounded-[28px]">
            <img class="w-full md:rounded-[20px] h-auto bg-gray-300 border border-gray-400 rounded-xl md:h-full object-cover 2xl:rounded-[28px]" src="{{ $employee->photo_url }}" width="1118" height="572" alt="{{ $employee->name }}">

            <div class="rich mt-6 md:mt-0 md:py-8 xl:py-10 xl:pl-6 2xl:py-12">
                {!! str($employee->bio)->sanitizeHtml() !!}
            </div>
        </div>

        @if ($employee->certificates->isNotEmpty())
            <section class="section">
                <h2 class="title-2">
                    {{ __('Сертификаты') }}
                </h2>

                <ul class="list-none p-0 m-0 flex flex-col gap-3 md:grid md:grid-cols-2 xl:gap-4">
                    @foreach ($employee->certificates as $certificate)
                        <li class="card bg-gray-50">
                            <img class="card-image h-auto" src="{{ $certificate->image_url }}" alt="{{ $certificate->title }}">
                            <h3 class="card-title">
                                {{ $certificate->title }}
                            </h3>
                            @if ($certificate->description)
                                <p class="card-text">
                                    {{ $certificate->description }}
                                </p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if ($employee->courses->isNotEmpty())
            <section class="section">
                <h2 class="title-2">
                    {{ __('Курсы') }}
                </h2>

                <ul class="list-none p-6 m-0 rounded-2xl border border-gray-300 shadow bg-yellow-50 flex flex-col gap-2 xl:grid xl:grid-cols-3 xl:gap-4 xl:bg-transparent xl:p-0 xl:shadow-none xl:border-none xl:rounded-none">
                    @foreach ($employee->courses as $course)
                        <x-course-card :course="$course" />
                    @endforeach
                </ul>
            </section>
        @endif

        @if ($employee->video_url)
            <section class="section">
                @if ($employee->video_title)
                    <h2 class="title-2">
                        {{ $employee->video_title }}
                    </h2>
                @endif

                <a class="group relative flex overflow-hidden rounded-xl border border-gray-300 shadow md:rounded-[20px] 2xl:rounded-[28px]" href="{{ $employee->video_url }}" target="_blank" rel="noopener">
                    <img class="w-full h-[252px] object-cover object-left md:h-[340px] xl:h-[416px] 2xl:h-[464px]" src="{{ $employee->video_cover_url }}" width="1290" height="464" alt="{{ $employee->video_title ?? $employee->name }}">

                    <span class="absolute inset-0 m-auto flex items-center justify-center size-16 rounded-full bg-gray-800/60 text-white duration-150 group-hover:bg-gray-800/80 md:size-24" aria-hidden="true">
                        <svg class="ml-1 w-6 md:w-8" viewBox="0 0 24 28" fill="currentColor">
                            <path d="M24 14 0 28V0z" />
                        </svg>
                    </span>
                </a>
            </section>
        @endif
    </main>
@endsection
