@php
    use App\Models\Setting;

    $phone = Setting::get('phone', '+992 987 65 43 21');
    $email = Setting::get('email', 'info@ilmcity.tj');
    $footerCourses = \App\Models\Course::visible()->limit(5)->get(['id', 'title']);
@endphp

<footer class="mt-auto">
  <div class="container flex flex-col">
    <span class="border-t border-gray-400 mx-[5vw] mb-8 md:mb-16 xl:mb-20 md:mx-0"></span>

    <livewire:contact-form />

    <iframe class="max-w-[calc(100%-64px)] h-[220px] rounded-2xl my-8 mx-auto md:mt-16 md:mb-8 md:max-w-full md:w-full md:mx-0" src="{{ Setting::get('map', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3838.1321530675405!2d68.79760459786984!3d38.574230697514245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38b5d1507b932a4f%3A0xa84c51c0a79f3a5c!2sPulodi%20Street%2043%2C%20Dushanbe%20734000!5e1!3m2!1sen!2s!4v1765768011380!5m2!1sen!2s') }}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

    <div class="grid grid-cols-2 gap-6 mb-8 md:grid-cols-4">
      <div>
        <div class="font-semibold text-gray-600 mb-4">{{ __('Мы работаем') }}</div>

        <div class="font-semibold text-gray-600 text-[14px]">{{ __('По будням:') }}</div>
        <div class="text-sm text-blue-600">{{ Setting::trans('hours_weekdays', 'с 8:00 до 20:00') }}</div>

        <div class="font-semibold text-gray-600 text-[14px]">{{ __('По субботам:') }}</div>
        <div class="text-sm text-blue-600">{{ Setting::trans('hours_saturday', 'с 09:00 до 18:00') }}</div>

        <div class="font-semibold text-gray-600 text-[14px]">{{ Setting::trans('hours_sunday', 'Вск - выходной') }}</div>
      </div>

      <div>
        <div class="font-semibold text-gray-600 mb-4">{{ __('Курсы') }}</div>

        @foreach ($footerCourses as $footerCourse)
          <div class="text-sm text-blue-600">
            <a class="text-inherit no-underline" href="{{ route('courses.show', $footerCourse) }}">{{ $footerCourse->title }}</a>
          </div>
        @endforeach
      </div>

      <div class="md:-order-1">
        <div class="font-semibold text-gray-600 mb-4">{{ __('Kонтакты') }}</div>

        <div class="text-sm text-blue-600">
          <a class="text-inherit no-underline" href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}">{{ $phone }}</a>
        </div>
        <div class="text-sm text-blue-600">
          <a class="text-inherit no-underline" href="mailto:{{ $email }}">{{ $email }}</a>
        </div>
        <div class="text-sm text-blue-600">{{ Setting::trans('address', 'Пулоди 43, Душанбе') }}</div>

        <div class="flex gap-2 items-center mt-3">
          <a class="flex items-center justify-center text-white bg-blue-600 min-w-8 min-h-8 rounded-full" href="{{ Setting::get('telegram', '#') }}" target="_blank" rel="noopener" aria-label="Telegram">
            <svg width="16" height="16">
              <use xlink:href="#telegram" />
            </svg>
          </a>
          <a class="flex items-center justify-center text-white bg-blue-600 min-w-8 min-h-8 rounded-full" href="{{ Setting::get('instagram', '#') }}" target="_blank" rel="noopener" aria-label="Instagram">
            <svg width="16" height="16">
              <use xlink:href="#instagram" />
            </svg>
          </a>
        </div>
      </div>

      <div>
        <div class="font-semibold text-gray-600 mb-4">{{ __('Доп. услуги') }}</div>

        <div class="text-sm text-blue-600">{{ __('Детский психолог') }}</div>
        <div class="text-sm text-blue-600">{{ __('Логопед') }}</div>
        <div class="text-sm text-blue-600">{{ __('Тренинг-центр') }}</div>
        <div class="text-sm text-blue-600">{{ __('КафеСити') }}</div>
        <div class="text-sm text-blue-600">{{ __('Коворкинг в будущем') }}</div>
      </div>
    </div>
  </div>

  <div class="bg-blue-600 text-white text-xs text-center">
    <div class="flex flex-col py-3 gap-2 container md:flex-row md:justify-between md:py-5">
      <p class="m-0">{{ Setting::trans('license', 'Лицензия МЮ РТ 2024 “Ъ” от 08 августа 2024') }}</p>
      <p class="m-0">© {{ date('Y') }} IlmCity. {{ __('Все права защищены.') }}</p>
    </div>
  </div>
</footer>
