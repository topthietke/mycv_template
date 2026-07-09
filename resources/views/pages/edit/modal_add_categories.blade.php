<!-- Modal -->
<?php 
    $page = config('data.page');
?>
<div class="modal fade" id="editCategoriesModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="categoryModalLabel">Thêm danh mục mới</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <form id="categories_form" method="POST">
                    @csrf
                    <div class="row form-editor">
                        <div class="col-lg-8 col-md-8">
                            <x-input name="categories_name" class="categories_name" type="text" placeholder="Nhập tên danh mục" />
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <x-select name="page{{ !empty($cat['id']) ? '_' . $cat['id']  : null }}" class="form-select pages border-0 border-bottom rounded-0" :options="$page" placeholder="__ Chọn trang __" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <textarea class="form-control experiences" name="category_details" rows="4"  placeholder="Vui lòng nhập nội dung...."></textarea>
                        </div>
                    </div>

                    {{-- <div id="category_fields">
                        <div class="category-field-group mb-3 d-flex align-items-end gap-2">
                            <div class="flex-grow-1">
                                <x-input name="categories_name[]" type="text" label="Tên danh mục"
                                    placeholder="Nhập tên danh mục" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 text-center">
                            <button type="button" class="btn btn-outline-secondary w-100" id="addCategoryFieldBtn">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div> --}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-primary" id="saveCategoryBtn">Thêm mới</button>
            </div>
        </div>
    </div>
</div>

<style>
    .col-lg-11 input {
        height: 40px !important;
    }       
    .categories_name, .pages {
        height: 40px;
    }
</style>

<script src="/assets/js/custom_ckeditor.js"></script>