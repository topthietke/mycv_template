<?php 
    $gender = config('data.gender');
?>
<div class="form-step active" data-step="1">
    <h5 class="mb-4 fw-bold">Bước 1: Thông tin cá nhân</h5>
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
        <div class="col-md-6">
            <x-input name="identity_card_place" type="text" label="Nơi cấp" placeholder="Nhập nơi cấp" :required="false"  />
        </div>
        <div class="col-md-6">
            <x-input name="home_town" type="text" label="Quê quán" placeholder="Nhập quê quán" :required="false"  />
        </div>        
        <div class="col-md-6">
            <x-input name="address" type="text" label="Địa chỉ hiện tại" placeholder="Nơi ở hiện tại" :required="false"  />
        </div>
        <div class="col-md-6">
            <x-input name="expected_salary" type="number" label="Mức lương mong muốn (VNĐ)" placeholder="Nhập Mức lương mong muốn" :required="false"  />
        </div>
        <div class="col-md-6">
            <x-input name="avatar" type="file" label="Ảnh đại diện" placeholder="Nhập Ảnh đại diện" :required="false"  />
        </div>
        <div class="col-md-6">
            <x-input name="avatar" type="text" label="Ảnh đại diện" placeholder="Nhập địa chỉ Facebook" :required="false"  />
        </div>
        <div class="col-md-6">
            <x-input name="git_address" type="text" label="Địa chỉ Git" placeholder="Nhập địa chỉ Git" :required="false"  />
        </div>
        <div class="col-md-6">            
            <x-input name="website" type="text" label="Địa chỉ Website" placeholder="Nhập địa chỉ Website" :required="false"  />
        </div>
    </div>
</div>
