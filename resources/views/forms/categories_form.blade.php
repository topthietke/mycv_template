<form id="categoryForm" class="step-form">
    @csrf
    <h4 class="mb-2 fw-bold">Bước 2: Đăng ký danh mục của cá nhân</h4>
    <p class="text-muted mb-4"><mark style="background-color: #ffebd1; padding: 2px 5px; border-radius: 4px;">Chọn những
            mục bạn muốn thêm thông tin vào hồ sơ ứng viên của mình.</mark></p>

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
                <input type="checkbox" name="categories[]" value="education" id="cat_education" class="hidden-checkbox">
                <div class="category-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="category-info">
                    <h6>Học vấn & Bằng cấp</h6>
                    <p>Trường học và các chứng chỉ đạt được</p>
                </div>
            </label>
        </div>
    </div>

    <hr class="mt-5 mb-4 text-muted">
    <div class="d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-back-step" onclick="goToStep(1)">Quay lại</button>
        <button type="button" class="btn btn-next" onclick="goToStep(3)">
            Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
        </button>
    </div>
</form>
