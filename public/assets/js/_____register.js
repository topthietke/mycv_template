import { API_URL } from "/assets/js/variableApi.js";
import { msg_success, msg_error, ajax } from "/assets/js/function.js";

// ==================== STEP NAVIGATION ====================
function goToStep(step) {
    $('.step-form').removeClass('active');
    $('.step').removeClass('active completed');

    const config = {
        1: { form: '#candidateForm',  active: ['#indicator-1'],                              progress: '0%'  },
        2: { form: '#categoryForm',   active: ['#indicator-2'], completed: ['#indicator-1'], progress: '70%' },
        3: { form: '#detailsForm',    active: ['#indicator-3'], completed: ['#indicator-1', '#indicator-2'] },
    };

    const c = config[step];
    if (!c) return;
    $(c.form).addClass('active');
    (c.completed || []).forEach(id => $(id).addClass('completed'));
    c.active.forEach(id => $(id).addClass('active'));
    if (c.progress) $('#progress-line').css('width', c.progress);
}

// ==================== BƯỚC 1: CANDIDATE FORM ====================
$(document).ready(function () {
    const requiredFields = ['fullname', 'position', 'birthday', 'gender', 'email', 'phone'];
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Xóa lỗi khi người dùng nhập lại
    $('.form-control, .form-select').on('input change', function () {
        $(this).removeClass('is-invalid').siblings('.error-message').hide();
    });

    $('#candidateForm').on('submit', function (e) {
        e.preventDefault();
        $('.form-control, .form-select').removeClass('is-invalid');
        $('.error-message').hide();

        let isValid = true;
        requiredFields.forEach(field => {
            const input = $(`[name="${field}"]`);
            const val = input.val().trim();
            if (!val) {
                input.addClass('is-invalid').siblings('.error-message').show();
                isValid = false;
            } else if (field === 'email' && !emailRegex.test(val)) {
                input.addClass('is-invalid').siblings('.error-message').text('Email không đúng định dạng').show();
                isValid = false;
            }
        });

        if (!isValid) return;

        const $btn = $('#btnSubmit');
        const originalText = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);

        $.ajax({
            url: API_URL.candidate,
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
            success(res) {
                if (res?.success) {
                    alert(res.message || 'Thông tin đã được lưu thành công!');
                    sessionStorage.setItem('candidate_id', res.data.id);
                    goToStep(2);
                } else {
                    alert(res.message);
                    $btn.html(originalText).prop('disabled', false);
                }
            },
            error(xhr) {
                const errors = xhr.responseJSON?.errors;
                const messages = errors
                    ? Object.values(errors).flat().join('\n')
                    : xhr.responseJSON?.message || 'Thông tin đăng ký không hợp lệ';
                alert(messages);
            }
        });
    });
});

