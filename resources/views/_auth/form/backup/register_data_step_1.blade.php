<div class="form-step active" data-step="1">
    <h4 class="mb-4 fw-bold">Bước 1: Thông tin cá nhân</h4>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-medium">Họ và tên <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" required placeholder="VD: Trần Ngọc Tú">            
            <div class="invalid-feedback">Vui lòng nhập họ và tên.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-medium">Vị trí ứng tuyển <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="jobs_title" required placeholder="VD: Lập trình viên PHP Laravel">
            <div class="invalid-feedback">Vui lòng nhập vị trí ứng tuyển.</div>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-medium">Ngày sinh</label>
            <input type="date" class="form-control" name="day_of_birth">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-medium">Giới tính</label>
            <select class="form-select" name="gender">
                <option value="" selected disabled>-- Chọn giới tính --</option>
                <option value="1">Nam</option>
                <option value="0">Nữ</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-medium">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" required placeholder="name@example.com">
            <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-medium">Số điện thoại <span class="text-danger">*</span></label>
            <input type="tel" class="form-control" name="phone" required placeholder="0123456789">
            <div class="invalid-feedback">Vui lòng nhập số điện thoại.</div>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-medium">Số CMND/CCCD</label>
            <input type="text" class="form-control" name="identity_card" placeholder="Nhập số CCCD">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-medium">Ngày cấp</label>
            <input type="date" class="form-control" name="identity_card_date">
        </div>
        <div class="col-md-12">
            <label class="form-label fw-medium">Nơi cấp</label>
            <input type="text" class="form-control" name="identity_card_place" placeholder="VD: Cục CS QLHC về TTXH">
        </div>

        <div class="col-md-6">
            <label class="form-label fw-medium">Quê quán</label>
            <input type="text" class="form-control" name="home_town" placeholder="Tỉnh / Thành phố">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-medium">Địa chỉ hiện tại</label>
            <input type="text" class="form-control" name="address" placeholder="Nơi ở hiện tại">
        </div>

        <div class="col-md-6">
            <label class="form-label fw-medium">Mức lương mong muốn (VNĐ)</label>
            <input type="number" class="form-control" name="expected_salary" placeholder="VD: 15000000">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-medium">Ảnh đại diện (Avatar)</label>
            <input type="file" class="form-control" name="avatar" accept="image/*">
        </div>

        <div class="col-md-4">
            <label class="form-label fw-medium">Facebook</label>
            <input type="url" class="form-control" name="social_address" placeholder="https://facebook.com/...">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-medium">Github/Gitlab</label>
            <input type="url" class="form-control" name="git_address" placeholder="https://github.com/...">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-medium">Website</label>
            <input type="url" class="form-control" name="website" placeholder="https://...">
        </div>
    </div>
</div>
