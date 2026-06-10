<form id="categoryForm" class="step-form">
    @csrf


    <div class="row">
        <div class="col-lg-6 col-md-6">
            <h5 class="fw-bold">Bước 2: Đăng ký danh mục của cá nhân</h5>
        </div>
        <div class="col-lg-6 col-md-6 text-end">
            <a href="#" data-bs-toggle="modal" data-bs-target="#categoryModal">
                <i class="fa fa-plus-circle mr-2 text-primary fa-lg"></i>
            </a>
        </div>
    </div>

    {{-- ====================================== Tiêu đề + icon thêm danh muc =======================================
    --}}

    <div id="category">

    </div>

    <div class="row mt-2">
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
                <div class="category-icon"><i class="fas fa-bullseye"></i></div>
                <div class="category-info">
                    <h6>Kỹ năng</h6>
                    <p>Các công nghệ, công cụ thuần thục</p>
                </div>
            </label>
        </div>
    </div>


    {{-- @if (!empty($categories))
    <div class="row">
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
    @else
    <div class="row g-4">
        <div class="col-md-12 col-lg-12 text-center pt-5 ">
            <p class="text-muted">Không có danh mục nào để chọn.</p>
        </div>
    </div>
    @endif --}}

    <div class="row my-3">
        <div class="col-lg-12 col-md-12 text-center">
            <button type="button" class="btn btn-outline-secondary w-100" id="category_form_add">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>


    <div class="d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-back-step" onclick="goToStep(1)">Quay lại</button>
        <button type="button" class="btn btn-next" onclick="goToStep(3)">
            Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
        </button>
    </div>
</form>