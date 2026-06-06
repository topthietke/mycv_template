@props([
    'label'       => null,
    'name'        => '',
    'id'          => null,
    'placeholder' => '',
    'value'       => '',
    'rows'        => 4,
    'required'    => false,
    'disabled'    => false,
    'readonly'    => false,
    'hint'        => null,
    'maxlength'   => null,
    'error'       => null,
    'resize'      => true,  // false = no-resize
])

@php
    $id       = $id ?? $name;
    $errors   = $errors ?? session()->get('errors', new \Illuminate\Support\MessageBag);
    $errorMsg = $error ?? ($errors->first($name) ?: null);
    $content  = old($name, $value);
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

    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required'  : '' }}
        {{ $disabled ? 'disabled'  : '' }}
        {{ $readonly ? 'readonly'  : '' }}
        {{ $maxlength ? "maxlength={$maxlength}" : '' }}
        {{ $attributes->merge([
            'class' => 'form-control' . ($errorMsg ? ' is-invalid' : '') . (!$resize ? ' resize-none' : '')
        ]) }}
    >{{ $content }}</textarea>

    {{-- Character counter --}}
    @if ($maxlength)
        <div class="d-flex justify-content-between mt-1">
            @if ($hint && !$errorMsg)
                <div class="form-text text-muted">{{ $hint }}</div>
            @else
                <div></div>
            @endif
            <div class="form-text text-muted">
                <span id="{{ $id }}-count">{{ mb_strlen($content) }}</span>/{{ $maxlength }}
            </div>
        </div>
        <script>
            document.getElementById('{{ $id }}').addEventListener('input', function () {
                document.getElementById('{{ $id }}-count').textContent = this.value.length;
            });
        </script>
    @elseif ($hint && !$errorMsg)
        <div class="form-text text-muted">{{ $hint }}</div>
    @endif

    @if ($errorMsg)
        <div class="invalid-feedback d-block">{{ $errorMsg }}</div>
    @endif
</div>

<style>
    .resize-none { resize: none; }
</style>
