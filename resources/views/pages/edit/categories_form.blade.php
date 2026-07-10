<?php 
    $page = config('data.page');
$title = config('data.edit.content_title') ?? 'Thông tin cá nhân';    
?>

<form id="categoryForm" class="step-form" data-user-id="{{ $candidate['id'] }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <h6 class="fw-bold">{{ $title }}</h6>
        </div>
        <div class="col-lg-6 col-md-6 text-end">
            <a href="#" data-bs-toggle="modal" data-bs-target="#editCategoriesModal">
                <i class="fa fa-plus-circle mr-2 text-primary fa-lg"></i>
            </a>
        </div>
    </div>
    <div class="dot my-2"></div>

    {{-- ====================================== Tiêu đề + icon thêm danh muc =======================================
    --}}

    <div class="row mt-2 form-editor">
        {{-- data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" --}}
        @foreach ($categories as $cat)
            <div class="mt-3" data-category-id="{{ $cat['id'] }}">
                <div class="row">
                    <div class="col-lg-11 col-md-11">
                        <div class="edit_slanted_bar" style="border-bottom: 1px solid #000;">
                            <i class="fa fa-times fa-sm text-danger " data-id="{{ $cat['id'] }}"
                                onclick="showModalDelete({{ $cat['id'] }})"></i>
                            {{ $cat['name'] }}
                        </div>
                        <div class="edit_dot"></div>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <x-select name="page_{{ $cat['id'] }}" class="form-select pages border-0 border-bottom rounded-0"
                            :options="$page" :selected="$cat->pages ?? null " placeholder="__ Chọn __" />
                    </div>
                </div>

                @foreach ($cat['contents'] as $item)
                    <textarea class="form-control experiences" name="category_details[{{ $cat['id'] }}]" rows="4"
                        data-category-id="{{ $cat['id'] }}"
                        placeholder="Vui lòng nhập nội dung cho danh mục {{ $cat['name'] }}...">{!! $item['content'] !!}</textarea>
                @endforeach
            </div>
        @endforeach

        <div id="category_list" class="col-md-4 text-center m-0 mt-2"></div>
    </div>

    <div class="dot mb-3 mt-0 pt-0"></div>
    <div class="row mt-3">
        <div class="col-lg-12 d-flex justify-content-end">
            <x-button type="submit" class="btn btn-next" id="category_form_submit" data-step="3">
                <i class="fas fa-save ms-2"></i>
                Lưu lại
            </x-button>
        </div>
    </div>
</form>

<script src="/assets/js/custom_ckeditor.js"></script>
<script>
    function showModalDelete(cat_id) {
        const modalElement = document.getElementById('confirmDeleteModal');
        const deleteModal = new bootstrap.Modal(modalElement);

        // Lắng nghe sự kiện click trên tất cả các nút xóa
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                // Lấy ID
                const itemId = this.getAttribute('data-id');
                console.log('ID cần xóa:', itemId);

                // Xử lý gán ID vào form trong modal ở đây...

                // Gọi hàm show modal
                deleteModal.show();
            });
        });
    }


</script>