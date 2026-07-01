<!-- BODY -->
<?php 
    $allow_page = config('data.page');
    $allow_page_1 = $allow_page['page_1'];    
?>
@if (!empty($categories))
    <div class="cv-body">
        @foreach ($categories as $item)
            @if ($item['pages'] == $allow_page_1)
                <div class="cv-section">
                <div class="cv-section__header">
                    <div class="cv-section__label" id="{{ $item['id'] }}" data-code="{{ $item['code'] }}">{{ $item['name'] ?? '' }}</div>
                    <div class="cv-section__line"></div>
                </div>
                <div class="cv-intro">
                    @if (!empty($item['contents']))
                        @foreach ($item['contents'] as $value)
                            <span>{!! $value['content'] !!}</span>
                        @endforeach
                    @endif        
                </div>
            </div>    
            @endif
        @endforeach
    </div>
@endif

<!-- /cv-body -->