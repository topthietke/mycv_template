<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Hệ Thống</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card card-custom p-4 p-md-5">

                    <div class="brand-logo">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-1">Đăng nhập tài khoản</h3>
                        <p class="text-muted small">Vui lòng nhập thông tin để truy cập hệ thống</p>
                    </div>

                    <form id="loginForm" novalidate onsubmit="return handleLogin(event)">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Địa chỉ Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" required placeholder="Email">
                                <div class="invalid-feedback">Vui lòng nhập địa chỉ email hợp lệ.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Mật khẩu <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" required
                                    placeholder="Mật khẩu">
                                <button class="btn input-group-text" type="button" onclick="togglePasswordVisibility()">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                                <div class="invalid-feedback">Vui lòng nhập mật khẩu.</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label small text-muted" for="rememberMe">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>
                            <a href="{{ route('forgot.password') }}" class="small text-link">Quên mật khẩu?</a>
                        </div>

                        <div class="mb-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Đăng nhập <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-end mb-4 mt-2">
                                <a href="{{ route('register') }}" class="back-to-login">
                                    Đăng ký tài khoản
                                    <i class="bi bi-arrow-right me-2"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/auth.js"></script>
</body>

</html>