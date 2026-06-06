@props([
    'type'        => 'info',      // success | danger | warning | info | primary | secondary | dark | light
    'dismissible' => false,
    'icon'        => null,        // Bootstrap Icons class
    'title'       => null,
])

@php
    $defaultIcons = [
        'success'   => 'bi bi-check-circle-fill',
        'danger'    => 'bi bi-x-circle-fill',
        'warning'   => 'bi bi-exclamation-triangle-fill',
        'info'      => 'bi bi-info-circle-fill',
        'primary'   => 'bi bi-bell-fill',
        'secondary' => 'bi bi-chat-fill',
        'dark'      => 'bi bi-moon-fill',
        'light'     => 'bi bi-sun-fill',
    ];
    $iconClass = $icon ?? ($defaultIcons[$type] ?? null);
@endphp

<div
    role="alert"
    {{ $attributes->merge(['class' => "alert alert-{$type}" . ($dismissible ? ' alert-dismissible fade show' : '')]) }}
>
    @if ($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
    @endif

    @if ($title)
        <div class="d-flex align-items-center">
            @if ($iconClass)
                <i class="{{ $iconClass }} me-2 flex-shrink-0"></i>
            @endif
            <strong>{{ $title }}</strong>
        </div>
        <div class="{{ $iconClass ? 'ps-4' : '' }} mt-1">{{ $slot }}</div>
    @else
        <div class="d-flex align-items-start gap-2">
            @if ($iconClass)
                <i class="{{ $iconClass }} flex-shrink-0 mt-1"></i>
            @endif
            <div>{{ $slot }}</div>
        </div>
    @endif
</div>
