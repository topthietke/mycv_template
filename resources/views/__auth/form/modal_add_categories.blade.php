<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Thêm danh mục mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <form id="categories_form" method="POST">
                    @csrf                    
                    <div id="category_fields">
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
                                <i class="bi bi-plus bi-lg"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="saveCategoryBtn" onclick="add_new_categories()">Lưu lại</button>
            </div>
        </div>
    </div>
</div>
