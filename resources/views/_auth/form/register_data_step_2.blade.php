<div class="form-step" data-step="2">
    <h5 class="mb-2 fw-bold">Bước 2: Đăng ký danh mục của cá nhân</h5>

    <div class="row">
        <div class="col-lg-11 col-md-11">
            <p class="text-muted small mb-4">Chọn những mục bạn muốn thêm thông tin vào hồ sơ ứng viên của mình.</p>
        </div>
        <div class="col-lg-1 col-md-1">
            <!-- Button trigger modal -->
            <a type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
                <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>
    <div class="row g-3" id="categoriesContainer">
        @if (!empty($categories))
            <div class="col-md-6">
                <input type="checkbox" class="btn-check" id="cat_objective" name="categories" value="objective" checked
                    autocomplete="off">
                <label class="w-100 d-block h-100" for="cat_objective">
                    <div class="category-card">
                        <div class="d-flex align-items-center">
                            <div class="fs-3 text-primary me-3"><i class="bi bi-bullseye"></i></div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Mục tiêu nghề nghiệp</h6>
                                <small class="text-muted">Định hướng sự nghiệp của bạn</small>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="col-md-6">
                <input type="checkbox" class="btn-check" id="cat_skills" name="categories" value="skills" checked
                    autocomplete="off">
                <label class="w-100 d-block h-100" for="cat_skills">
                    <div class="category-card">
                        <div class="d-flex align-items-center">
                            <div class="fs-3 text-primary me-3"><i class="bi bi-lightning-charge"></i></div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Kỹ năng</h6>
                                <small class="text-muted">Các công nghệ, công cụ thuần thục</small>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="col-md-6">
                <input type="checkbox" class="btn-check" id="cat_experience" name="categories" value="experience"
                    autocomplete="off">
                <label class="w-100 d-block h-100" for="cat_experience">
                    <div class="category-card">
                        <div class="d-flex align-items-center">
                            <div class="fs-3 text-primary me-3"><i class="bi bi-briefcase"></i></div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Kinh nghiệm làm việc</h6>
                                <small class="text-muted">Lịch sử và các dự án từng tham gia</small>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="col-md-6">
                <input type="checkbox" class="btn-check" id="cat_education" name="categories" value="education"
                    autocomplete="off">
                <label class="w-100 d-block h-100" for="cat_education">
                    <div class="category-card">
                        <div class="d-flex align-items-center">
                            <div class="fs-3 text-primary me-3"><i class="bi bi-mortarboard"></i></div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Học vấn & Bằng cấp</h6>
                                <small class="text-muted">Trường học và các chứng chỉ đạt được</small>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        @else
            <div class="col-12">
                <div class="alert alert-secondary fw-bold mb-0 text-center">
                    Không tìm thấy dữ liệu danh mục
                </div>
            </div>
        @endif


    </div>
    <div class="text-danger small mt-2 d-none" id="category-error">Vui lòng chọn ít nhất một danh mục để tiếp tục.</div>
</div>

{{-- Di chuyển modal ra ngoài để tránh lỗi hiển thị --}}
@include('auth.form.modal_add_categories')