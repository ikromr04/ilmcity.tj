@php
    use App\Helper;
    use App\Models\Setting;
    use App\Support\SiteContent;

    $phone = Setting::get('phone', '+992 987 65 43 21');
    $email = Setting::get('email', 'info@ilmcity.tj');
    $footerCourses = \App\Models\Course::visible()->limit(5)->get(['id', 'title']);
    $coursesPublished = SiteContent::isPublished('courses');
@endphp

<footer class="mt-auto">
  <div class="container flex flex-col">
    <span class="border-t border-gray-400 mb-8 md:mb-16 xl:mb-20"></span>

    <livewire:contact-form />

    @if ($map = Setting::get('map', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3838.1321530675405!2d68.79760459786984!3d38.574230697514245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38b5d1507b932a4f%3A0xa84c51c0a79f3a5c!2sPulodi%20Street%2043%2C%20Dushanbe%20734000!5e1!3m2!1sen!2s!4v1765768011380!5m2!1sen!2s'))
      <iframe class="w-full h-[220px] rounded-2xl border border-gray-300 shadow my-8 md:mt-16 md:mb-8 xl:mt-20 xl:mb-11 xl:h-60 2xl:rounded-[28px]" src="{{ $map }}" width="600" height="450" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    @endif

    <div class="grid grid-cols-2 gap-6 mb-8 leading-[1.2] md:grid-cols-4 xl:flex xl:justify-center xl:items-center xl:gap-[60px] xl:mb-11">
      <div class="flex flex-col gap-2.5 xl:self-start xl:w-[172px]">
        <div class="font-semibold text-gray-600 mb-2.5">{{ SiteContent::text('footer.contacts_title') }}</div>

        @if ($phone)
          <a class="text-blue-600 no-underline" href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}">{{ $phone }}</a>
        @endif
        @if ($email)
          <a class="text-blue-600 no-underline" href="mailto:{{ $email }}">{{ $email }}</a>
        @endif
        <div class="text-blue-600">{{ Setting::trans('address', 'Пулоди 43, Душанбе') }}</div>

        <div class="flex gap-2.5 items-center mt-2.5">
          <a class="flex items-center justify-center text-white bg-blue-600 size-[30px] rounded-full" href="{{ Setting::get('telegram') ?: '#' }}" target="_blank" rel="noopener" aria-label="Telegram">
            <svg width="16" height="16">
              <use xlink:href="#telegram" />
            </svg>
          </a>
          <a class="flex items-center justify-center text-white bg-blue-600 size-[30px] rounded-full" href="{{ Setting::get('instagram') ?: '#' }}" target="_blank" rel="noopener" aria-label="Instagram">
            <svg width="16" height="16">
              <use xlink:href="#instagram" />
            </svg>
          </a>
        </div>
      </div>

      <div class="flex flex-col gap-2.5 xl:self-start xl:w-[172px]">
        <div class="font-semibold text-gray-600 mb-2.5">{{ SiteContent::text('footer.hours_title') }}</div>

        @foreach (SiteContent::hours() as $row)
          <div class="font-semibold text-gray-600">{{ Helper::tr($row['label'] ?? null) }}</div>
          @if (filled($value = Helper::tr($row['value'] ?? null)))
            <div class="text-blue-600">{{ $value }}</div>
          @endif
        @endforeach
      </div>

      <div class="flex flex-col gap-2.5 xl:self-start xl:w-[169px]">
        <div class="font-semibold text-gray-600 mb-2.5">{{ SiteContent::text('footer.courses_title') }}</div>

        @foreach ($footerCourses as $footerCourse)
          @if ($coursesPublished)
            <a class="text-blue-600 no-underline" href="{{ route('courses.show', $footerCourse) }}">{{ $footerCourse->title }}</a>
          @else
            <div class="text-blue-600">{{ $footerCourse->title }}</div>
          @endif
        @endforeach
      </div>

      <div class="flex flex-col gap-2.5 xl:self-start xl:w-[212px]">
        <div class="font-semibold text-gray-600 mb-2.5">{{ SiteContent::text('footer.services_title') }}</div>

        @foreach (SiteContent::services() as $service)
          @if ($url = SiteContent::link($service['url']))
            <a class="text-blue-600 no-underline hover:underline" href="{{ $url }}" @if (str_starts_with($url, 'http')) target="_blank" rel="noopener" @endif>{{ Helper::tr($service['text']) }}</a>
          @else
            <div class="text-blue-600">{{ Helper::tr($service['text']) }}</div>
          @endif
        @endforeach
      </div>

      <div class="col-span-2 flex items-center gap-5 md:col-span-4 xl:flex-col xl:items-start xl:w-[157px]">
        <x-logo class="shrink-0" />
        @php($license = nl2br(e(Setting::trans('license', 'Лицензия МЮ РТ 2024 “Ъ” от 08 августа 2024'))))
        @if ($licenseFile = Setting::get('license_file'))
          <a class="m-0 text-blue-600 max-w-[157px] no-underline hover:underline" href="{{ Helper::media($licenseFile) }}" target="_blank" rel="noopener">{!! $license !!}</a>
        @else
          <p class="m-0 text-blue-600 max-w-[157px]">{!! $license !!}</p>
        @endif
      </div>
    </div>
  </div>

  <div class="bg-blue-600 text-gray-50 text-xs text-center md:text-[16px]">
    <p class="container m-0 py-3 md:py-5 leading-[1.2]">© {{ date('Y') }} IlmCity. {{ SiteContent::text('footer.copyright') }}</p>
  </div>
</footer>

<livewire:enroll-form />
