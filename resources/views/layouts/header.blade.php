@php
    $links = [
        ['route' => 'about', 'active' => ['about'], 'label' => __('О нас')],
        ['route' => 'courses', 'active' => ['courses', 'courses.show'], 'label' => __('Курсы')],
        ['route' => 'employees', 'active' => ['employees', 'employees.show'], 'label' => __('Сотрудники')],
        ['route' => 'camp', 'active' => ['camp'], 'label' => __('Лагерь')],
        ['route' => 'services', 'active' => ['services'], 'label' => __('Услуги')],
        ['route' => 'galleries', 'active' => ['galleries', 'galleries.show'], 'label' => __('Галерея')],
        ['route' => 'faq', 'active' => ['faq'], 'label' => __('FAQs')],
    ];
@endphp

<header class="container pt-12 flex items-center pb-2.5 border-b border-gray-400 justify-between group md:grid md:grid-cols-3 xl:flex xl:items-end xl:justify-start md:pt-11 xl:gap-4 xl:pt-7">
    <button
        class="flex bg-gray-100 justify-center text-gray-800 shadow items-center border-none w-9 h-[30px] rounded-sm hover:bg-white duration-150 md:min-h-10 md:w-12 xl:hidden"
        type="button"
        aria-label="{{ __('Меню') }}"
        onclick="this.closest('header').classList.add('menu-shown')"
    >
        <svg width="22" height="8">
            <use xlink:href="#hamburger" />
        </svg>
    </button>

    <nav class="fixed left-0 top-0 z-10 bg-white h-screen w-screen py-11 px-14 flex flex-col gap-12 invisible opacity-0 group-[.menu-shown]:visible group-[.menu-shown]:opacity-100 duration-150 xl:visible xl:opacity-100 xl:static xl:w-auto xl:h-auto xl:order-2 xl:p-0">
        <div class="flex justify-between items-center font-semibold text-[20px] max-w-full xl:hidden">
            <span class="flex">
                {{ __('Меню') }}
            </span>

            <button
                class="flex justify-center items-center border-none bg-transparent p-0 w-6 h-7"
                type="button"
                onclick="this.closest('header').classList.remove('menu-shown')"
            >
                <svg width="16" height="24">
                    <use xlink:href="#close" />
                </svg>
            </button>
        </div>

        <ul class="list-none p-0 m-0 flex flex-col xl:flex-row">
            @foreach ($links as $link)
                <li>
                    <a
                        class="xl:hover:text-gray-800 duration-150 xl:min-h-10 xl:items-center xl:p-3 xl:border-none xl:text-[16px] xl:text-gray-400 flex text-gray-800 text-[18px] no-underline p-3 border-b border-gray-400 font-medium leading-none{{ request()->routeIs($link['active']) ? ' font-semibold xl:font-medium xl:text-gray-600' : '' }}"
                        href="{{ route($link['route']) }}"
                    >
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="flex justify-center xl:order-1">
        <x-logo />
    </div>

    <div class="flex items-center gap-3 justify-end xl:order-3 xl:ml-auto">
        <a
            class="hidden md:flex items-center leading-none p-3 gap-1 rounded-lg bg-yellow-300 shadow hover:shadow-none duration-150 font-medium no-underline text-gray-800"
            href="#contact"
        >
            {{ __('Связаться') }} <span class="hidden xl:inline">{{ __('с нами') }}</span>
        </a>
        <x-locale-button />
    </div>
</header>
