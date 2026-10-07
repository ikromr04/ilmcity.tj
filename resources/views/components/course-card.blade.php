@props(['course'])

<li class="border-b border-gray-400 pb-2 xl:p-0 xl:border-none">
    <article class="flex items-center justify-between h-full xl:card xl:bg-yellow-50 xl:items-stretch">
        <h2 class="text-sm font-semibold m-0 md:text-lg xl:card-title xl:min-h-[58px]">
            {{ $course->title }}
            <svg class="hidden xl:inline shrink-0" width="51" height="44">
                <use xlink:href="#chat-bubble" />
            </svg>
        </h2>

        <p class="hidden xl:block card-text mb-6!">
            {{ $course->description }}
        </p>

        <div class="xl:flex xl:w-full xl:justify-between mt-auto">
            <button
                class="btn btn-yellow"
                type="button"
                x-data
                x-on:click="Livewire.dispatch('enroll', { course: {{ $course->id }} })"
            >
                {{ __('Записаться') }}
            </button>

            @if (App\Support\SiteContent::isPublished('courses'))
                <a class="hidden xl:inline-flex btn btn-gray" href="{{ route('courses.show', $course) }}">
                    {{ __('Подробнее') }}
                </a>
            @endif
        </div>
    </article>
</li>
