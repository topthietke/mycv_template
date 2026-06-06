<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - Hệ thống ứng viên</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/style.css">

</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card card-custom">
        
        <div id="requestState" class="fade-in">
            <div class="text-center">
                <div class="icon-box">
                    <i class="bi bi-key" style="font-size:20px;"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Quên mật khẩu?</h4>
                <p class="text-muted small mb-4">Nhập đầy đủ thông tin để đặt lại mật khẩu.</p>
            </div>

            <form id="forgotPasswordForm" novalidate>
                <div class="mb-4">
                    <label class="form-label fw-medium">Địa chỉ email <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control border-start-0 ps-0" name="email" id="emailInput" required placeholder="name@example.com">
                        <div class="invalid-feedback">Vui lòng điền một địa chỉ email hợp lệ.</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mb-3">
                    Gửi liên kết khôi phục
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="/" class="back-to-login"><i class="bi bi-arrow-left me-2"></i>Đăng nhập</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const form = document.getElementById('forgotPasswordForm');
    const requestState = document.getElementById('requestState');
    const successState = document.getElementById('successState');
    const emailInput = document.getElementById('emailInput');
    const targetEmail = document.getElementById('targetEmail');

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        
        // Bật trạng thái kiểm tra lỗi của Bootstrap 5
        form.classList.add('was-validated');

        // Nếu email hợp lệ, chuyển đổi trạng thái giao diện sang thành công
        if (form.checkValidity()) {
            targetEmail.textContent = emailInput.value;
            toggleState(true);
        }
    });

    // Hàm chuyển đổi giao diện ẩn/hiện mượt mà
    function toggleState(isSuccess) {
        if (isSuccess) {
            requestState.style.display = 'none';
            successState.style.display = 'block';
        } else {
            form.classList.remove('was-validated');
            requestState.style.display = 'block';
            successState.style.display = 'none';
        }
    }

    // Giả lập chức năng click gửi lại mã
    function resendEmail() {
        alert("🔄 Một email khôi phục mới đã được gửi tới: " + emailInput.value);
    }
</script>
</body>
</html>