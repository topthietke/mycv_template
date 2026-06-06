@props([
    'id'          => 'modal',
    'title'       => 'Modal Title',
    'size'        => null,     // sm | lg | xl
    'scrollable'  => false,
    'centered'    => false,
    'static'      => false,    // prevent close on outside click
    'footer'      => true,
    'closeLabel'  => 'Đóng',
    'submitLabel' => null,
    'submitVariant' => 'primary',
    'formId'      => null,     // if set, submit button targets this form id
])

@php
    $sizeClass     = $size ? "modal-{$size}" : '';
    $scrollClass   = $scrollable ? 'modal-dialog-scrollable' : '';
    $centeredClass = $centered   ? 'modal-dialog-centered'   : '';
    $backdrop      = $static     ? 'data-bs-backdrop="static" data-bs-keyboard="false"' : '';
@endphp

<div
    class="modal fade"
    id="{{ $id }}"
    tabindex="-1"
    aria-labelledby="{{ $id }}Label"
    aria-hidden="true"
    {!! $backdrop !!}
>
    <div class="modal-dialog {{ $sizeClass }} {{ $scrollClass }} {{ $centeredClass }}">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ $closeLabel }}"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @if ($footer)
                <div class="modal-footer">
                    @isset($footerSlot)
                        {{ $footerSlot }}
                    @else
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ $closeLabel }}
                        </button>
                        @if ($submitLabel)
                            <button
                                type="submit"
                                class="btn btn-{{ $submitVariant }}"
                                {{ $formId ? "form={$formId}" : '' }}
                            >
                                {{ $submitLabel }}
                            </button>
                        @endif
                    @endisset
                </div>
            @endif

        </div>
    </div>
</div>
