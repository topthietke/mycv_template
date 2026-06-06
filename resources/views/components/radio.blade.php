@props([
    'label'    => '',
    'name'     => '',
    'id'       => null,
    'value'    => '',
    'checked'  => false,
    'disabled' => false,
    'hint'     => null,
    'error'    => null,
    'inline'   => false,
])

@php
    $id        = $id ?? $name . '_' . $value;
    $errors    = $errors ?? session()->get('errors', new \Illuminate\Support\MessageBag);
    $errorMsg  = $error ?? ($errors->first($name) ?: null);
    $isChecked = (string) old($name, $checked ? $value : null) === (string) $value;
    $wrapClass = 'form-check' . ($inline ? ' form-check-inline' : '') . ' mb-2';
@endphp

<div class="{{ $wrapClass }}">
    <input
        class="form-check-input {{ $errorMsg ? 'is-invalid' : '' }}"
        type="radio"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $isChecked ? 'checked' : '' }}
        {{ $disabled  ? 'disabled' : '' }}
        {{ $attributes }}
    >

    @if ($label)
        <label class="form-check-label" for="{{ $id }}">
            {{ $label }}
        </label>
    @endif

    @if ($errorMsg)
        <div class="invalid-feedback">{{ $errorMsg }}</div>
    @endif

    @if ($hint && !$errorMsg)
        <div class="form-text text-muted">{{ $hint }}</div>
    @endif
</div>
