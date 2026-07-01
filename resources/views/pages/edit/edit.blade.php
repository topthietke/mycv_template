<?php 
    $title = config('data.edit.title', 'Chỉnh sửa thông tin');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    @include('head')
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">   
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="row">
                <div class="col-md-12 text-left">
                    <a href="{{ route('home') }}" class="label-back-login" style="text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> 
                        <span class="px-1" >{{ config('data.index.home_title') }}</span>
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
                    <div class="step active" id="indicator-1">
                        <div class="icon"><i class="fas fa-user"></i></div>
                        <p>Thông tin cá nhân</p>
                    </div>
                    <div class="step" id="indicator-2">
                        <div class="icon"><i class="fas fa-list"></i></div>
                        <p>Chọn danh mục</p>
                    </div>
                    <div class="step" id="indicator-3">
                        <div class="icon"><i class="fas fa-file-alt"></i></div>
                        <p>Nhập nội dung</p>
                    </div>
                </div>
            </div>
            
             {{-- ================================ Bước 1: Thông tin cá nhân =============================== --}}
             @include('auth.forms.candidate_form')
             {{-- ================================ Bước 2: Chọn danh mục =============================== --}}
             @include('auth.forms.categories_form')
             {{-- ================================ Bước 3: Nhập nội dung cho các mục đã chọn =============================== --}}
             @include('auth.forms.content_form')
             {{-- ================================ Modal thêm danh mục mới =============================== --}}
             @include('auth.forms.modal_add_categories')
             {{-- ================================ Các scripts cần thiết =============================== --}}
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@41.4.2/build/ckeditor.js"></script>    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="/assets/js/register.js"></script>

</body>

</html>