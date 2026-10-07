@props(['id', 'model', 'label' => null, 'type' => 'text', 'autocomplete' => null])

<div {{ $attributes->class('flex flex-col') }}>
    @if ($label)
        <label class="field-label" for="{{ $id }}">{{ $label }}</label>
    @endif

    <div class="relative">
        @if ($type === 'textarea')
            <textarea class="field-input py-3 resize-y min-h-[52px] @error($model) field-input-invalid @enderror" id="{{ $id }}" rows="1" wire:model.live.debounce.400ms="{{ $model }}"></textarea>
        @else
            <input class="field-input @error($model) field-input-invalid pr-10 @enderror" id="{{ $id }}" type="{{ $type }}" wire:model.live.debounce.400ms="{{ $model }}" @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif>
        @endif

        @error($model)
            <x-field-error-icon />
        @enderror
    </div>

    @error($model)
        <span class="field-error">{{ $message }}</span>
    @enderror
</div>
