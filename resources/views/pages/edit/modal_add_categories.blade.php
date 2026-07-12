<?php 
    $page = config('data.page');
?>
<div class="modal fade" id="editCategoriesModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="categoryModalLabel">Thêm danh mục mới</h6>
                <x-button class="btn-close" data-bs-dismiss="modal" aria-label="Đóng" />
            </div>
            <div class="modal-body">
                {{-- {{ $candidate['id'] }} --}}
                <form id="categories_form" method="POST" data-users-id="{{ Auth::user()->id ?? null }}">
                    @csrf
                    <div class="row form-editor">
                        <div class="col-lg-8 col-md-8">
                            <x-input name="categories_name" class="categories_name" type="text"
                                placeholder="Nhập tên danh mục" />
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <x-select name="page{{ !empty($cat['id']) ? '_' . $cat['id'] : null }}"
                                class="form-select pages border-0 border-bottom rounded-0" :options="$page"
                                placeholder="__ Chọn trang __" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <x-textarea id="modal_category_details" name="category_details" class="experiences" rows="4"
                                placeholder="Vui lòng nhập nội dung...." />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <x-button class="btn btn-secondary me-2" data-bs-dismiss="modal">Hủy bỏ</x-button>
                            <x-button type="submit" id="saveCategoriesContentsBtn" class="btn btn-primary">Thêm mới</x-button>
                        </div>
                    </div>

                </form>
            </div>            
        </div>
    </div>
</div>

<style>
    .col-lg-11 input { height: 40px !important; }
    .categories_name,.pages { height: 40px; }    
</style>
<script src="/assets/js/custom_ckeditor.js"></script>
