import { API_URL } from "/assets/js/variableApi.js";
import { msg_success, msg_error } from "/assets/js/function.js";

document.addEventListener('DOMContentLoaded', function () {
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
        let data = get_data_udpate(formData);
        // formData.append('_method', 'PUT');
        const apiUrl = `${API_URL.candidate}/${candidateId}`;
        try {
            const response = await fetch(apiUrl, {
                method: 'PUT',
                body: JSON.stringify(data),
                credentials: 'include', // gửi kèm cookie auth (CheckAuthToken)
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
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
                    msg_error(result.message || 'Cập nhật thông tin thất bại!');
                    return;
                }

                if (!response.ok) {
                    throw new Error(result.message || 'Cập nhật thông tin thất bại.');
                    new bootstrap.Modal(document.getElementById('errorsModal')).show();
                    errors_message.textContent = result.message || 'Cập nhật thông tin thất bại!';
                }
            }

        } catch (error) {
            msg_error(error.message || 'Có lỗi xảy ra, vui lòng thử lại.');            
        } finally {
            setSubmitLoading(form, false);
        }
    }
    // ----------------------------------------------------------------------
});

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