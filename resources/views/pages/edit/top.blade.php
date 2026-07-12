<div class="row">
    <div class="col-md-12 text-left">
        <a href="{{ route('home') }}" class="label-back-login" style="text-decoration: none;">
            <i class="fas fa-arrow-left"></i>
            <span class="px-1">{{ config('data.index.home_title') }}</span>
        </a>
    </div>
    <div class="col-md-12 text-center my-3">
        <h4 class="fw-bold">{{ $title }}</h4>
    </div>
</div>

<div class="step-indicator-wrapper">
    <div class="step-line"></div>
    <div class="step-line-active" id="progress-line" style="width: 0%;"></div>
    <div class="step-indicator">
        <div class="step active" id="candidate">
            <div class="icon"><i class="fas fa-user"></i></div>
            <p>Thông tin cá nhân</p>
        </div>
        <div class="step" id="categories">
            <div class="icon"><i class="fas fa-list"></i></div>
            <p>Chọn danh mục</p>
        </div>
        <div class="step" id="contents">
            <div class="icon"><i class="fas fa-file-alt"></i></div>
            <p>Nhập nội dung</p>
        </div>
    </div>
</div>