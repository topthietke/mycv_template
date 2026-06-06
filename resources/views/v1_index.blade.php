<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản ứng viên</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    <div class="registration-container">
        <div class="form-header">
            <a href="#" class="back-to-login">← Đăng nhập</a>
            <h2>Đăng ký tài khoản</h2>
        </div>

        <div class="stepper">
            <div class="step active" id="step-indicator-1">
                <div class="step-icon">👤</div>
                <div class="step-label">Thông tin cá nhân</div>
            </div>
            <div class="step-line"></div>
            <div class="step" id="step-indicator-2">
                <div class="step-icon">📋</div>
                <div class="step-label">Chọn danh mục</div>
            </div>
            <div class="step-line"></div>
            <div class="step" id="step-indicator-3">
                <div class="step-icon">📄</div>
                <div class="step-label">Nhập nội dung</div>
            </div>
        </div>

        <form id="multiStepForm" enctype="multipart/form-data">

            <div class="form-step active" id="step-1">
                <h3>Bước 1: Thông tin cá nhân</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Họ và tên <span class="required">*</span></label>
                        <input type="text" name="fullname" placeholder="Nhập họ và tên" required>
                    </div>
                    <div class="form-group">
                        <label>Vị trí ứng tuyển <span class="required">*</span></label>
                        <input type="text" name="position" placeholder="Nhập vị trí ứng tuyển" required>
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh <span class="required">*</span></label>
                        <input type="date" name="birthday" required>
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <select name="gender">
                            <option value="">__ Chọn __</option>
                            <option value="0">Nữ</option>
                            <option value="1">Nam</option>
                            <option value="2">Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại <span class="required">*</span></label>
                        <input type="text" name="phone" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <label>Số CMND/CCCD</label>
                        <input type="text" name="identity_card" placeholder="Nhập số CMND/CCCD">
                    </div>
                    <div class="form-group">
                        <label>Ngày cấp</label>
                        <input type="date" name="identity_date">
                    </div>
                    <div class="form-group">
                        <label>Nơi cấp</label>
                        <input type="text" name="identity_place" placeholder="Nhập nơi cấp">
                    </div>
                    <div class="form-group">
                        <label>Quê quán</label>
                        <input type="text" name="home_town" placeholder="Nhập quê quán">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ hiện tại</label>
                        <input type="text" name="current_address" placeholder="Nơi ở hiện tại">
                    </div>
                    <div class="form-group">
                        <label>Mức lương mong muốn (VNĐ)</label>
                        <input type="number" name="expected_salary" placeholder="Nhập Mức lương mong muốn">
                    </div>
                    <div class="form-group">
                        <label>Ảnh đại diện</label>
                        <input type="file" name="avatar" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Ảnh đại diện (Link Facebook)</label>
                        <input type="url" name="facebook_url" placeholder="Nhập địa chỉ Facebook">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ Git</label>
                        <input type="url" name="git_url" placeholder="Nhập địa chỉ Git">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ Website</label>
                        <input type="url" name="website_url" placeholder="Nhập địa chỉ Website">
                    </div>
                </div>
                <div class="form-footer text-right">
                    <button type="button" class="btn btn-primary next-step">Tiếp theo →</button>
                </div>
            </div>

            <div class="form-step" id="step-2">
                <h3>Bước 2: Đăng ký danh mục của cá nhân</h3>
                <p class="step-desc">Chọn những mục bạn muốn thêm thông tin vào hồ sơ ứng viên của mình.</p>

                <div class="category-grid">
                    <div class="category-card" data-id="1" data-code="objective">
                        <div class="card-icon">🎯</div>
                        <div class="card-content">
                            <h4>Mục tiêu nghề nghiệp</h4>
                            <p>Định hướng sự nghiệp của bạn</p>
                        </div>
                    </div>
                    <div class="category-card" data-id="2" data-code="skill">
                        <div class="card-icon">⚡</div>
                        <div class="card-content">
                            <h4>Kỹ năng</h4>
                            <p>Các công nghệ, công cụ thuần thục</p>
                        </div>
                    </div>
                    <div class="category-card" data-id="3" data-code="experience">
                        <div class="card-icon">💼</div>
                        <div class="card-content">
                            <h4>Kinh nghiệm làm việc</h4>
                            <p>Lịch sử và các dự án từng tham gia</p>
                        </div>
                    </div>
                    <div class="category-card" data-id="4" data-code="education">
                        <div class="card-icon">🎓</div>
                        <div class="card-content">
                            <h4>Học vấn & Bằng cấp</h4>
                            <p>Trường học và các chứng chỉ đạt được</p>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="button" class="btn btn-secondary prev-step">Quay lại</button>
                    <button type="button" class="btn btn-primary next-step">Tiếp theo →</button>
                </div>
            </div>

            <div class="form-step" id="step-3">
                <h3>Bước 3: Nhập thông tin chi tiết</h3>
                <p class="step-desc">Vui lòng hoàn thiện nội dung cho các phần danh mục bạn vừa lựa chọn.</p>

                <div id="dynamic-content-area"></div>

                <div class="form-footer">
                    <button type="button" class="btn btn-secondary prev-step">Quay lại</button>
                    <button type="submit" class="btn btn-success">✓ Hoàn thành & Gửi</button>
                </div>
            </div>

        </form>
    </div>

    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>