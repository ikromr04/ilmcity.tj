<button {{ $attributes->class([
    'flex items-center justify-center w-full min-h-10 md:min-h-[52px] text-white border-none rounded-[10px] font-bold text-[16px] cursor-pointer duration-150 disabled:cursor-wait',
    $errors->any() ? 'bg-gray-300' : 'bg-blue-600',
]) }} type="submit" wire:loading.attr="disabled" wire:target="submit">
    <span wire:loading.remove wire:target="submit">{{ App\Support\SiteContent::text('form.button') }}</span>
    <span wire:loading wire:target="submit">{{ __('Загрузка') }}…</span>
</button>
