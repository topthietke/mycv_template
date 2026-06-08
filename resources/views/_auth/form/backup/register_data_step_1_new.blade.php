<?php 
    $gender = config('data.gender');
?>
<div class="form-step active" data-step="1">
    <h4 class="mb-4 fw-bold">Bước 1: Thông tin cá nhân</h4>
    <div class="row g-3">
        <div class="col-md-6">
            <x-input name="name" type="text" label="Họ và tên" placeholder="Nhập họ và tên" :required="true" class="form-control" error="Vui lòng nhập họ và tên."/>
        </div>
        <div class="col-md-6">
            <x-input name="jobs_title" type="text" label="Vị trí ứng tuyển" placeholder="Nhập vị trí ứng tuyển" :required="true" class="form-control" error="Vui lòng nhập vị trí ứng tuyển."/>
        </div>

        <div class="col-md-6">
            <x-input name="day_of_birth" type="date" label="Ngày sinh" placeholder="Ngày sinh" :required="true" class="form-control" error="Vui lòng nhập ngày sinh." />
        </div>
        <div class="col-md-6">
            <x-select name="gender" label="Giới tính" :options="$gender"/>
        </div>

        <div class="col-md-6">
            <x-input name="email" type="email" label="Email" placeholder="Nhập email" :required="true" error="Vui lòng nhập email hợp lệ." />
        </div>
        <div class="col-md-6">
            <x-input name="phone" type="text" label="Số điện thoại" placeholder="Nhập số điện thoại" :required="true" error="Vui lòng nhập số điện thoại." />            
        </div>

        <div class="col-md-6">
            <x-input name="identity_card" type="text" label="Số CMND/CCCD" placeholder="Nhập số CMND/CCCD" :required="false"  />
        </div>
        <div class="col-md-6">
            <x-input name="identity_card_date" type="date" label="Ngày cấp" placeholder="Nhập ngày cấp" :required="false"  />
        </div>
        <div class="col-md-12">
            <x-input name="identity_card_place" type="text" label="Nơi cấp" placeholder="Nhập nơi cấp" :required="false"  />
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
