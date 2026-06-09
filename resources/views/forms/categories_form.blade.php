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
    {{-- ====================================== Tiêu đề + icon thêm danh muc ======================================= --}}
    
    <div id="category_list text-center" style="padding:10px;">
        Không có dữ liệu
    </div>
            
    <div class="d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-back-step" onclick="goToStep(1)">Quay lại</button>
        <button type="button" class="btn btn-next" onclick="goToStep(3)">
            Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
        </button>
    </div>
</form>