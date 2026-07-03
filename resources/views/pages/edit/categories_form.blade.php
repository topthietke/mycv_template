
<form id="categoryForm" class="step-form" data-user-id="{{ $candidate['id'] }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <h5 class="fw-bold">Bước 2: Đăng ký danh mục của cá nhân</h5>
        </div>
        <div class="col-lg-6 col-md-6 text-end">
            <a href="#" data-bs-toggle="modal" data-bs-target="#editCategoriesModal">
                <i class="fa fa-plus-circle mr-2 text-primary fa-lg"></i>
            </a>
        </div>
    </div>
    <div class="dot"></div>

    {{-- ====================================== Tiêu đề + icon thêm danh muc =======================================
    --}}

    <div class="row mt-4">
        @foreach ($categories as $cat)
            <div class="col-md-4 mb-3 category-item" data-id="{{ $cat['id'] }}">
                <label class="category-card" for="cat_{{ $cat['id'] }}">
                    <input type="checkbox" name="categories[]" value="{{ $cat['id'] }}" id="cat_{{ $cat['id'] }}"
                        class="hidden-checkbox">
                    <div class="category-icon">
                        <i class="fas fa-bullseye text-primary"></i>
                    </div>
                    <div class="category-info text-start">
                        <span>{{ $cat['name'] }}</span>
                    </div>
                </label>
                <i class="fa fa-times fa-sm text-danger remove-category-icon" title="click để xoá danh mục tương ứng"
                    id="rm_icon_{{ $cat['id'] }}" data-id="{{ $cat['id'] }}"></i>
            </div>
        @endforeach
        <div id="category_list" class="col-md-4 text-center m-0 mt-2"></div>
    </div>    

    <div class="dot mb-3 mt-0 pt-0"></div>
    <div class="row mt-3">
        <div class="col-lg-12 d-flex justify-content-end">
            <x-button type="submit" class="btn btn-next" id="category_form_submit" data-step="3">
                Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
            </x-button>
        </div>
    </div>
</form>

<style>

</style>

