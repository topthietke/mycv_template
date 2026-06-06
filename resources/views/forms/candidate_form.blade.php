<form id="candidateForm" class="step-form active" enctype="multipart/form-data">
    @csrf
    <h4 class="mb-4 fw-bold">Bước 1: Thông tin cá nhân</h4>
    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label">Họ và tên <span class="text-asterisk">*</span></label>
            <x-input type="text" name="fullname" class="form-control" placeholder="Nhập họ và tên" />
            <div class="error-message">Vui lòng nhập họ và tên</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Vị trí ứng tuyển <span class="text-asterisk">*</span></label>
            <x-input type="text" name="position" class="form-control" placeholder="Nhập vị trí ứng tuyển" />
            <div class="error-message">Vui lòng nhập vị trí ứng tuyển</div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ngày sinh <span class="text-asterisk">*</span></label>
            <x-input type="date" name="birthday" class="form-control" />
            <div class="error-message">Vui lòng chọn ngày sinh</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Giới tính <span class="text-asterisk">*</span></label>
            <x-select name="gender" class="form-select">
                <option value="">__ Chọn __</option>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </x-select>
            <div class="error-message">Vui lòng chọn giới tính</div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Email <span class="text-asterisk">*</span></label>
            <x-input type="email" name="email" class="form-control" placeholder="Nhập email" />
            <div class="error-message">Vui lòng nhập email hợp lệ</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Số điện thoại <span class="text-asterisk">*</span></label>
            <x-input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" />
            <div class="error-message">Vui lòng nhập số điện thoại</div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Số CMND/CCCD</label>
            <x-input type="text" name="identity_card" class="form-control" placeholder="Nhập số CMND/CCCD" />
        </div>
        <div class="col-md-6">
            <label class="form-label">Ngày cấp</label>
            <x-input type="date" name="identity_date" class="form-control" />
        </div>

        <div class="col-md-6">
            <label class="form-label">Nơi cấp</label>
            <x-input type="text" name="identity_place" class="form-control" placeholder="Nhập nơi cấp" />
        </div>
        <div class="col-md-6">
            <label class="form-label">Quê quán</label>
            <x-input type="text" name="home_town" class="form-control" placeholder="Nhập quê quán" />
        </div>

        <div class="col-md-6">
            <label class="form-label">Địa chỉ hiện tại</label>
            <x-input type="text" name="current_address" class="form-control" placeholder="Nơi ở hiện tại" />
        </div>
        <div class="col-md-6">
            <label class="form-label">Mức lương mong muốn (VNĐ)</label>
            <x-input type="number" name="expected_salary" class="form-control"
                placeholder="Nhập Mức lương mong muốn" />
        </div>

        <div class="col-md-6">
            <label class="form-label">Ảnh đại diện (Avatar)</label>
            <x-file name="avatar" class="form-control" accept="image/*" />
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-4">
            <label class="form-label">Facebook</label>
            <x-input type="text" name="facebook_url" class="form-control"
                placeholder="https://www.facebook.com/..." />
        </div>
        <div class="col-md-4">
            <label class="form-label">Github/Gitlab</label>
            <x-input type="text" name="git_url" class="form-control" placeholder="https://github.com/..." />
        </div>
        <div class="col-md-4">
            <label class="form-label">Website</label>
            <x-input type="text" name="website_url" class="form-control" placeholder="https://..." />
        </div>

        <div class="col-12">
            <label class="form-label">Giới thiệu ngắn gọn bản thân</label>
            <textarea name="short_intro" class="form-control" rows="3" placeholder="Nhập vài dòng giới thiệu về bạn..."></textarea>
        </div>
    </div>

    <hr class="mt-5 mb-4 text-muted">
    <div class="d-flex justify-content-end">
        <x-button type="button" class="btn btn-next" onclick="goToStep(2)">
            Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
        </x-button>
    </div>
</form>
