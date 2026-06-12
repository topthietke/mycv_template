@props([
    'label'       => null,
    'name'        => '',
    'id'          => null,
    'type'        => 'text',
    'placeholder' => '',
    'value'       => '',
    'required'    => false,
    'disabled'    => false,
    'readonly'    => false,
    'hint'        => null,
    'prefix'      => null,
    'suffix'      => null,
    'size'        => null,
    'error'       => null,
    'append'      => null,
])

@php
    $id        = $id ?? $name;
    $sizeClass = $size ? "form-control-{$size}" : '';
    $errors    = $errors ?? session()->get('errors', new \Illuminate\Support\MessageBag);
    $serverError = $errors->first($name);
    $errorMsg    = $serverError ?: $error;
    $hasAddon  = $prefix || $suffix || isset($append);
@endphp

<div class="mb-3">
    {{-- Label --}}
    @if ($label)
        <label for="{{ $id }}" class="form-label fw-semibold fw-medium">
            {{ $label }}
            @if ($required)
                <span class="text-danger ms-1">*</span>
            @endif
        </label>
    @endif

    {{-- Input with/without addons --}}
    @if ($hasAddon)
        <div class="input-group {{ $sizeClass ? "input-group-{$size}" : '' }}">
            @if ($prefix)
                <span class="input-group-text">{!! $prefix !!}</span>
            @endif

            <input
                type="{{ $type }}"
                id="{{ $id }}"
                name="{{ $name }}"
                value="{{ old($name, $value) }}"
                placeholder="{{ $placeholder }}"
                {{ $required  ? 'required'  : '' }}
                {{ $disabled  ? 'disabled'  : '' }}
                {{ $readonly  ? 'readonly'  : '' }}
                    {{ $attributes->merge(['class' => "form-control {$sizeClass}" . ($errorMsg ? ' is-invalid' : '')]) }}
            >

            @if ($suffix)
                <span class="input-group-text">{{ $suffix }}</span>
                @endif

                @if (isset($append))
                    {{ $append }}
            @endif

            @if ($errorMsg)
                <div class="invalid-feedback">{{ $errorMsg }}</div>
            @endif
        </div>
    @else
        <input
            data-show="1"
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required  ? 'required'  : '' }}
            {{ $disabled  ? 'disabled'  : '' }}
            {{ $readonly  ? 'readonly'  : '' }}
            {{ $attributes->merge(['class' => "form-control {$sizeClass}" . ($errorMsg ? ' is-invalid' : '')]) }}
        >        
        @if ($errorMsg)
            <div class="invalid-feedback">{{ $errorMsg }}</div>
        @endif
    @endif

    {{-- Hint text --}}
    @if ($hint && !$errorMsg)
        <div class="form-text text-muted">{{ $hint }}</div>
    @endif
</div>