// ==================== BƯỚC 2: CATEGORY FORM ====================
document.addEventListener('DOMContentLoaded', function () {
    const categoryFields  = document.getElementById('category_fields');
    const categoryList    = document.getElementById('category_list');
    const addBtn          = document.getElementById('addCategoryFieldBtn');
    const saveCategoryBtn = document.getElementById('saveCategoryBtn');
    const categoriesForm  = document.getElementById('categories_form');
    const submitBtn       = document.getElementById('category_form_submit');
    const categoryForm    = document.getElementById('categoryForm');
    const categoryModal   = bootstrap.Modal.getOrCreateInstance(document.getElementById('categoryModal'));

    if (!categoryFields || !categoryList || !addBtn || !saveCategoryBtn || !categoriesForm) return;

    // --- Thêm / Xóa input danh mục trong modal ---
    addBtn.addEventListener('click', function () {
        const newGroup = document.createElement('div');
        newGroup.className = 'category-field-group mb-3 d-flex align-items-end gap-2';
        newGroup.innerHTML = `
            <div class="flex-grow-1">
                <label class="form-label fw-bold">Tên danh mục</label>
                <input name="categories_name[]" type="text" class="form-control" placeholder="Nhập tên danh mục">
            </div>
            <button type="button" class="btn btn-danger remove-category-btn"><i class="fa fa-trash"></i></button>`;
        categoryFields.appendChild(newGroup);
    });

    // Event delegation: xóa nhóm input (giữ lại ít nhất 1)
    categoryFields.addEventListener('click', function (e) {
        const removeBtn = e.target.closest('.remove-category-btn');
        if (!removeBtn) return;
        const groups = categoryFields.querySelectorAll('.category-field-group');
        if (groups.length > 1) {
            removeBtn.closest('.category-field-group').remove();
        } else {
            alert('Phải giữ lại ít nhất một danh mục!');
        }
    });

    // --- Lưu danh mục mới qua API ---
    saveCategoryBtn.addEventListener('click', async function () {
        const candidate_id = sessionStorage.getItem('candidate_id');
        const inputs = categoriesForm.querySelectorAll('input[name="categories_name[]"]');
        const categories = Array.from(inputs).map(i => i.value.trim()).filter(Boolean);

        if (!categories.length) {
            alert('Vui lòng nhập ít nhất một tên danh mục!');
            return;
        }

        const csrfToken = categoriesForm.querySelector('input[name="_token"]')?.value;
        saveCategoryBtn.disabled = true;
        saveCategoryBtn.innerText = 'Đang lưu...';

        try {
            const response = await fetch(API_URL.create_multiple_categories, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ name: categories, candidate_id })
            });

            const result = await response.json();

            if (response.ok) {
                alert('Thêm danh mục thành công!');

                const listCategories = result.data || categories.map((name, i) => ({
                    id: `new_${i}_${Date.now()}`, name
                }));

                const htmlContent = '<div class="row mt-2">' + listCategories.map(cat => `
                    <div class="col-md-6 mb-3" data-id="${cat.id}">
                        <label class="category-card" for="cat_${cat.id}">
                            <input type="checkbox" name="categories[]" value="${cat.id}" id="cat_${cat.id}" class="hidden-checkbox">
                            <div class="category-icon"><i class="fas fa-bullseye text-primary"></i></div>
                            <div class="category-info text-start">
                                <h6>${cat.name}</h6>
                                <p>Danh mục cá nhân tự thêm</p>
                            </div>
                        </label>
                    </div>`).join('') + '</div>';

                categoryList.innerHTML = '';
                categoryList.insertAdjacentHTML('beforeend', htmlContent);

                categoriesForm.reset();
                categoryFields.querySelectorAll('.category-field-group').forEach((g, i) => { if (i > 0) g.remove(); });
                categoryModal.hide();
            } else {
                alert('Có lỗi xảy ra: ' + (result.message || 'Vui lòng thử lại.'));
            }
        } catch (error) {
            console.error('Error post data:', error);
            alert('Không thể kết nối đến máy chủ API!');
        } finally {
            saveCategoryBtn.disabled = false;
            saveCategoryBtn.innerText = 'Thêm mới';
        }
    });

    // --- Cập nhật nút Submit & Sync hidden inputs khi chọn/bỏ danh mục ---
    function updateSubmitButton() {
        if (submitBtn) submitBtn.disabled = !categoryList.querySelectorAll('input[name="categories[]"]:checked').length;
    }

    function syncSelectedCategoriesToDetailsForm() {
        const detailsForm = document.getElementById('detailsForm');
        if (!detailsForm) return;

        detailsForm.querySelectorAll('.synced-category').forEach(el => el.remove());

        categoryList.querySelectorAll('input[name="categories[]"]:checked').forEach(checkbox => {
            const colDiv = checkbox.closest('[data-id]');
            const categoryId   = colDiv?.getAttribute('data-id') ?? checkbox.value;
            const categoryName = colDiv?.querySelector('h6')?.textContent?.trim() ?? '';

            ['category_ids[]', 'category_names[]'].forEach((name, idx) => {
                const input = document.createElement('input');
                input.type  = 'hidden';
                input.name  = name;
                input.value = idx === 0 ? categoryId : categoryName;
                input.classList.add('synced-category');
                detailsForm.appendChild(input);
            });
        });
    }

    // Event delegation: click vào card (kể cả card mới thêm qua Ajax)
    categoryList.addEventListener('click', function (e) {
        if (!e.target.closest('.category-card')) return;
        setTimeout(() => {
            updateSubmitButton();
            syncSelectedCategoriesToDetailsForm();
        }, 50);
    });

    // --- Nút "Tiếp theo" sang Bước 3 ---
    if (submitBtn) {
        submitBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const checkedBoxes = categoryList.querySelectorAll('input[name="categories[]"]:checked');
            if (!checkedBoxes.length) {
                alert('Vui lòng chọn ít nhất một danh mục trước khi tiếp tục!');
                return;
            }

            window.selectedCategories = Array.from(checkedBoxes).map(cb => {
                const colDiv = cb.closest('[data-id]');
                return {
                    id:   colDiv?.getAttribute('data-id') ?? cb.value,
                    name: colDiv?.querySelector('h6')?.textContent?.trim() ?? ''
                };
            });

            renderDetailsForm(window.selectedCategories);

            // Khởi tạo TinyMCE cho các textarea vừa được render
            tinymce.init({
                selector: 'textarea.experiences',
                plugins: 'advlist autolink lists link image table code fullscreen',
                toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code fullscreen',
                height: 300,
            });

            if (typeof goToStep === 'function') {
                goToStep(3);
            } else {
                const detailsForm = document.getElementById('detailsForm');
                if (detailsForm && categoryForm) {
                    categoryForm.classList.remove('active');
                    categoryForm.style.display = 'none';
                    detailsForm.classList.add('active');
                    detailsForm.style.display = 'block';
                }
            }
        });
    }

    // --- Nút "Quay lại" bước 1 ---
    categoryForm?.querySelector('.btn-back-step')?.addEventListener('click', () => goToStep(1));

    // --- Render form chi tiết Bước 3 ---
    function renderDetailsForm(categories) {
        const container = document.getElementById('dynamic-categories-container');
        if (!container) return;
        container.innerHTML = '';
        categories.forEach(cat => {
            container.insertAdjacentHTML('beforeend',
                `<div class="mb-4" data-category-id="${cat.id}">
                    <div class="section-title fw-bold mb-2 text-dark">- ${cat.name}: </div>
                    <div class="mb-2">
                        <textarea id="editor-${cat.id}" class="form-control experiences" name="category_details[${cat.id}]" rows="4" placeholder="Vui lòng nhập nội dung cho danh mục ${cat.name}..." required></textarea>
                    </div>
                </div>`);
        });
    }
});

