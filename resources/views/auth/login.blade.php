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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
{{-- onsubmit="return handleLogin(event)" --}}
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card card-custom px-4 py-4">
                    <div class="brand-logo text-center my-2">
                        <i class="fa fa-sign-in fa-3x text-primary" aria-hidden="true"></i>
                    </div>

                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-1">Đăng nhập tài khoản</h3>
                        <p class="text-muted small">Vui lòng nhập thông tin để truy cập hệ thống</p>
                    </div>

                    <form id="loginForm" novalidate >
                        <x-input name="email" type="email" label="Địa chỉ Email" placeholder="Email" required prefix='<i class="fa fa-user"></i>' />
                        <x-input name="password" type="password" label="Mật khẩu" placeholder="Mật khẩu" required prefix='<i class="fa fa-lock"></i>'>
                            <x-slot:append>
                                <x-button variant="light" class="input-group-text" type="button"
                                    onclick="togglePasswordVisibility()"
                                    style="border: 1px solid #ccc; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                                    <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                </x-button>
                            </x-slot:append>
                        </x-input>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <x-checkbox name="remember_me" label="Ghi nhớ đăng nhập" id="rememberMe" />
                            <a href="{{ route('forgot.password') }}" class="small text-link">Quên mật khẩu?</a>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <x-button href="{{ route('register') }}" variant="success py-2 px-4"
                                    icon="fa fa-long-arrow-left" class="back-to-login p-0 text-decoration-none">
                                    Đăng ký
                                </x-button>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="mb-4 d-flex justify-content-end">
                                    <x-button type="submit" variant="primary px-3 py-2" iconEnd="bi bi-arrow-right">
                                        Đăng nhập
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="/assets/js/login.js"></script>
    <script>
        function togglePasswordVisibility() {            
            const passwordInput = document.getElementById("password");
            const icon = document.getElementById("togglePasswordIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

    </script>
</body>

</html>