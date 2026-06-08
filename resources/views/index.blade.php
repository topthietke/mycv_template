<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
</head>

<body>

    <div class="container">
        <div class="form-container">
            <div class="row">
                <div class="col-md-12 text-left">
                    <a href="{{ route('login') }}" class="label-back-login" style="text-decoration: none;">
                        <i class="fas fa-arrow-left mr-3"></i> 
                        <span class="px-3" >Đăng nhập</span>
                    </a>
                </div>
                <div class="col-md-12 text-center my-3">
                    <h4 class="fw-bold">Đăng ký tài khoản</h4>
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
             @include('forms.candidate_form')
             {{-- ================================ Bước 2: Chọn danh mục =============================== --}}
             @include('forms.categories_form')
             {{-- ================================ Bước 3: Nhập nội dung cho các mục đã chọn =============================== --}}
             @include('forms.content_form')
             {{-- ================================ Modal thêm danh mục mới =============================== --}}
             @include('forms.modal_add_categories')
             {{-- ================================ Các scripts cần thiết =============================== --}}
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="/assets/js/auth.js"></script>
</body>

</html>