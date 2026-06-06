@props([
    'label'    => null,
    'name'     => '',
    'id'       => null,
    'accept'   => null,        // e.g. 'image/*', '.pdf,.docx'
    'multiple' => false,
    'required' => false,
    'disabled' => false,
    'hint'     => null,
    'error'    => null,
    'preview'  => false,       // show image preview (images only)
    'size'     => null,        // sm | lg
])

@php
    $id        = $id ?? $name;
    $sizeClass = $size ? "form-control-{$size}" : '';
    $errors    = $errors ?? session()->get('errors', new \Illuminate\Support\MessageBag);
    $errorMsg  = $error ?? ($errors->first($name) ?: null);
    $previewId = $id . '_preview';
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

    <input
        type="file"
        id="{{ $id }}"
        name="{{ $multiple ? $name . '[]' : $name }}"
        {{ $accept   ? "accept={$accept}" : '' }}
        {{ $multiple  ? 'multiple'  : '' }}
        {{ $required  ? 'required'  : '' }}
        {{ $disabled  ? 'disabled'  : '' }}
        {{ $attributes->merge(['class' => "form-control {$sizeClass}" . ($errorMsg ? ' is-invalid' : '')]) }}
        @if ($preview)
            onchange="
                const files = this.files;
                const previewEl = document.getElementById('{{ $previewId }}');
                previewEl.innerHTML = '';
                Array.from(files).forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail mt-2 me-2';
                        img.style.maxHeight = '120px';
                        previewEl.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            "
        @endif
    >

    @if ($preview)
        <div id="{{ $previewId }}" class="d-flex flex-wrap"></div>
    @endif

    @if ($errorMsg)
        <div class="invalid-feedback d-block">{{ $errorMsg }}</div>
    @endif

    @if ($hint && !$errorMsg)
        <div class="form-text text-muted">{{ $hint }}</div>
    @endif
</div>
