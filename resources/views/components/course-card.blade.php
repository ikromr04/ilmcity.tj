@props(['course'])

<li class="border-b border-gray-400 pb-2 xl:p-0 xl:border-none">
    <article class="flex items-center justify-between xl:bg-yellow-50 xl:rounded-[20px] xl:border xl:border-gray-200 xl:shadow xl:p-6 xl:flex-col h-full">
        <h2 class="text-sm font-semibold md:text-lg xl:flex xl:items-center xl:justify-between xl:text-[20px] xl:w-full xl:m-0 xl:pb-5 xl:border-b xl:border-gray-400 xl:mb-5">
            {{ $course->title }}
            <svg class="hidden xl:inline" width="51" height="44">
                <use xlink:href="#chat-bubble" />
            </svg>
        </h2>

        <div class="hidden xl:block xl:mt-0 xl:mb-5 text-lg">
            {{ $course->description }}
        </div>

        <div class="xl:flex xl:w-full xl:justify-between mt-auto">
            <button
                class="bg-yellow-300 h-10 px-2 text-sm font-medium rounded-lg flex items-center justify-center py-0 border-none shadow hover:shadow-none duration-150 cursor-pointer"
                type="button"
                x-data
                x-on:click="Livewire.dispatch('enroll', { course: {{ $course->id }} }); $dispatch('enroll')"
            >
                {{ __('Записаться') }}
            </button>

            <a class="hidden bg-gray-100 text-inherit no-underline h-10 px-2 text-sm font-medium rounded-lg xl:flex items-center justify-center py-0 border-none shadow hover:shadow-none duration-150" href="{{ route('courses.show', $course) }}">
                {{ __('Подробнее') }}
            </a>
        </div>
    </article>
</li>
