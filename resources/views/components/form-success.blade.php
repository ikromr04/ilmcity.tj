@props(['after' => 5000, 'then' => "\$wire.set('sent', false)"])

{{-- Shown after a request is sent; runs $then (by default hides itself) after a few seconds. --}}
<div {{ $attributes->class('flex items-center gap-4 font-medium') }} role="status" x-data x-init="setTimeout(() => {{ $then }}, {{ (int) $after }})">
    <span class="flex items-center justify-center shrink-0 size-12 rounded-full bg-blue-600 text-white md:size-16" aria-hidden="true">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12.5 10 17.5 19 7" />
        </svg>
    </span>
    {{ App\Support\SiteContent::text('form.success') }}
</div>
