<form id="detailsForm" class="step-form">
    <div class="">
        <h5 class="fw-bold mb-3">Bước 3: Nhập thông tin chi tiết</h5>
        {{-- <p class="text-muted" style="font-size: 15px;">Vui lòng hoàn thiện nội dung cho các phần danh mục bạn vừa lựa chọn.</p>         --}}
    </div>

    <div id="dynamic-categories-container"></div>

    <hr>
    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-back" onclick="goToStep(2)">Quay lại</button>
        <button type="submit" class="btn btn-submit btn-primary">
            <i class="fas fa-check-circle me-1"></i> Kết thúc
        </button>
    </div>
</form>


<script>
    ClassicEditor
        .create(document.querySelector('.experiences'), {
            // Bạn có thể tùy chỉnh cấu hình tại đây (Xem mục 3)
            placeholder: 'Nhập nội dung của bạn ở đây...'
        })
        .then(editor => {
            console.log('CKEditor 5 đã sẵn sàng!', editor);
        })
        .catch(error => {
            console.error('Có lỗi xảy ra khi khởi tạo editor:', error);
        });
</script>