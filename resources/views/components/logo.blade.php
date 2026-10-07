<a
    {{ $attributes->merge([
        'class' => 'flex w-max h-max'
    ]) }}
    href="{{ route('home') }}"
>
    <picture>
        <source
            media="(min-width: 1280px)"
            srcset="{{ asset('/images/logo.desktop.svg') }}"
            type="image/svg+xml"
        >
        <source
            media="(min-width: 768px)"
            srcset="{{ asset('/images/logo.tablet.svg') }}"
            type="image/svg+xml"
        >

        <img
            src="{{ asset('/images/logo.mobile.svg') }}"
            alt="{{ config('app.name') }}"
        >
    </picture>
</a>
