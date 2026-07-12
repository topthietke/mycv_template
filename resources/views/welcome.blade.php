<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - Bước 2</title>
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

        /* --- Header & Stepper CSS --- */
        .step-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 50px;
            position: relative;
        }

        /* Line chạy dưới stepper - 50% màu xanh cho đến bước 2 */
        .step-indicator::before {
            content: "";
            position: absolute;
            top: 30%;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(to right, #4f46e5 50%, #e0e0e0 50%);
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

        /* Trạng thái đã hoàn thành (Bước 1) */
        .step.completed .icon {
            background-color: #fff;
            color: #4f46e5;
            border-color: #4f46e5;
        }

        /* Trạng thái đang active (Bước 2) */
        .step.active .icon {
            background-color: #4f46e5;
            color: white;
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2);
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

        /* --- Nút bấm --- */
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

        .btn-back-step {
            background-color: #fff;
            color: #374151;
            padding: 10px 30px;
            border-radius: 8px;
            font-weight: 600;
            border: 1px solid #d1d5db;
        }

        .btn-back-step:hover {
            background-color: #f3f4f6;
        }

        .header-top {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .login-link {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        /* --- Category Card CSS --- */
        .category-card {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 20px;
            height: 100%;
        }

        .category-card:hover {
            border-color: #a5b4fc;
        }

        /* Trạng thái được chọn */
        .category-card.selected {
            border-color: #4f46e5;
            background-color: #eff6ff; /* Màu nền xanh nhạt */
        }

        .category-icon {
            font-size: 28px;
            color: #6b7280;
            width: 40px;
            text-align: center;
            transition: color 0.2s ease;
        }

        .category-card.selected .category-icon {
            color: #4f46e5;
        }

        .category-info h6 {
            font-weight: 600;
            color: #111827;
            margin-bottom: 4px;
            font-size: 16px;
        }

        .category-info p {
            color: #6b7280;
            font-size: 13px;
            margin: 0;
        }

        /* Ẩn checkbox thật */
        .hidden-checkbox {
            display: none;
        }
        
        hr.footer-divider {
            margin-top: 40px;
            margin-bottom: 20px;
            border-color: #e5e7eb;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-container">
            <div class="header-top">
                <a href="/login" class="login-link"><i class="fas fa-arrow-left"></i> Đăng nhập</a>
            </div>

            <div class="step-indicator">
                <div class="step completed">
                    <div class="icon"><i class="fas fa-user"></i></div>
                    <p>Thông tin cá nhân</p>
                </div>
                <div class="step active">
                    <div class="icon"><i class="fas fa-list"></i></div>
                    <p>Chọn danh mục</p>
                </div>
                <div class="step">
                    <div class="icon"><i class="fas fa-file-alt"></i></div>
                    <p>Nhập nội dung</p>
                </div>
            </div>

            <h4 class="mb-2 fw-bold">Bước 2: Đăng ký danh mục của cá nhân</h4>
            <p class="text-muted mb-4">Chọn những mục bạn muốn thêm thông tin vào hồ sơ ứng viên của mình.</p>

            <form id="categoryForm">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="category-card" for="cat_objective">
                            <input type="checkbox" name="categories[]" value="objective" id="cat_objective" class="hidden-checkbox">
                            <div class="category-icon"><i class="fas fa-bullseye"></i></div>
                            <div class="category-info">
                                <h6>Mục tiêu nghề nghiệp</h6>
                                <p>Định hướng sự nghiệp của bạn</p>
                            </div>
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="category-card" for="cat_skills">
                            <input type="checkbox" name="categories[]" value="skills" id="cat_skills" class="hidden-checkbox">
                            <div class="category-icon"><i class="fas fa-bolt"></i></div>
                            <div class="category-info">
                                <h6>Kỹ năng</h6>
                                <p>Các công nghệ, công cụ thuần thục</p>
                            </div>
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="category-card" for="cat_experience">
                            <input type="checkbox" name="categories[]" value="experience" id="cat_experience" class="hidden-checkbox">
                            <div class="category-icon"><i class="fas fa-briefcase"></i></div>
                            <div class="category-info">
                                <h6>Kinh nghiệm làm việc</h6>
                                <p>Lịch sử và các dự án từng tham gia</p>
                            </div>
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="category-card" for="cat_education">
                            <input type="checkbox" name="categories[]" value="education" id="cat_education" class="hidden-checkbox">
                            <div class="category-icon"><i class="fas fa-graduation-cap"></i></div>
                            <div class="category-info">
                                <h6>Học vấn & Bằng cấp</h6>
                                <p>Trường học và các chứng chỉ đạt được</p>
                            </div>
                        </label>
                    </div>
                </div>

                <hr class="footer-divider">

                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-back-step" onclick="window.history.back()">Quay lại</button>
                    <button type="submit" class="btn btn-next" id="btnSubmitCategories">
                        Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Hàm lấy cookie (để lấy token đã lưu ở bước 1)
            function getCookie(name) {
                let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
                if (match) return match[2];
                return null;
            }

            // Xử lý UI khi click vào Card
            $('.category-card').on('click', function() {
                let checkbox = $(this).find('.hidden-checkbox');
                
                // Do chúng ta dùng thẻ <label> bọc checkbox, HTML sẽ tự động toggle trạng thái checked.
                // Hàm setTimeout(0) giúp jQuery đọc đúng trạng thái checked SAU KHI HTML đã xử lý xong.
                setTimeout(() => {
                    if (checkbox.is(':checked')) {
                        $(this).addClass('selected');
                    } else {
                        $(this).removeClass('selected');
                    }
                }, 0);
            });

            // Gửi dữ liệu khi bấm "Tiếp theo"
            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();

                // Kiểm tra xem user đã chọn ít nhất 1 danh mục chưa
                let selectedCategories = [];
                $('input[name="categories[]"]:checked').each(function() {
                    selectedCategories.push($(this).val());
                });

                if (selectedCategories.length === 0) {
                    alert('Vui lòng chọn ít nhất một danh mục để tiếp tục!');
                    return;
                }

                let token = getCookie('auth_token');
                
                // --- KỊCH BẢN API GỬI DANH MỤC LÊN SERVER ---
                /*
                let $btn = $('#btnSubmitCategories');
                let originalText = $btn.html();
                $btn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);

                $.ajax({
                    url: "{{ env('API_HOST') }}/api/candidate/categories", // URL API thêm mới danh mục
                    type: 'POST',
                    data: JSON.stringify({ categories: selectedCategories }),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                        'Authorization': 'Bearer ' + token // Gắn token vào header
                    },
                    success: function(response) {
                        // Chuyển sang Bước 3
                        window.location.href = "/register/step-3";
                    },
                    error: function(xhr) {
                        $btn.html(originalText).prop('disabled', false);
                        alert('Đã xảy ra lỗi. Vui lòng thử lại!');
                    }
                });
                */

                // Tạm thời nếu chưa nối API, bạn có thể chuyển hướng thẳng sang bước 3:
                console.log("Các danh mục đã chọn:", selectedCategories);
                console.log("Token hiện tại:", token);
                // window.location.href = "/register/step-3";
                alert("Đã nhận danh mục! Code gọi API đã được chuẩn bị sẵn trong file. Bạn mở console (F12) để xem log nhé.");
            });
        });
    </script>
</body>

</html>