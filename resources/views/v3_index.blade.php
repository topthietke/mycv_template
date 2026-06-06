<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - Bước 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            max-width: 900px;
            margin: 40px auto;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
        }

        .step-indicator::before {
            content: "";
            position: absolute;
            top: 30%;
            left: 10%;
            right: 10%;
            height: 2px;
            background-color: #e0e0e0;
            z-index: 1;
        }

        .step {
            text-align: center;
            position: relative;
            z-index: 2;
            background: #fff;
            padding: 0 10px;
            flex: 1;
        }

        .step .icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            font-size: 20px;
            background-color: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e0e0e0;
        }

        .step.active .icon {
            background-color: #4f46e5;
            color: white;
            border-color: #4f46e5;
        }

        .step.active p {
            color: #4f46e5;
            font-weight: 600;
        }

        .step p {
            margin: 0;
            font-size: 14px;
            color: #6c757d;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        .text-danger {
            color: #ef4444 !important;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #d1d5db;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .btn-next {
            background-color: #4f46e5;
            color: white;
            padding: 10px 30px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
        }

        .btn-next:hover {
            background-color: #4338ca;
            color: white;
        }

        .back-link {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-container">
            <a href="#" class="back-link"><i class="fas fa-arrow-left"></i> Đăng nhập</a>

            <h3 class="text-center mt-3 mb-5 fw-bold">Đăng ký tài khoản</h3>

            <div class="step-indicator">
                <div class="step active">
                    <div class="icon"><i class="fas fa-user"></i></div>
                    <p>Thông tin cá nhân</p>
                </div>
                <div class="step">
                    <div class="icon"><i class="fas fa-list"></i></div>
                    <p>Chọn danh mục</p>
                </div>
                <div class="step">
                    <div class="icon"><i class="fas fa-file-alt"></i></div>
                    <p>Nhập nội dung</p>
                </div>
            </div>
            <hr>
            @include('forms.candidate_form')
            {{-- @include('forms.categories_form') --}}
            <hr>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Lấy API host từ file .env thông qua Laravel helper
            const API_URL = "{{ env('API_HOST') }}/api/candidate";

            $('#candidateForm').on('submit', function(e) {
                e.preventDefault();

                let isValid = true;

                // Reset error states
                $('.form-control, .form-select').removeClass('is-invalid');
                $('.error-message').hide();

                // Các trường bắt buộc theo design
                const requiredFields = ['fullname', 'position', 'birthday', 'gender', 'email', 'phone'];

                requiredFields.forEach(function(field) {
                    let input = $(`[name="${field}"]`);
                    let val = input.val().trim();

                    if (val === '') {
                        input.addClass('is-invalid');
                        input.siblings('.error-message').show();
                        isValid = false;
                    }

                    // Validate format email cơ bản
                    if (field === 'email' && val !== '') {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(val)) {
                            input.addClass('is-invalid');
                            input.siblings('.error-message').text('Email không đúng định dạng')
                                .show();
                            isValid = false;
                        }
                    }
                });

                if (!isValid) {
                    return false; // Dừng lại nếu validate fail
                }

                // Đổi trạng thái button
                let $btn = $('#btnSubmit');
                let originalText = $btn.html();
                $btn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);

                // Gom dữ liệu form (hỗ trợ cả file avatar)
                let formData = new FormData(this);

                $.ajax({
                    url: API_URL,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    // success: function(response) {
                    //     // Chuyển hướng sang bước 2 sau khi thành công
                    //     // Đổi route này theo route thực tế của bạn trong Laravel
                    //     window.location.href = "/register/step-2";
                    // },
                    // ... (code trước đó giữ nguyên)
                    success: function(response) {
                        // 1. Lấy token từ response (Giả sử API trả về json có key là 'token')
                        // Bạn cần điều chỉnh 'response.token' cho khớp với data thực tế API trả về
                        let token = response.token;

                        if (token) {
                            // 2. Lưu token vào Cookie, thời hạn 1 ngày (86400 giây)
                            document.cookie = "auth_token=" + token + "; path=/; max-age=86400";

                            // 3. Chuyển hướng sang bước 2
                            window.location.href = "/register/step-2";
                        } else {
                            alert(
                                'Đăng ký thành công nhưng không nhận được Token. Vui lòng kiểm tra lại API!');
                        }
                    },
                    // ... (code sau đó giữ nguyên)
                    error: function(xhr, status, error) {
                        $btn.html(originalText).prop('disabled', false);
                        alert('Đã xảy ra lỗi khi lưu thông tin. Vui lòng thử lại!');
                        console.error(xhr.responseText);
                    }
                });
            });

            // Xóa thông báo lỗi khi người dùng bắt đầu nhập lại
            $('.form-control, .form-select').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).siblings('.error-message').hide();
            });
        });
    </script>
</body>

</html>
