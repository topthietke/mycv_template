<?php 
    $gender = config('data.gender');
    $candidate_title = config('data.index.title') ?? 'Thông tin cá nhân';    
?>
<form id="candidateForm" class="step-form active" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <h5 class="mb-2 fw-bold">{{ $candidate_title }}</h5>
        </div>
    </div>
    
    <div class="dot my-4"></div>
    {{-- ================================ Nhập Họ và tên, Ngày sinh =============================== --}}
    <div class="row g-4">
        {{-- Họ và tên --}}
        <div class="col-md-6">
            <x-input type="text" name="fullname" class="form-control" placeholder="Nhập họ và tên" label="Họ và tên" :required="true" value="{{ old('fullname', $candidate['fullname'] ?? '') }}"/>            
        </div>
        {{-- Ngày sinh --}}
        <div class="col-md-6">
            <x-input type="date" name="birthday" class="form-control" label="Ngày sinh" :required="true" value="{{ old('birthday', $candidate['birthday'] ?? '') }}"/>
        </div>
    </div>
    {{-- ================================ Nhập Giới thiệu và Email =============================== --}}
    <div class="row g-4">
        {{-- Giới tính --}}
        <div class="col-md-6">
            <x-select name="gender" class="form-select" label="Giới tính" :options="$gender" :required="true" :selected="old('gender', $candidate['gender'] ?? '')" />
        </div>
        {{-- Email --}}
        <div class="col-md-6">
            <x-input type="email" name="email" class="form-control" placeholder="Nhập email" label="Email" :required="true" value="{{ old('email', $candidate['email'] ?? '') }}"/>
        </div>
    </div>
    {{-- ================================ Nhập số điện thoại và vị trí ứng tuyển =============================== --}}
    <div class="row g-4">
        <div class="col-md-6">
            <x-input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" label="Số điện thoại" :required="true" value="{{ old('phone', $candidate['phone'] ?? '') }}"/>
        </div>

        <div class="col-md-6">
            <x-input type="text" name="position" class="form-control" placeholder="Nhập vị trí ứng tuyển" label="Vị trí ứng tuyển" :required="true" value="{{ old('position', $candidate['position'] ?? '') }}" />
        </div>
    </div>
    {{-- ================================ Nhập Nhập số CMND/CCCD và ngày cấp =============================== --}}
    <div class="row g-4">
        <div class="col-md-6">
            <x-input type="text" name="identity_card" class="form-control" placeholder="Nhập số CMND/CCCD" label="Số CMND/CCCD" value="{{ old('identity_card', $candidate['identity_card'] ?? '') }}" :required="false"/>
        </div>
        <div class="col-md-6">
            <x-input type="date" name="identity_date" class="form-control" label="Ngày cấp" :required="false" value="{{ old('identity_date', $candidate['identity_date'] ?? '') }}" />
        </div>
    </div>
    {{-- ================================ Nhập nơi cấp, quê quán ============================================= --}}
    <div class="row g-4">
        <div class="col-md-6">
            <x-input type="text" name="identity_place" class="form-control" placeholder="Nhập nơi cấp" label="Nơi cấp"
                :required="false" value="{{ old('identity_place', $candidate['identity_place'] ?? '') }}" />
        </div>
        <div class="col-md-6">
            <x-input type="text" name="home_town" class="form-control" placeholder="Nhập quê quán" label="Quê quán"
                :required="false" value="{{ old('home_town', $candidate['home_town'] ?? '') }}" />
        </div>
    </div>
    {{-- ============================= Nơi ở hiện tại và Nhập mức lương mong muốn ============================= --}}
    <div class="row g-4">
        <div class="col-md-6">
            <x-input type="text" name="current_address" class="form-control" placeholder="Nhập Nơi ở hiện tại"
                label="Nơi ở hiện tại" :required="false" value="{{ old('current_address', $candidate['current_address'] ?? '') }}" />
        </div>
        <div class="col-md-6">
            <x-input type="number" name="expected_salary" class="form-control" placeholder="Nhập Mức lương mong muốn"
                label="Mức lương mong muốn (VNĐ)" :required="false" value="{{ old('expected_salary', $candidate['expected_salary'] ?? '') }}" />
        </div>
    </div>
    {{-- ================================ Ảnh đại diện và địa chỉ facebook =============================================--}}
    <div class="row g-4">
        <div class="col-md-6">
            <x-file name="avatar" class="form-control" accept="image/*" label="Ảnh đại diện (Avatar)" />
        </div>
        <div class="col-md-6">
            <x-input type="text" name="facebook_url" class="form-control" placeholder="Nhập địa chỉ facebook" label="Địa chỉ Facebook" value="{{ old('facebook_url', $candidate['facebook_url'] ?? '') }}" />
        </div>
    </div>
    {{-- ================================ Ảnh đại diện và địa chỉ facebook =============================================--}}
    <div class="row g-4">
        <div class="col-md-6">
            <x-input type="text" name="git_url" class="form-control" placeholder="Nhập địa chỉ GitHub/ GitLab"    label="Địa chỉ GitHub/ GitLab" value="{{ old('git_url', $candidate['git_url'] ?? '') }}" />
        </div>
        <div class="col-md-6">
            <x-input type="text" name="website_url" class="form-control" placeholder="Nhập địa chỉ website" label="Địa chỉ Website" value="{{ old('website_url', $candidate['website_url'] ?? '') }}" />
        </div>
    </div>
    {{-- ================================ Nút submit ============================================= --}}
    <div class="dot my-3"></div>
    <div class="d-flex justify-content-end my-3">
        <x-button type="submit" class="btn btn-next"> Tiếp theo <i class="fas fa-arrow-right ms-2"></i></x-button>
    </div>
</form>

