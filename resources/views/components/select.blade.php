@props([
    'label'       => null,
    'name'        => '',
    'id'          => null,
    'options'     => [],       // ['value' => 'label'] hoặc [['value'=>'', 'label'=>'']]
    'selected'    => null,
    'placeholder' => '___ Chọn ___',
    'required'    => false,
    'disabled'    => false,
    'multiple'    => false,
    'size'        => null,     // sm | lg
    'hint'        => null,
    'error'       => null,
])

@php
    $id        = $id ?? $name;
    $sizeClass = $size ? "form-select-{$size}" : '';
    $errors    = $errors ?? session()->get('errors', new \Illuminate\Support\MessageBag);
    $errorMsg  = $error ?? ($errors->first($name) ?: null);
    $oldValue  = old($name, $selected);

    // Normalize options thành [['value'=>, 'label'=>]]
    $normalized = [];
    foreach ($options as $key => $val) {
        if (is_array($val)) {
            $normalized[] = $val;
        } else {
            $normalized[] = ['value' => $key, 'label' => $val];
        }
    }

    $isSelected = function($optValue) use ($oldValue, $multiple) {
        if ($multiple && is_array($oldValue)) {
            return in_array($optValue, $oldValue);
        }
        return (string) $optValue === (string) $oldValue;
    };
@endphp

<div class="mb-3">
    @if ($label)
        <label for="{{ $id }}" class="form-label fw-semibold">
            {{ $label }}
            @if ($required)
                <span class="text-danger ms-1">*</span>
            @endif
        </label>
    @endif

    <select
        id="{{ $id }}"
        name="{{ $multiple ? $name . '[]' : $name }}"
        {{ $required  ? 'required'  : '' }}
        {{ $disabled  ? 'disabled'  : '' }}
        {{ $multiple  ? 'multiple'  : '' }}
        {{ $attributes->merge(['class' => "form-select {$sizeClass}" . ($errorMsg ? ' is-invalid' : '')]) }}
    >
        {{-- Placeholder option --}}
        @if ($placeholder && !$multiple)
            <option value="" {{ !$oldValue ? 'selected' : '' }} disabled>
                {{ $placeholder }}
            </option>
        @endif

        {{-- Options --}}
        @foreach ($normalized as $opt)
            @if (isset($opt['options']))
                {{-- OptGroup --}}
                <optgroup label="{{ $opt['label'] }}">
                    @foreach ($opt['options'] as $subOpt)
                        <option
                            value="{{ $subOpt['value'] }}"
                            {{ $isSelected($subOpt['value']) ? 'selected' : '' }}
                            {{ isset($subOpt['disabled']) && $subOpt['disabled'] ? 'disabled' : '' }}
                        >
                            {{ $subOpt['label'] }}
                        </option>
                    @endforeach
                </optgroup>
            @else
                <option
                    value="{{ $opt['value'] }}"
                    {{ $isSelected($opt['value']) ? 'selected' : '' }}
                    {{ isset($opt['disabled']) && $opt['disabled'] ? 'disabled' : '' }}
                >
                    {{ $opt['label'] }}
                </option>
            @endif
        @endforeach

        {{-- Slot cho options tùy chỉnh --}}
        {{ $slot }}
    </select>

    @if ($errorMsg)
        <div class="invalid-feedback">{{ $errorMsg }}</div>
    @endif

    @if ($hint && !$errorMsg)
        <div class="form-text text-muted">{{ $hint }}</div>
    @endif
</div>
