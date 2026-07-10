<!-- Modal xác nhận xoá -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Bạn có muốn xoá thông tin này không?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ bỏ</button>
                <button type="button" class="btn btn-danger remove-category-icon">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lấy element của modal
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');

        // Lắng nghe sự kiện trước khi modal hiện lên
        if (confirmDeleteModal) {
            confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                // event.relatedTarget chính là phần tử (thẻ <i>) đã kích hoạt modal
                const button = event.relatedTarget;

                // Lấy giá trị từ thuộc tính data-id
                const categoryId = button.getAttribute('data-id');
                
                // Tìm thẻ input ẩn trong modal và gán giá trị ID vào đó
                const inputCategoryId = confirmDeleteModal.querySelector('#modal_category_id');
                if (inputCategoryId) {
                    inputCategoryId.value = categoryId;
                }

                // (Tùy chọn) Nếu bạn muốn thay đổi trực tiếp action URL của form thay vì dùng input ẩn
                // const deleteForm = confirmDeleteModal.querySelector('#deleteForm');
                // deleteForm.action = '/categories/delete/' + categoryId;
            });
        }
    });
</script>