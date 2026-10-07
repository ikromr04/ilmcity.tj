<!DOCTYPE html>
<html class="page" lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>@yield('title') - {{ config('app.name') }}</title>

        <link href="{{ asset('favicon.ico') }}" rel="icon">
        <link href="{{ asset('favicons/icon.svg') }}" rel="icon" type="image/svg+xml">
        <link href="{{ asset('favicons/180x180.png') }}" rel="apple-touch-icon">
        <link href="{{ asset('site.webmanifest') }}" rel="manifest">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="page__body">
        <x-icons />

        @include('layouts.header')

        @yield('content')

        @include('layouts.footer')
    </body>

</html>
