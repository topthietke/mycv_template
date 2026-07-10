import { API_URL } from "/assets/js/variableApi.js";
import { msg_success, msg_error } from "/assets/js/function.js";

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

function deleteSelectedCategories(categoryId) {
    const apiUrl = `${API_URL.categories}/${categoryId}`;
    $.ajax({
        url: apiUrl,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Authorization': `Bearer ${getCookie('auth_token')}` // đổi 'auth_token' đúng tên cookie bạn đang set
        },
        success: function (response) {
            msg_success(response.message || 'Xoá danh mục thành công!');
            // Remove the element from the DOM
            const elementToRemove = document.querySelector(`div[data-category-id="${categoryId}"]`);
            if (elementToRemove) {
                elementToRemove.remove();
            }
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message || 'Có lỗi xảy ra, vui lòng thử lại.';
            msg_error(message);
        }
    });
}

(function () {
    const avatarInput = document.getElementById('avatarInput');
    const previewImg = document.getElementById('avatarPreviewImg');
    const placeholderIcon = document.getElementById('avatarPlaceholderIcon');

    if (avatarInput) {
        avatarInput.addEventListener('change', function (e) {
            const file = e.target.files && e.target.files[0];
            if (!file) return;

            // Giới hạn 2MB theo hint hiển thị
            if (file.size > 2 * 1024 * 1024) {
                msg_error('Dung lượng ảnh vượt quá 2MB, vui lòng chọn ảnh khác.');
                avatarInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (ev) {
                previewImg.src = ev.target.result;
                previewImg.style.display = 'block';
                if (placeholderIcon) placeholderIcon.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    }
})();


window.removeCategoryContent = deleteSelectedCategories;

document.addEventListener('DOMContentLoaded', function () {
    const categoryFields = document.getElementById("category_fields");
    const categoryList = document.getElementById("category_list");
    const addBtn = document.getElementById("addCategoryFieldBtn");
    const saveCategoryBtn = document.getElementById("saveCategoryBtn");
    const categoriesForm = document.getElementById("categories_form");

    // Click hiển thị form
    // ----------------------------------------------------------------------
    // Map step id -> form id
    const stepFormMap = {
        candidate: 'candidateForm',
        categories: 'categoryForm',
        contents: 'detailsForm',
    };
    const steps = document.querySelectorAll('.step-indicator .step');
    const progressLine = document.getElementById('progress-line');

    // Thứ tự các step để tính % progress line
    const stepOrder = Object.keys(stepFormMap);

    function showForm(stepId) {
        // Ẩn tất cả form
        Object.values(stepFormMap).forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.classList.remove('active');
                form.style.display = 'none';
            }
        });

        // Hiện form tương ứng với step được click
        const targetFormId = stepFormMap[stepId];
        const targetForm = document.getElementById(targetFormId);
        if (targetForm) {
            targetForm.classList.add('active');
            targetForm.style.display = 'block';
        }
    }

    function setActiveStep(stepId) {
        // Bỏ active tất cả step
        steps.forEach(step => step.classList.remove('active'));

        // Thêm active cho step được chọn
        const currentStep = document.getElementById(stepId);
        if (currentStep) {
            currentStep.classList.add('active');
        }

        // Cập nhật progress line
        const index = stepOrder.indexOf(stepId);
        if (progressLine && index !== -1) {
            const percent = (index / (stepOrder.length - 1)) * 100;
            if (stepId !== 'contents') {
                progressLine.style.width = percent + '%';
            }
        }
    }

    function goToStep(stepId) {
        if (!stepFormMap.hasOwnProperty(stepId)) return;
        setActiveStep(stepId);
        showForm(stepId);
    }

    // Gắn sự kiện click cho từng step
    steps.forEach(step => {
        step.addEventListener('click', function () {
            const stepId = this.id;
            goToStep(stepId);
        });
    });

    // Mặc định hiển thị step đầu tiên (candidate) khi load trang
    goToStep('candidate');
    // ----------------------------------------------------------------------

    // ------------------------------------------------------------------
    // Submit form candidate -> cập nhật thông tin ứng viên
    // ------------------------------------------------------------------
    const candidateForm = document.getElementById('candidateForm');

    if (candidateForm) {
        candidateForm.addEventListener('submit', function (e) {
            e.preventDefault();
            submitCandidateForm(candidateForm);
        });
    }

    function getCandidateId(form) {
        // Ưu tiên lấy từ thuộc tính data-candidate-id gắn trên <form>
        // <form id="candidateForm" data-candidate-id="{{ $candidate['id'] ?? '' }}" ...>
        if (form.dataset.candidateId) {
            return form.dataset.candidateId;
        }

        // Fallback: lấy id từ URL hiện tại nếu có dạng /candidate/edit/{id}
        const match = window.location.pathname.match(/\/candidate\/[^\/]+\/(\d+)/);
        return match ? match[1] : null;
    }

    function clearFormErrors(form) {
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback.js-error').forEach(el => el.remove());
    }

    function showFormErrors(form, errors) {
        Object.keys(errors).forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (!field) return;
            field.classList.add('is-invalid');
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback js-error d-block';
            feedback.textContent = errors[fieldName][0];
            field.parentNode.appendChild(feedback);
        });
    }

    function setSubmitLoading(form, isLoading) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (!submitBtn) return;

        if (isLoading) {
            submitBtn.disabled = true;
            submitBtn.dataset.originalHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Đang lưu...';
        } else {
            submitBtn.disabled = false;
            if (submitBtn.dataset.originalHtml) {
                submitBtn.innerHTML = submitBtn.dataset.originalHtml;
            }
        }
    }
    function get_data_udpate(form) {
        const data = {};

        for (const [key, value] of form.entries()) {
            // Bỏ qua avatar nếu chưa chọn file mới (size = 0)
            if (key === 'avatar') {
                if (value instanceof File && value.size > 0) {
                    data[key] = value;
                }
                continue;
            }

            data[key] = value;
        }

        return data;
    }
    async function submitCandidateForm(form) {
        const success_message = document.getElementById('success_message');
        const errors_message = document.getElementById('errors_message');
        const candidateId = form.dataset.id;
        if (!candidateId) {
            msg_error('Không tìm thấy ứng viên!');
            return;
        }

        clearFormErrors(form);
        setSubmitLoading(form, true);

        const formData = new FormData(form);
        // Laravel không nhận diện được method PUT từ FormData qua fetch, cần thêm _method
        formData.append('_method', 'PUT');

        const apiUrl = `${API_URL.candidate}/${candidateId}`;
        try {
            const response = await fetch(apiUrl, {
                method: 'POST', // Luôn là POST khi dùng FormData với _method
                body: formData,
                credentials: 'include', // gửi kèm cookie auth (CheckAuthToken)
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }, // Không set Content-Type, trình duyệt sẽ tự thêm với boundary
            });

            const result = await response.json().catch(() => ({}));
            if (response.ok) {
                msg_success(result.message || 'Cập nhật thông tin thành công!');
                setTimeout(function () {
                    goToStep('categories');
                }, 1000);
            } else {
                if (response.status === 422) {
                    // Lỗi validate từ Laravel Form Request
                    showFormErrors(form, result.errors || {});
                    msg_error(result.message || 'Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.');
                    return;
                }
                // Các lỗi khác
                throw new Error(result.message || 'Cập nhật thông tin thất bại.');
            }

        } catch (error) {
            msg_error(error.message || 'Có lỗi xảy ra, vui lòng thử lại.');
        } finally {
            setSubmitLoading(form, false);
        }
    }
    // ----------------------------------------------------------------------

    // ----------------------------------------------------------------------

    // Xoá danh mục:
    const removeIcons = document.querySelectorAll('.remove-category-icon');
    console.log(1111111, categoriesForm);
    return;
    removeIcons.forEach(function (icon) {
        icon.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            // const categoryId = this.getAttribute('data-id');
            const categoryId = categoriesForm.getAttribute('data-id');
            console.log(categoryId);
            return;
            deleteSelectedCategories(categoryId);
        });
    });
    // -----------------------------------------------------------------------------------
    // Thêm mới danh mục:
    if (saveCategoryBtn) {
        saveCategoryBtn.addEventListener("click", async function () {
            let candidate_id = document.getElementById('candidateForm')?.dataset.id;
            // Thu thập tất cả các giá trị từ các input có name="categories_name[]"
            const inputs = categoriesForm.querySelectorAll(
                'input[name="categories_name[]"]',
            );
            const categories = Array.from(inputs)
                .map((input) => input.value.trim())
                .filter((val) => val !== "");

            // Kiểm tra nếu người dùng chưa nhập gì
            if (categories.length === 0) {
                msg_error("Vui lòng nhập ít nhất một tên danh mục!");
                return;
            }

            // Lấy Token CSRF từ Blade template (nếu có dùng Laravel)
            const csrfToken = categoriesForm.querySelector('input[name="_token"]',)?.value;
            // Chuẩn bị dữ liệu gửi đi
            const payload = {
                name: categories,
                candidate_id: candidate_id, // Gửi kèm candidate_id nếu API cần liên kết
            };

            // Vô hiệu hóa nút bấm tránh gửi trùng lặp (Double click)
            saveCategoryBtn.disabled = true;
            saveCategoryBtn.innerText = "Đang lưu...";

            try {
                const response = await fetch(API_URL.create_multiple_categories, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify(payload),
                });
                let html = '<div class="row mt-2">';
                let data = null;
                const result = await response.json();
                if (response.ok) {
                    msg_success("Thêm danh mục thành công!");

                    // Mẹo xử lý: Nếu API trả về danh sách kèm ID từ Database (ví dụ result.data) thì ta dùng,
                    // nếu không có thì ta tự tạo ID tạm thời bằng timestamp để không trùng lặp các thuộc tính `for` và `id`
                    const listCategories =
                        result.data ||
                        categories.map((name, index) => ({
                            id: "new_" + index + "_" + Date.now(),
                            name: name,
                        }));

                    // 1. Khởi tạo chuỗi HTML chứa cấu trúc các danh mục mới
                    let htmlContent = '<div class="row mt-2">';
                    listCategories.forEach((cat) => {
                        htmlContent += `
                            <div class="col-md-6 mb-3" data-id="${cat.id}">
                                <label class="category-card" for="cat_${cat.id}">
                                    <input type="checkbox" name="categories[]" value="${cat.id}" id="cat_${cat.id}" class="hidden-checkbox">
                                    <div class="category-icon"><i class="fas fa-bullseye text-primary"></i></div>
                                    <div class="category-info text-start">
                                        <h6>${cat.name}</h6>
                                        <p>Danh mục cá nhân tự thêm</p>
                                    </div>
                                </label>
                            </div>`;
                    });
                    htmlContent += "</div>";

                    // 2. Kiểm tra nếu giao diện đang hiện thông báo trống thì xóa trắng trước khi chèn
                    // if (categoryList.innerHTML.includes('Không có dữ liệu') ||
                    //     categoryList.innerHTML.includes('Không có danh mục nào! Vui lòng thêm mới danh mục trước khi thực hiện')) {
                    //     categoryList.innerHTML = '';
                    //     categoryList.classList.remove('text-center'); // Bỏ căn giữa text để hiển thị lưới thẻ đều nhau
                    // }
                    categoryList.innerHTML = "";
                    // 3. Append (chèn) dữ liệu vào thẻ #category_list ở file chính
                    categoryList.insertAdjacentHTML("beforeend", htmlContent);

                    // 4. Reset form trong modal và xóa các ô input phụ do nút (+) tạo ra (chỉ giữ lại 1 ô trống ban đầu)
                    categoriesForm.reset();
                    const extraGroups = categoryFields.querySelectorAll(
                        ".category-field-group",
                    );
                    extraGroups.forEach((group, index) => {
                        if (index > 0) group.remove();
                    });
                    // 5. Ẩn modal sau khi lưu thành công
                    categoryModal.hide();
                } else {
                    msg_error("Có lỗi xảy ra: " + (result.message || "Vui lòng thử lại."));
                }
            } catch (error) {
                console.error("Error post data:", error);
                msg_error("Không thể kết nối đến máy chủ API!");
            } finally {
                // Mở lại trạng thái nút bấm
                saveCategoryBtn.disabled = false;
                saveCategoryBtn.innerText = "Thêm mới";
            }
        });
    }
    if (addBtn) {
        addBtn.addEventListener("click", function () {
            // Tạo một div wrapper mới
            const newGroup = document.createElement("div");
            newGroup.className =
                "category-field-group mb-3 d-flex align-items-end gap-2";

            // // Đoạn HTML cấu trúc input thuần (thay cho x-input) và nút xóa
            newGroup.innerHTML = `
                <div class="flex-grow-1">
                    <label class="form-label fw-bold">Tên danh mục</label>
                    <input name="categories_name[]" type="text" class="form-control" placeholder="Nhập tên danh mục">
                </div>
                <button type="button" class="btn btn-danger remove-category-btn">
                    <i class="fa fa-trash"></i>
                </button>
            `;

            // Thêm nhóm input mới vào container
            categoryFields.appendChild(newGroup);
        });
    }
    if (categoryFields) {
        categoryFields.addEventListener("click", function (e) {
            // Kiểm tra xem user có click vào nút xóa hoặc icon bên trong nút xóa không
            const removeBtn = e.target.closest(".remove-category-btn");

            if (removeBtn) {
                // Tìm đến group cha gần nhất và xóa nó
                const fieldGroup = removeBtn.closest(".category-field-group");
                if (fieldGroup) {
                    fieldGroup.remove();
                }
            }
        });
    }
    const categoryFormForSubmit = document.getElementById('categoryForm');
    if (categoryFormForSubmit) {
        categoryFormForSubmit.addEventListener('submit', function (e) {
            e.preventDefault(); // Nếu bạn muốn submit AJAX, giữ dòng này. Nếu submit form bình thường thì bỏ đi.
            const form = this;
            // 1. Lấy toàn bộ textarea có trong form và log ra console
            const textareas = form.querySelectorAll('textarea');
            // 2. Cập nhật lại content theo data-category-id
            const categoriesData = [];

            textareas.forEach(function (textarea) {
                // Tìm div cha gần nhất có attribute data-category-id
                const wrapper = textarea.closest('[data-category-id]');
                if (!wrapper) return;

                const categoryId = wrapper.getAttribute('data-category-id');

                const page = document.getElementById(`page_` + categoryId);

                // Nếu textarea này đang được CKEditor quản lý -> đồng bộ dữ liệu CKEditor về textarea trước
                if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[textarea.id]) {
                    const editorInstance = CKEDITOR.instances[textarea.id];
                    editorInstance.updateElement(); // đẩy nội dung editor xuống textarea gốc
                }

                // Lấy nội dung mới nhất (sau khi đã sync từ CKEditor nếu có)
                const content = textarea.value;

                // Cập nhật lại value của textarea (đảm bảo luôn ở trạng thái mới nhất)
                textarea.value = content;

                // Lưu vào object theo category id, để tiện dùng khi gửi API
                // categoriesData[categoryId] = content;

                categoriesData.push({
                    category_id: categoryId,
                    content: content,
                    pages: page.value
                });
            });

            const apiUrl = `${API_URL.update_multiple_data}`;
            const submitBtn = form.querySelector('button[type="submit"]');
            const candidateId = document.getElementById('candidateForm')?.dataset.id;

            if (!candidateId) {
                msg_error('Không tìm thấy thông tin ứng viên. Vui lòng kiểm tra lại.');
                return;
            }

            const payload = categoriesData;

            // Bắt đầu trạng thái loading
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.dataset.originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Đang lưu...';
            }

            fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        msg_success(result.message || 'Cập nhật chi tiết danh mục thành công!');
                        goToStep('contents'); // Chuyển sang bước tiếp theo
                    } else {
                        msg_error(result.message || 'Có lỗi xảy ra, vui lòng thử lại.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    msg_error('Không thể kết nối đến máy chủ. Vui lòng thử lại sau.');
                })
                .finally(() => {
                    // Kết thúc trạng thái loading
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        if (submitBtn.dataset.originalHtml) {
                            submitBtn.innerHTML = submitBtn.dataset.originalHtml;
                        }
                    }
                });
        });
    }

    // ------------------------------------------------------------------------------------------------------------
    // Khởi tạo CKEditor cho modal khi nó được hiển thị
    const modal_categories = document.getElementById('editCategoriesModal');
    if (modal_categories) {
        modal_categories.addEventListener('shown.bs.modal', function () {
            // `initializeCKEditor` is from custom_ckeditor.js
            if (typeof initializeCKEditor === 'function' && !CKEDITOR.instances.modal_category_details) {
                initializeCKEditor('modal_category_details');
            }
        });
    }


    const categories_form = document.getElementById('categories_form');
    if (categories_form) {
        categories_form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const saveBtn = categories_form.querySelector('#saveCategoriesContentsBtn');
            await handleSaveCategory(categories_form, saveBtn);
        });
    };

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
        
        let apiUrl = `${API_URL.create_multiple_data}`;

        try {
            const response = await fetch(apiUrl, {
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
            // const modalEl = document.getElementById('editCategoriesModal');
            const modalInstance = bootstrap.Modal.getInstance(modal_categories);
            form.reset();
            msg_success('Thêm danh mục thành công!');
            modalInstance?.hide();

            // Lắng nghe sự kiện khi modal đã ẩn hoàn toàn rồi tải lại trang
            modal_categories.addEventListener('hidden.bs.modal', function () {
                location.reload();
            }, { once: true }); // { once: true } để sự kiện chỉ chạy 1 lần

        } catch (error) {
            console.error('Lỗi khi thêm danh mục:', error);
            alert(`Có lỗi xảy ra: ${error.message}`);
        } finally {
            saveBtn.disabled = false;
            saveBtn.textContent = originalBtnText;
        }
    }
    // ------------------------------------------------------------------------------------------------------------
});
