@props(['employee'])

@php
    $linked = App\Support\SiteContent::isPublished('employees');
@endphp

<li>
    <{{ $linked ? 'a' : 'div' }} class="flex items-center gap-3 h-full py-3 px-6 rounded-2xl border border-gray-300 bg-gray-100 shadow text-inherit no-underline duration-150 md:rounded-[20px] 2xl:gap-4 2xl:p-6 2xl:px-8 2xl:rounded-[28px] {{ $linked ? 'hover:bg-yellow-300' : '' }}" @if ($linked) href="{{ route('employees.show', $employee) }}" @endif>
        <img class="flex border border-gray-400 rounded-full bg-gray-300 object-cover w-20 h-20 min-w-20" src="{{ $employee->photo_url }}" width="80" height="80" alt="{{ $employee->name }}">
        <div class="leading-[1.2]">
            <h2 class="text-lg font-semibold m-0 mb-1 leading-[1.2] 2xl:text-[24px] 2xl:mb-2">{{ $employee->name }}</h2>
            <div class="2xl:text-[20px]">{{ $employee->position }}</div>
        </div>
    </{{ $linked ? 'a' : 'div' }}>
</li>
