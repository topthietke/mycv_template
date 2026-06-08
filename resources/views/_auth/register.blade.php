<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ cá nhân</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card card-custom-register pt-2 pb-4 p-md-4">
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-start mb-4 mt-2">
                            <a href="/" class="back-to-login"><i class="bi bi-arrow-left me-2"></i>Đăng nhập</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 text-center mb-4">
                            <h4 class="fw-bold"><strong>Đăng ký tài khoản</strong></h4>
                        </div>
                    </div>
                    <div class="step-progress">
                        <div class="step-progress-bar" id="progressBar"></div>
                        <div class="step-item active" data-step="1">
                            <div class="step-icon"><i class="bi bi-person"></i></div>
                            <div class="step-label">Thông tin cá nhân</div>
                        </div>
                        <div class="step-item" data-step="2">
                            <div class="step-icon"><i class="bi bi-list-check"></i></div>
                            <div class="step-label">Chọn danh mục</div>
                        </div>
                        <div class="step-item" data-step="3">
                            <div class="step-icon"><i class="bi bi-file-earmark-text"></i></div>
                            <div class="step-label">Nhập nội dung</div>
                        </div>
                    </div>
                    
                    <form id="multiStepForm" novalidate>
                        {{-- Bước 1: Đăng ký thông tin cá nhân --}}
                        @include('auth.form.register_data_step_1')
                        {{-- Bước 2: Đăng ký danh mục của cá nhân --}}
                        @include('auth.form.register_data_step_2')
                        <!-- Bước 3: Nhập thông tin chi tiết -->
                        @include('auth.form.register_data_step_3')
                        {{-- Nút điều hướng giữa các bước --}}
                        @include('auth.form.button')
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <script src="/assets/js/auth.js"></script>
</body>

</html>