<div class="cv-header">
    <div class="cv-header__photo">         
        <img src="{{ $candidate['avatar']  ?? '/assets/img/avatar.png' }}" alt="{{ $candidate['fullname'] ?? ''}}" />
    </div>
    <div class="cv-header__info">
        <div class="cv-header__name">
            {{ $candidate['fullname'] ?? ''}}
        </div>
        <div class="cv-header__title">
            {{ $candidate['position'] ?? '' }}
        </div>
        <div class="cv-header__divider"></div>
        <div class="cv-header__contacts">
            <span>
                <i class="fa fa-gift text-danger"></i>
                {{ $candidate['birthday'] ?? ''}}
            </span>
            <span>
                <i class="fa fa-phone text-primary" aria-hidden="true"></i>
                {{ $candidate['phone'] ?? ''}}
            </span>
            <span>
                <i class="fa fa-address-card" aria-hidden="true"></i>
                {{ $candidate['email'] ?? ''}}
            </span>
            <span>
                <i class="fa fa-map-marker text-dark" aria-hidden="true"></i>
                {{ $candidate['current_address'] ?? ''}}
            </span>
            <span>
                @if (!empty($candidate['website_url']))
                    <i class="fa fa-globe text-primary" aria-hidden="true"></i>
                    <a href="{{ 'http://' . $candidate['website_url'] ?? ''}}" target="_blank">
                        {{ $candidate['website_url'] ?? ''}}
                    </a>
                @endif
            </span>
            <span>
                @if (!empty($candidate['git_url']))
                    <i class="fa-brands fa-git fa-lg text-danger"></i>
                    <a href="{{ 'http://' . $candidate['git_url'] ?? ''}}" target="_blank">
                        {{ $candidate['git_url'] ?? ''}}
                    </a>
                @endif

            </span>
        </div>
    </div>
</div>