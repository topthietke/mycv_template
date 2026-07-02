<?php 
    $gender = config('data.gender');
    $candidate_title = config('data.index.title') ?? 'Thông tin cá nhân';    
?>

<form id="candidateForm" class="step-form active cv-form" enctype="multipart/form-data" data-id="{{ $candidate['id'] }}" method="PUT">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <h5 class="mb-2 fw-bold">{{ $candidate_title }}</h5>
        </div>
    </div>

    <div class="dot my-4"></div>
    {{-- ================================ Bắt đầu phần ảnh đại diện ============================= --}}
    <div class="row">
        {{-- ================================ Cột trái: Ảnh đại diện =============================== --}}
        <div class="col-lg-3 avatar-col">
            <label class="d-block">Ảnh đại diện</label>
            <div class="avatar-upload-box" id="avatarPreviewBox">
                <img id="avatarPreviewImg" src="{{ $candidate['avatar'] ?? '' }}" alt="Avatar preview"
                    style="{{ !empty($candidate['avatar']) ? 'display:block;' : '' }}">
                <i class="fas fa-user avatar-placeholder-icon" id="avatarPlaceholderIcon"
                    style="{{ !empty($candidate['avatar']) ? 'display:none;' : '' }}"></i>
            </div>
            <div class="avatar-upload-wrapper">
                <x-file name="avatar" class="form-control" accept="image/*" id="avatarInput" />
            </div>
            <div class="avatar-hint">Ảnh tỉ lệ dọc. JPG, PNG. Tối đa 2MB.</div>
        </div>

        {{-- ================================ Cột phải: Các trường thông tin =============================== --}}
        <div class="col-lg-9">
            <div class="row g-1">
                {{-- Họ và tên / Vị trí ứng tuyển --}}
                <div class="col-md-6">
                    <x-input type="text" name="fullname" class="form-control" placeholder="Nhập họ và tên"
                        label="Họ và tên" :required="true"
                        value="{{ $candidate['fullname'] ?? '' }}" />
                </div>
                {{-- Giới tính / Tình trạng hôn nhân --}}
                <div class="col-md-6">
                    <x-select name="gender" class="form-select" label="Giới tính" :options="$gender"
                            :required="true" :selected="$candidate['gender'] ?? ''" />
                </div>
                {{-- Ngày sinh / Số điện thoại --}}
                <div class="col-md-6">
                    <x-input type="date" name="birthday" class="form-control" label="Ngày sinh" :required="true"
                        value="{{ $candidate['birthday'] ?? '' }}" />
                </div>
                <div class="col-md-6">
                    <x-input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại"
                        label="Số điện thoại" :required="true" value="{{ $candidate['phone'] ?? '' }}" />
                </div>

                {{-- Email / Địa chỉ --}}
                <div class="col-md-6">
                    <x-input type="email" name="email" class="form-control" placeholder="Nhập email" label="Email"
                        :required="true" value="{{ $candidate['email'] ?? '' }}" />
                </div>
                <div class="col-md-6">
                    <x-input type="text" name="current_address" class="form-control" placeholder="Nhập nơi ở hiện tại"
                        label="Địa chỉ" :required="false"
                        value="{{ $candidate['current_address'] ?? '' }}" />
                </div>
                
                <div class="col-md-6">
                    <x-input type="text" name="position" class="form-control" placeholder="Nhập vị trí ứng tuyển"
                    label="Vị trí / Chức danh" :required="true"
                    value="{{ $candidate['position'] ?? '' }}" />
                </div>
                <div class="col-md-6">
                    <x-input type="number" name="expected_salary" class="form-control" placeholder="Nhập mức lương mong muốn"
                        label="Mức lương mong muốn (VNĐ)" :required="false"
                        value="{{ $candidate['expected_salary'] ?? '' }}" />
                </div>
                
            </div>
        </div>
    </div>
    {{-- ================================ Kết thúc ảnh đại diện ============================= --}}
    <div class="dot my-4"></div>
    {{-- ================================ Các trường còn lại của form gốc (giữ style mới) ============================= --}}
    <div class="row g-1">
        <div class="col-md-6">
            <x-input type="text" name="identity_card" class="form-control" placeholder="Nhập số CMND/CCCD"
                label="Số CMND/CCCD" value="{{ $candidate['identity_card'] ?? '' }}"
                :required="false" />
        </div>
        <div class="col-md-6">
            <x-input type="date" name="identity_date" class="form-control" label="Ngày cấp" :required="false"
                value="{{ $candidate['identity_date'] ?? '' }}" />
        </div>
    </div>

    <div class="row g-1">
        <div class="col-md-6">
            <x-input type="text" name="identity_place" class="form-control" placeholder="Nhập nơi cấp" label="Nơi cấp"
                :required="false" value="{{ $candidate['identity_place'] ?? '' }}" />
        </div>
        <div class="col-md-6">
            <x-input type="text" name="home_town" class="form-control" placeholder="Nhập quê quán" label="Quê quán"
                :required="false" value="{{ $candidate['home_town'] ?? '' }}" />
        </div>
    </div>

    <div class="row g-1">
        <div class="col-md-6">
            <x-input type="text" name="website_url" class="form-control" placeholder="Nhập địa chỉ website"
                label="Địa chỉ Website" value="{{ $candidate['website_url'] ?? '' }}" />
        </div>
        <div class="col-md-6">
            <x-input type="text" name="facebook_url" class="form-control" placeholder="Nhập địa chỉ facebook"
                label="Địa chỉ Facebook" value="{{ $candidate['facebook_url'] ?? '' }}" />
        </div>
    </div>

    <div class="row g-1">
        {{-- GitHub/Website / LinkedIn --}}
        <div class="col-md-6">
            <x-input type="text" name="git_url" class="form-control" placeholder="https://github.com/username"
            label="Địa chỉ Git" :required="false" value="{{ $candidate['git_url'] ?? '' }}" />
        </div>
        <div class="col-md-6">
            <x-input type="text" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/..."
            label="LinkedIn" :required="false" value="{{ $candidate['linkedin_url'] ?? '' }}" />
        </div>
    </div>

    {{-- ================================ Nút submit ============================================= --}}
    <div class="dot my-3"></div>
    <div class="d-flex justify-content-end my-3">
        <x-button type="submit" class="btn btn-next">  
            <i class="fas fa-save"></i>
            Cập nhật
        </x-button>
    </div>
</form>

<script>
    
</script>