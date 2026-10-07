@props(['class' => ''])

@php
  $segments = request()->segments();
  $locale = app()->getLocale();

  if ($locale === 'tj') {
      array_shift($segments);
      $href = '/' . implode('/', $segments);
  } else {
      $href = '/tj/' . implode('/', $segments);
      $href = rtrim($href, '/');
  }
@endphp

<a class="{{ $class ? "$class " : '' }}flex no-underline text-sm font-medium capitalize justify-center text-gray-800 shadow items-center border-none w-9 h-[30px] rounded-sm bg-gray-100 hover:bg-white duration-150 md:min-h-10 md:min-w-12 md:rounded-lg" href="{{ $href }}">
  {{ $locale }}
</a>