// ==================== BƯỚC 3: DETAILS FORM ====================
document.getElementById('detailsForm').addEventListener('submit', async function (event) {    
    event.preventDefault();

    // Đồng bộ dữ liệu từ TinyMCE về textarea trước khi validate/lấy dữ liệu
    if (typeof tinymce !== 'undefined') tinymce.triggerSave();
    
    
    const candidateId = sessionStorage.getItem('candidate_id');
    const sections    = document.querySelectorAll('#dynamic-categories-container .form-section');
    const requestDataList = [];
    let isValid = true;

    sections.forEach(section => {
        const textarea     = section.querySelector('textarea.experiences');
        const content      = textarea.value.trim();
        const categoryName = section.querySelector('.section-title').textContent.trim();

        if (!content) {
            alert(`Vui lòng nhập nội dung cho danh mục: ${categoryName}`);
            // Tìm instance TinyMCE và focus vào đó
            const editor = tinymce.get(textarea.id);
            if (editor) {
                editor.focus();
            } else {
                textarea.focus(); // Fallback nếu không tìm thấy TinyMCE instance
            }
            isValid = false;
            return;
        }

        requestDataList.push({
            candidate_id: parseInt(candidateId),
            category_id:  parseInt(section.getAttribute('data-category-id')),
            content
        });
    });

    if (!isValid) return;
    console.log();
    
    const submitBtn = this.querySelector('.btn-submit');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Đang xử lý...';

    try {
        const apiRequests = requestDataList.map(data => $.ajax({
            url: API_URL.contents,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data)
        }));

        await $.when.apply($, apiRequests);

        alert('Thêm mới thông tin chi tiết thành công!');
        setTimeout(() => { window.location.href = '/login'; }, 2000);

    } catch (error) {
        console.error('Error:', error);
        alert('Đã có lỗi xảy ra trong quá trình lưu dữ liệu. Vui lòng thử lại!');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-check-circle me-1"></i> Kết thúc';
    }
});