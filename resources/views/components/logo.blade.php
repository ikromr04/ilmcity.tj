@php
    use App\Support\SiteContent;
@endphp

<a
    {{ $attributes->merge([
        'class' => 'flex w-max h-max'
    ]) }}
    href="{{ route('home') }}"
>
    <picture>
        <source
            media="(min-width: 1280px)"
            srcset="{{ SiteContent::logo('desktop') }}"
        >
        <source
            media="(min-width: 768px)"
            srcset="{{ SiteContent::logo('tablet') }}"
        >

        <img
            class="max-h-[86px] w-auto"
            src="{{ SiteContent::logo('mobile') }}"
            alt="{{ config('app.name') }}"
        >
    </picture>
</a>
