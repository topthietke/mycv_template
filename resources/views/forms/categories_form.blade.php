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
    <div class="dot"></div>

    {{-- ====================================== Tiêu đề + icon thêm danh muc =======================================
    --}}

    <div id="category_list" class="text-center my-3 py-2">
        <h6>Không có danh mục nào! Vui lòng thêm mới danh mục</h6>
    </div>
    <div class="dot my-3"></div>
    <div class="row mt-3">
        <div class="col-lg-12 d-flex justify-content-end">
            {{-- <button type="button" class="btn btn-primary" id="category_form_submit" data-step="3"> Tiếp theo <i
                    class="fas fa-arrow-right ms-2"></i>
            </button> --}}
            {{-- <button type="button" class="btn btn-back-step" id="category_form_back" data-step="1">Quay lại</button> --}}
            <x-button type="submit" class="btn btn-next" id="category_form_submit" data-step="3"> 
                Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
            </x-button>
        </div>
    </div>
</form>