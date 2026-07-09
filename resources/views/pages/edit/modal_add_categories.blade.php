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

            {{-- id="saveCategoriesContentsBtn" --}}
        </div>
    </div>
</div>

<style>
    .col-lg-11 input {
        height: 40px !important;
    }

    .categories_name,
    .pages {
        height: 40px;
    }
</style>
<script src="/assets/js/custom_ckeditor.js"></script>
<script>    
    // Khởi tạo CKEditor cho modal khi nó được hiển thị
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('editCategoriesModal');
        if (modal) {
            modal.addEventListener('shown.bs.modal', function () {
                // `initializeCKEditor` is from custom_ckeditor.js
                if (typeof initializeCKEditor === 'function' && !CKEDITOR.instances.modal_category_details) {
                    initializeCKEditor('modal_category_details');
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', () => {        
        const form = document.getElementById('categories_form');
        if (!form) return;
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const saveBtn = form.querySelector('#saveCategoriesContentsBtn');
            await handleSaveCategory(form, saveBtn);
        });
    });


    function getCategoryDetailsContent() {
        const editorId = 'modal_category_details';

        // CKEditor 4
        if (window.CKEDITOR?.instances?.[editorId]) {
            return window.CKEDITOR.instances[editorId].getData();
        }

        // CKEditor 5 (nếu custom_ckeditor.js lưu instance vào window.editors)
        if (window.editors?.[editorId]) {
            return window.editors[editorId].getData();
        }

        // Fallback: lấy trực tiếp value của textarea
        return document.getElementById(editorId)?.value ?? '';
    }

    async function handleSaveCategory(form, saveBtn) {
        const candidateId = form.dataset.usersId; // data-users-id="{{ Auth::user()->id ?? null }}"
        const categoriesName = form.querySelector('.categories_name')?.value.trim();
        const pages = form.querySelector('.pages')?.value;
        const content = getCategoryDetailsContent();

        if (!categoriesName) {
            alert('Vui lòng nhập tên danh mục');
            return;
        }

        if (!pages) {
            alert('Vui lòng chọn trang');
            return;
        }

        const payload = {
            candidate_id: candidateId,
            categories_name: categoriesName,
            pages: pages,
            content: content,
        };
        

        const originalBtnText = saveBtn.textContent;
        saveBtn.disabled = true;
        saveBtn.textContent = 'Đang lưu...';

        try {
            const response = await fetch('http://api.mycv.local/api/contents/create-multiple-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
                body: JSON.stringify(payload),
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => null);
                throw new Error(errorData?.message || `Lỗi HTTP: ${response.status}`);
            }

            const data = await response.json();

            // Đóng modal sau khi thêm thành công
            const modalEl = document.getElementById('editCategoriesModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance?.hide();

            form.reset();

            // TODO: cập nhật lại danh sách danh mục trên UI nếu cần
            console.log('Thêm danh mục thành công:', data);
        } catch (error) {
            console.error('Lỗi khi thêm danh mục:', error);
            alert(`Có lỗi xảy ra: ${error.message}`);
        } finally {
            saveBtn.disabled = false;
            saveBtn.textContent = originalBtnText;
        }
    }
</script>