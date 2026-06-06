@props([
    'title'     => null,
    'subtitle'  => null,
    'footer'    => null,
    'headerBg'  => null,      // bg-primary, bg-light, ...
    'border'    => null,      // border-primary, border-danger, ...
    'shadow'    => false,
    'flush'     => false,     // no padding (card-body padding removed)
])

@php
    $shadowClass = $shadow ? 'shadow' : '';
    $borderClass = $border ? "border {$border}" : '';
@endphp

<div {{ $attributes->merge(['class' => "card {$shadowClass} {$borderClass}"]) }}>

    {{-- Header --}}
    @if ($title)
        <div class="card-header {{ $headerBg }} d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">{{ $title }}</h5>
                @if ($subtitle)
                    <small class="text-muted">{{ $subtitle }}</small>
                @endif
            </div>
            {{-- Slot cho action buttons bên phải header --}}
            @isset($actions)
                <div class="d-flex gap-2">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif

    {{-- Body --}}
    <div class="{{ $flush ? '' : 'card-body' }}">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    @if ($footer || isset($footerSlot))
        <div class="card-footer text-muted">
            @isset($footerSlot)
                {{ $footerSlot }}
            @else
                {{ $footer }}
            @endisset
        </div>
    @endif
</div>
