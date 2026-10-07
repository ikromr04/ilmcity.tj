@extends('layouts.app')

@section('title', __('Сотрудники'))

@section('content')
    <main class="courses-page container">
        <h1 class="title-1">
            {{ __('Профессионалы, которые делают обучение увлекательным!') }}
        </h1>

        <x-banner :image="asset('images/employees.png')" alt="Employees" position="object-center" />

        @foreach ([[__('Администрация'), $admins], [__('Наши преподаватели'), $teachers]] as [$title, $employees])
            @if ($employees->isNotEmpty())
                <section class="section">
                    <h2 class="title-2">
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
