<!-- BODY -->
<?php 
    $allow_page   = config('data.page');
    $allow_page_3 = $allow_page['3'];    
?>
@if (!empty($categories))
    <div class="cv-page" id="cv-page-3" style="margin-top: 30px;">
        <!-- /cv-body -->
        <div class="cv-body" style="padding-top:30px;">
            @foreach ($categories as $item)
                @if ($item['pages'] == $allow_page_3)
                    <div class="cv-section">
                        <div class="cv-section__header">
                            <div class="cv-section__label" id="{{ $item['id'] }}" data-code="{{ $item['code'] }}">
                                {{ $item['name'] ?? '' }}
                            </div>
                            <div class="cv-section__line"></div>
                        </div>

                        <div class="cv-entry">
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
        <!-- /cv-body -->
    </div>
@endif