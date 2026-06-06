<form id="detailsForm" class="step-form">
    <div class="mb-4">
        <h4 class="fw-bold mb-2">Bước 3: Nhập thông tin chi tiết</h4>
        <p class="text-muted" style="font-size: 15px;">Vui lòng hoàn thiện nội dung cho các phần danh mục bạn vừa lựa
            chọn.</p>
    </div>

    <div class="form-section">
        <div class="section-title">
            <i class="fas fa-bullseye"></i> Mục tiêu nghề nghiệp
        </div>
        <div class="mb-2">
            <label class="form-label">Chi tiết mục tiêu ngắn hạn & dài hạn <span class="text-asterisk">*</span></label>
            <textarea class="form-control" rows="4"
                placeholder="VD: Trở thành chuyên gia phát triển hệ thống lớn, tối ưu hóa database, nâng cấp cấu trúc mã nguồn Laravel tinh gọn..."
                required></textarea>
        </div>
    </div>

    <div class="form-section">
        <div class="section-title">
            <i class="fas fa-bolt"></i> Kỹ năng chuyên môn
        </div>
        <div class="mb-2">
            <label class="form-label">Các kỹ năng cốt lõi (Cách nhau bằng dấu phẩy) <span
                    class="text-asterisk">*</span></label>
            <input type="text" class="form-control" placeholder="VD: PHP, Laravel, VueJS, OOP, Git, DBeaver, Postman"
                required>
        </div>
    </div>

    <hr class="mt-5 mb-4 text-muted">
    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-back" onclick="goToStep(2)">Quay lại</button>
        <button type="submit" class="btn btn-submit">
            <i class="fas fa-check-circle me-1"></i> Hoàn thành & Gửi
        </button>
    </div>
</form>
