<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="categoryModalLabel">Thêm danh mục mới</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <form id="categories_form" method="POST">
                    @csrf
                    <div id="category_fields">
                        <div class="category-field-group mb-3 d-flex align-items-end gap-2">
                            <div class="flex-grow-1">
                                <x-input name="categories_name[]" type="text" label="Tên danh mục" placeholder="Nhập tên danh mục" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 text-center">
                            <button type="button" class="btn btn-outline-secondary w-100" id="addCategoryFieldBtn">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-primary" id="saveCategoryBtn">Thêm mới</button>
            </div>
        </div>
    </div>
</div>
