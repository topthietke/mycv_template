<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    

</head>

<body>

    <div class="container">
        <div class="form-container">
            <a href="#" class="back-login-link"><i class="fas fa-arrow-left"></i> Đăng nhập</a>

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

            {{-- @include('name') --}}

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Logic mô phỏng chuyển đổi giữa các Step form
        function goToStep(step) {
            // Ẩn tất cả form
            $('.step-form').removeClass('active');
            
            // Xóa trạng thái active của indicator
            $('.step').removeClass('active completed');

            // Cập nhật giao diện thanh hiển thị (progress bar)
            if (step === 1) {
                $('#candidateForm').addClass('active');
                $('#indicator-1').addClass('active');
                $('#progress-line').css('width', '0%');
            } else if (step === 2) {
                $('#categoryForm').addClass('active');
                $('#indicator-1').addClass('completed');
                $('#indicator-2').addClass('active');
                $('#progress-line').css('width', '50%');
            } else if (step === 3) {
                $('#detailsForm').addClass('active');
                $('#indicator-1').addClass('completed');
                $('#indicator-2').addClass('completed');
                $('#indicator-3').addClass('active');
                $('#progress-line').css('width', '100%');
            }
        }
        
        // JS Xử lý Submit bạn có thể giữ nguyên như cũ ở đây 
        $(document).ready(function() {
            // Logic validation và AJAX bạn đã viết trước đó...
        });
    </script>
</body>

</html>