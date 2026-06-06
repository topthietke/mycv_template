<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - Bước 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/step_1.css">
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

            <!-- {{-- ======================================== Bước 1: Thông tin cá nhân ======================================== --}} -->
            <form id="candidateForm" enctype="multipart/form-data">
                @csrf
                <h5 class="mb-4 fw-bold">Bước 1: Thông tin cá nhân</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <x-input type="text" name="fullname" class="form-control" placeholder="Nhập họ và tên" />
                        <div class="error-message">Vui lòng nhập họ và tên</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Vị trí ứng tuyển <span class="text-danger">*</span></label>
                        <x-input type="text" name="position" class="form-control"
                            placeholder="Nhập vị trí ứng tuyển" />
                        <div class="error-message">Vui lòng nhập vị trí ứng tuyển</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                        <x-input type="date" name="birthday" class="form-control" />
                        <div class="error-message">Vui lòng chọn ngày sinh</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                        <x-select name="gender" class="form-select">
                            <option value="">__ Chọn __</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </x-select>
                        <div class="error-message">Vui lòng chọn giới tính</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <x-input type="email" name="email" class="form-control" placeholder="Nhập email" />
                        <div class="error-message">Vui lòng nhập email hợp lệ</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <x-input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" />
                        <div class="error-message">Vui lòng nhập số điện thoại</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Số CMND/CCCD</label>
                        <x-input type="text" name="identity_card" class="form-control"
                            placeholder="Nhập số CMND/CCCD" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ngày cấp</label>
                        <x-input type="date" name="identity_date" class="form-control" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nơi cấp</label>
                        <x-input type="text" name="identity_place" class="form-control" placeholder="Nhập nơi cấp" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Quê quán</label>
                        <x-input type="text" name="home_town" class="form-control" placeholder="Nhập quê quán" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Địa chỉ hiện tại</label>
                        <x-input type="text" name="current_address" class="form-control"
                            placeholder="Nơi ở hiện tại" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mức lương mong muốn (VNĐ)</label>
                        <x-input type="number" name="expected_salary" class="form-control"
                            placeholder="Nhập Mức lương mong muốn" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ảnh đại diện</label>
                        <x-file name="avatar" class="form-control" accept="image/*" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Địa chỉ Facebook</label>
                        <x-input type="text" name="facebook_url" class="form-control"
                            placeholder="Nhập địa chỉ Facebook" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Địa chỉ Git</label>
                        <x-input type="text" name="git_url" class="form-control"
                            placeholder="Nhập địa chỉ Git" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Địa chỉ Website</label>
                        <x-input type="text" name="website_url" class="form-control"
                            placeholder="Nhập địa chỉ Website" />
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-5">
                    <x-button type="submit" class="btn btn-next" id="btnSubmit">
                        Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
                    </x-button>
                </div>
            </form>
            <!-- {{-- =============================================================================== Bước 2: Đăng ký danh mục của cá nhân ========================================  --}} -->
            <form id="categoryForm">
                @csrf
                <h4 class="mb-2 fw-bold">Bước 2: Đăng ký danh mục của cá nhân</h4>
                <p class="text-muted mb-4">Chọn những mục bạn muốn thêm thông tin vào hồ sơ ứng viên của mình.</p>


                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="category-card" for="cat_objective">
                            <input type="checkbox" name="categories[]" value="objective" id="cat_objective"
                                class="hidden-checkbox">
                            <div class="category-icon"><i class="fas fa-bullseye"></i></div>
                            <div class="category-info">
                                <h6>Mục tiêu nghề nghiệp</h6>
                                <p>Định hướng sự nghiệp của bạn</p>
                            </div>
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="category-card" for="cat_skills">
                            <input type="checkbox" name="categories[]" value="skills" id="cat_skills"
                                class="hidden-checkbox">
                            <div class="category-icon"><i class="fas fa-bolt"></i></div>
                            <div class="category-info">
                                <h6>Kỹ năng</h6>
                                <p>Các công nghệ, công cụ thuần thục</p>
                            </div>
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="category-card" for="cat_experience">
                            <input type="checkbox" name="categories[]" value="experience" id="cat_experience"
                                class="hidden-checkbox">
                            <div class="category-icon"><i class="fas fa-briefcase"></i></div>
                            <div class="category-info">
                                <h6>Kinh nghiệm làm việc</h6>
                                <p>Lịch sử và các dự án từng tham gia</p>
                            </div>
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="category-card" for="cat_education">
                            <input type="checkbox" name="categories[]" value="education" id="cat_education"
                                class="hidden-checkbox">
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
                    <button type="button" class="btn btn-back-step" onclick="window.history.back()">Quay
                        lại</button>
                    <button type="submit" class="btn btn-next" id="btnSubmitCategories">
                        Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>

            <!-- {{-- =============================================================================== Bước 3: Nhập nội dung chi tiết cho từng danh mục đã chọn ========================================  --}} -->
            <form id="detailsForm">
                <div class="mb-4">
                    <h3 class="fw-bold mb-2">Bước 3: Nhập thông tin chi tiết</h3>
                    <p class="text-muted" style="font-size: 14px;">Vui lòng hoàn thiện nội dung cho các phần danh mục bạn
                        vừa lựa chọn.</p>
                </div>
                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-bullseye"></i> Mục tiêu nghề nghiệp
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Chi tiết mục tiêu ngắn hạn & dài hạn <span
                                class="text-asterisk">*</span></label>
                        <textarea class="form-control is-valid custom-input" rows="3" required>dfadf</textarea>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-lightning-charge"></i> Kỹ năng chuyên môn
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Các kỹ năng cốt lõi (Cách nhau bằng dấu phẩy) <span
                                class="text-asterisk">*</span></label>
                        <input type="text" class="form-control is-valid custom-input" value="ádfasdf" required>
                    </div>
                </div>

                <div class="bottom-divider"></div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-back">Quay lại</button>
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-check-circle-fill"></i> Hoàn thành & Gửi
                    </button>
                </div>

            </form>

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
                                'Đăng ký thành công nhưng không nhận được Token. Vui lòng kiểm tra lại API!'
                            );
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