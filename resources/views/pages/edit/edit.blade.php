<?php 
    $title = config('data.edit.title', 'Chỉnh sửa thông tin');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    @include('head')
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">   
</head>

<body>
    <div class="container">
        <div class="form-container">
            {{-- ================================ Phần đầu trang =============================== --}}
                @include('pages.edit.top')            
            {{-- ================================ Bước 1: Thông tin cá nhân =============================== --}}
                @include('auth.forms.candidate_form')
            {{-- ================================ Bước 2: Chọn danh mục =============================== --}}
                @include('auth.forms.categories_form')
            {{-- ================================ Bước 3: Nhập nội dung cho các mục đã chọn =============================== --}}
                @include('auth.forms.content_form')
            {{-- ================================ Modal thêm danh mục mới =============================== --}}
                @include('auth.forms.modal_add_categories')
            {{-- ================================ Các scripts cần thiết =============================== --}}
        </div>
    </div>

    @include('script')
    <script type="module" src="/assets/js/register.js"></script>

</body>

</html>