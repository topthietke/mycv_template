@props([
    'type'     => 'button',
    'variant'  => 'primary',   // primary | secondary | success | danger | warning | info | dark | light | link | outline-primary | ...
    'size'     => null,        // sm | lg
    'disabled' => false,
    'loading'  => false,
    'icon'     => null,        // Bootstrap Icons class, e.g. 'bi bi-save'
    'iconEnd'  => null,        // icon after label
    'block'    => false,       // full width
    'href'     => null,        // render as <a> tag
    'target'   => null,
])

@php
    $sizeClass  = $size ? "btn-{$size}" : '';
    $blockClass = $block ? 'w-100' : '';
    $isLoading  = $loading;
    $isDisabled = $disabled || $isLoading;

    $classes = "btn btn-{$variant} {$sizeClass} {$blockClass}";
@endphp

@if ($href)
    {{-- Render as anchor --}}
    <a
        href="{{ $href }}"
        target="{{ $target }}"
        {{ $isDisabled ? 'aria-disabled=true tabindex=-1' : '' }}
        {{ $attributes->merge(['class' => $classes . ($isDisabled ? ' disabled' : '')]) }}
    >
        @if ($isLoading)
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
        @elseif ($icon)
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'me-1' : '' }}"></i>
        @endif

        {{ $slot }}

        @if ($iconEnd && !$isLoading)
            <i class="{{ $iconEnd }} {{ $slot->isNotEmpty() ? 'ms-1' : '' }}"></i>
        @endif
    </a>
@else
    {{-- Render as button --}}
    <button
        type="{{ $type }}"
        {{ $isDisabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if ($isLoading)
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            <span>Đang xử lý...</span>
        @else
            @if ($icon)
                <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'me-1' : '' }}"></i>
            @endif

            {{ $slot }}

            @if ($iconEnd)
                <i class="{{ $iconEnd }} {{ $slot->isNotEmpty() ? 'ms-1' : '' }}"></i>
            @endif
        @endif
    </button>
@endif
