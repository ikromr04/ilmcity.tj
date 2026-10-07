@extends('layouts.app')

@section('title', __('Сотрудники'))

@section('content')
    <main class="courses-page container">
        <h1 class="text-lg uppercase font-semibold leading-[1.2] mt-11 mb-6 md:mt-16 md:mb-8 xl:mt-20 xl:mb-10 md:text-[32px] xl:text-[48px]">
            {{ __('Профессионалы, которые делают обучение увлекательным!') }}
        </h1>

        <x-banner :image="asset('images/employees.png')" alt="Employees" position="object-center" />

        @foreach ([[__('Администрация'), $admins], [__('Наши преподаватели'), $teachers]] as [$title, $employees])
            @if ($employees->isNotEmpty())
                <section class="mb-8 md:mb-16 xl:mb-20">
                    <h2 class="text-lg mt-0 font-semibold mb-6 leading-[1.2] md:text-[32px] md:mb-8 xl:text-[40px] xl:mb-10">
                        {{ $title }}
                    </h2>

                    <ul class="list-none p-0 m-0 flex flex-col gap-2 xl:grid md:grid md:grid-cols-2 xl:grid-cols-3 xl:gap-4 xl:bg-transparent xl:p-0 xl:shadow-none xl:border-none">
                        @foreach ($employees as $employee)
                            <x-employee-card :employee="$employee" />
                        @endforeach
                    </ul>
                </section>
            @endif
        @endforeach
    </main>
@endsection
