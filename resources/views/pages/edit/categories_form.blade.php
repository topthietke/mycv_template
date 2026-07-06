<form id="categoryForm" class="step-form" data-user-id="{{ $candidate['id'] }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <h6 class="fw-bold">Quản lý danh mục và nội dung</h6>
        </div>
        <div class="col-lg-6 col-md-6 text-end">
            <a href="#" data-bs-toggle="modal" data-bs-target="#editCategoriesModal">
                <i class="fa fa-plus-circle mr-2 text-primary fa-lg"></i>
            </a>
        </div>
    </div>
    <div class="dot my-2"></div>

    {{-- ====================================== Tiêu đề + icon thêm danh muc ======================================= --}}

    <div class="row mt-2 form-editor">
        @foreach ($categories as $cat)
            <div class="mt-3" data-category-id="{{ $cat['id'] }}">
                <div class="edit_slanted_bar" style="border-bottom: 1px solid #000;">{{ $cat['name'] }}</div>
                <div class="edit_dot"></div> 
                @foreach ($cat['contents'] as $item)
                    <textarea class="form-control experiences" name="category_details[{{ $cat['id'] }}]" rows="4" data-category-id="{{ $cat['id'] }}" placeholder="Vui lòng nhập nội dung cho danh mục {{ $cat['name'] }}...">{!! $item['content'] !!}</textarea>                    
                @endforeach
            </div>
        @endforeach
        <div id="category_list" class="col-md-4 text-center m-0 mt-2"></div>
    </div>

    <div class="dot mb-3 mt-0 pt-0"></div>
    <div class="row mt-3">
        <div class="col-lg-12 d-flex justify-content-end">
            <x-button type="submit" class="btn btn-next" id="category_form_submit" data-step="3">
                Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
            </x-button>
        </div>
    </div>
</form>

<style>
    .form-editor { margin-bottom: 20px; }
    .cke_editable { font-family: Arial, sans-serif; font-size: 14px; }
    .cke_notification_warning,
    .cke_notifications_area {
        display: none !important;
    }
</style>
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script src="/assets/js/custom_ckeditor.js"></script>

