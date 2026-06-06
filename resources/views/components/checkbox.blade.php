@props([
    'label'    => '',
    'name'     => '',
    'id'       => null,
    'value'    => '1',
    'checked'  => false,
    'disabled' => false,
    'hint'     => null,
    'error'    => null,
    'switch'   => false,  // render as toggle switch
    'inline'   => false,
])

@php
    $id       = $id ?? $name;
    $errors   = $errors ?? session()->get('errors', new \Illuminate\Support\MessageBag);
    $errorMsg = $error ?? ($errors->first($name) ?: null);
    $isChecked = old($name, $checked) == $value || old($name) === true || (is_bool($checked) && $checked);

    $wrapClass = 'form-check' . ($switch ? ' form-switch' : '') . ($inline ? ' form-check-inline' : '') . ' mb-2';
@endphp

<div class="{{ $wrapClass }}">
    <input
        class="form-check-input {{ $errorMsg ? 'is-invalid' : '' }}"
        type="checkbox"
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
