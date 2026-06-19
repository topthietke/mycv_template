import { API_URL } from "/assets/js/variableApi.js";
import { msg_success, msg_error, ajax } from "/assets/js/function.js";

const API_BASE_URL = API_URL.login;

// ─── Helpers ────────────────────────────────────────────────────────────────

/**
 * Hiển thị thông báo lỗi dưới một input field
 * @param {string} fieldName - Tên field (email | password)
 * @param {string} message   - Nội dung lỗi
 */
function showFieldError(fieldName, message) {
    const input = document.getElementById(fieldName);
    if (!input) return;

    input.classList.add('is-invalid');

    // Xóa thông báo cũ nếu có
    const existingFeedback = input.parentElement.querySelector('.invalid-feedback');
    if (existingFeedback) existingFeedback.remove();

    const feedback = document.createElement('div');
    feedback.className = 'invalid-feedback';
    feedback.textContent = message;
    input.parentElement.appendChild(feedback);
}

/**
 * Xóa tất cả lỗi trên form
 */
function clearErrors() {
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    const alertBox = document.getElementById('loginAlert');
    if (alertBox) alertBox.remove();
}

/**
 * Hiển thị alert lỗi chung phía trên form
 * @param {string} message
 */
function showGlobalError(message) {
    const form = document.getElementById('loginForm');
    if (!form) return;

    const existingAlert = document.getElementById('loginAlert');
    if (existingAlert) existingAlert.remove();

    const alert = document.createElement('div');
    alert.id = 'loginAlert';
    alert.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
    alert.setAttribute('role', 'alert');
    alert.innerHTML = `<i class="fa fa-exclamation-circle"></i> <span>${message}</span>`;
    form.prepend(alert);
}

/**
 * Bật / tắt trạng thái loading cho nút submit
 * @param {boolean} loading
 */
function setLoading(loading) {
    const btn = document.querySelector('#loginForm button[type="submit"]');
    if (!btn) return;

    if (loading) {
        btn.disabled = true;
        btn.dataset.originalHtml = btn.innerHTML;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang đăng nhập...`;
    } else {
        btn.disabled = false;
        if (btn.dataset.originalHtml) {
            btn.innerHTML = btn.dataset.originalHtml;
        }
    }
}

// ─── Validate ────────────────────────────────────────────────────────────────

/**
 * Validate phía client trước khi gọi API
 * @returns {boolean}
 */
function validateForm(email, password) {
    let valid = true;

    if (!email) {
        showFieldError('email', 'Vui lòng nhập địa chỉ email.');
        valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showFieldError('email', 'Địa chỉ email không hợp lệ.');
        valid = false;
    }

    if (!password) {
        showFieldError('password', 'Vui lòng nhập mật khẩu.');
        valid = false;
    } else if (password.length < 6) {
        showFieldError('password', 'Mật khẩu phải có ít nhất 6 ký tự.');
        valid = false;
    }

    return valid;
}

// ─── API Call ─────────────────────────────────────────────────────────────────


async function callLoginAPI(email, password) {
    const response = await fetch(`${API_BASE_URL}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ email, password }),
    });

    
    const data = await response.json();    
    if (!response.ok) {
        // Ném lỗi kèm data để xử lý validation errors từ server
        const error = new Error(data.message || 'Đăng nhập thất bại.');
        error.status = response.status;
        error.data = data;
        throw error;
    }

    return data;
}

// ─── Session / Token ──────────────────────────────────────────────────────────

/**
 * Lưu thông tin đăng nhập vào storage
 * @param {Object} data   - Response từ API (chứa token, user, ...)
 * @param {boolean} remember - Có ghi nhớ không?
 */
function saveSession(data, remember) {
    console.log(9999, data);
    return;
    const storage = remember ? localStorage : sessionStorage;

    if (data.token || data.access_token) {
        storage.setItem('auth_token', data.token ?? data.access_token);
    }

    if (data.user) {
        storage.setItem('auth_user', JSON.stringify(data.user));
    }

    // Nếu API trả về token_type (Bearer), lưu lại để dùng khi gọi API sau
    if (data.token_type) {
        storage.setItem('token_type', data.token_type);
    }
}

// ─── Main Handler ─────────────────────────────────────────────────────────────

async function handleLogin(event) {    
    event.preventDefault();
    clearErrors();
    const email    = document.getElementById('email')?.value?.trim() ?? '';
    const password = document.getElementById('password')?.value ?? '';
    const remember = document.getElementById('rememberMe')?.checked ?? false;

    // Client-side validation
    if (!validateForm(email, password)) return;

    setLoading(true);

    try {
        const data = await callLoginAPI(email, password);
        // Lưu session
        saveSession(data, remember);
        // Chuyển hướng sau khi đăng nhập thành công
        // Ưu tiên: redirect từ query string → dashboard mặc định
        const params         = new URLSearchParams(window.location.search);
        const redirect       = params.get('redirect') || data.redirect_url || '/home';
        window.location.href = redirect;

    } catch (error) {
        console.error('[Login Error]', error);

        if (error.status === 422 && error.data?.errors) {
            // Validation errors từ Laravel (422 Unprocessable Entity)
            const errors = error.data.errors;
            Object.entries(errors).forEach(([field, messages]) => {
                showFieldError(field, Array.isArray(messages) ? messages[0] : messages);
            });
        } else if (error.status === 401 || error.status === 403) {
            showGlobalError('Email hoặc mật khẩu không đúng. Vui lòng thử lại.');
        } else if (!navigator.onLine) {
            showGlobalError('Không có kết nối mạng. Vui lòng kiểm tra lại.');
        } else {
            showGlobalError(error.message || 'Đã xảy ra lỗi. Vui lòng thử lại sau.');
        }
    } finally {
        setLoading(false);
    }
}

// ─── Init ─────────────────────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    if (form) form.addEventListener('submit', handleLogin);
    // Xóa lỗi inline khi người dùng bắt đầu gõ lại
    ['email', 'password'].forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', () => {
                input.classList.remove('is-invalid');
                const feedback = input.parentElement.querySelector('.invalid-feedback');
                if (feedback) feedback.remove();
            });
        }
    });
});