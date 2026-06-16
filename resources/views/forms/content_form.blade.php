<form id="detailsForm" class="step-form">
    <div class="mb-4">
        <h4 class="fw-bold mb-2">Bước 3: Nhập thông tin chi tiết</h4>
        <p class="text-muted" style="font-size: 15px;">Vui lòng hoàn thiện nội dung cho các phần danh mục bạn vừa lựa
            chọn.</p>
    </div>

    <div id="dynamic-categories-container"></div>

    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-back" onclick="goToStep(2)">Quay lại</button>
        <button type="submit" class="btn btn-submit btn-primary">
            <i class="fas fa-check-circle me-1"></i> Kết thúc
        </button>
    </div>
</form>
<script>
    tinymce.init({
        selector: 'textarea.experiences', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'advlist autolink lists link image table code fullscreen',
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code fullscreen',
        height: 400,
    });
</script>