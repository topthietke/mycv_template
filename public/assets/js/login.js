import { API_URL } from "/assets/js/variableApi.js";
import { msg_success, msg_error, ajax } from "/assets/js/function.js";

const API_LOGIN_URL = API_URL.login;
const TOKEN_COOKIE_NAME = "auth_token";
const HOME_ROUTE = "/"; // đổi thành route trang chủ thực tế nếu cần, vd: "/dashboard"

/* ============ Helpers: Cookie ============ */

/**
 * Set cookie.
 * @param {string} name
 * @param {string} value
 * @param {number} days - số ngày hết hạn. Nếu không truyền -> cookie theo phiên (session cookie).
 */
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    // SameSite=Lax để cookie vẫn gửi kèm khi điều hướng GET thông thường (vào trang chủ)
    document.cookie = `${name}=${encodeURIComponent(value)}${expires}; path=/; SameSite=Lax`;
}

function getCookie(name) {
    const match = document.cookie.match(
        new RegExp("(^| )" + name + "=([^;]+)")
    );
    return match ? decodeURIComponent(match[2]) : null;
}

function deleteCookie(name) {
    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
}

/* ============ Helpers: UI ============ */

function showError(message) {
    let alertBox = document.getElementById("loginAlert");

    if (!alertBox) {
        alertBox = document.createElement("div");
        alertBox.id = "loginAlert";
        alertBox.className = "alert alert-danger py-2 small mb-3";
        alertBox.setAttribute("role", "alert");

        const form = document.getElementById("loginForm");
        form.parentNode.insertBefore(alertBox, form);
    }

    alertBox.textContent = message;
    alertBox.classList.remove("d-none");
}

function hideError() {
    const alertBox = document.getElementById("loginAlert");
    if (alertBox) {
        alertBox.classList.add("d-none");
    }
}

function setLoadingState(isLoading) {
    const submitBtn = document.querySelector(
        '#loginForm button[type="submit"]'
    );
    if (!submitBtn) return;

    if (isLoading) {
        submitBtn.dataset.originalHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang đăng nhập...';
    } else {
        submitBtn.disabled = false;
        if (submitBtn.dataset.originalHtml) {
            submitBtn.innerHTML = submitBtn.dataset.originalHtml;
        }
    }
}

/* ============ Validate ============ */

function validateForm(email, password) {
    if (!email) {
        showError("Vui lòng nhập địa chỉ Email.");
        return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError("Địa chỉ Email không hợp lệ.");
        return false;
    }

    if (!password) {
        showError("Vui lòng nhập mật khẩu.");
        return false;
    }

    return true;
}

/* ============ Submit Login ============ */

async function handleLogin(event) {
    event.preventDefault();
    hideError();

    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const rememberMeInput = document.getElementById("rememberMe");

    const email = emailInput ? emailInput.value.trim() : "";
    const password = passwordInput ? passwordInput.value : "";
    const rememberMe = rememberMeInput ? rememberMeInput.checked : false;

    if (!validateForm(email, password)) {
        return false;
    }

    setLoadingState(true);

    try {
        const response = await fetch(API_LOGIN_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({ email, password }),
        });

        const data = await response.json().catch(() => ({}));
        console.log(data);
        return;


        if (!response.ok) {
            const message =
                data.message ||
                (data.errors && Object.values(data.errors)[0]?.[0]) ||
                "Email hoặc mật khẩu không chính xác.";
            showError(message);
            setLoadingState(false);
            return false;
        }

        // Tùy backend trả về token ở data.token hoặc data.access_token
        const token = data.token || data.access_token || data.data?.token;

        if (!token) {
            showError("Đăng nhập thất bại: không nhận được token từ máy chủ.");
            setLoadingState(false);
            return false;
        }

        // Ghi nhớ đăng nhập -> cookie sống 7 ngày, không thì cookie theo phiên trình duyệt
        const cookieDays = rememberMe ? 7 : null;
        setCookie(TOKEN_COOKIE_NAME, token, cookieDays);

        // Lưu thêm vào sessionStorage để các script JS khác trong trang dùng cho Authorization header
        sessionStorage.setItem(TOKEN_COOKIE_NAME, token);

        if (data.user) {
            sessionStorage.setItem("auth_user", JSON.stringify(data.user));
        }

        // Chuyển hướng về trang chủ, middleware server-side sẽ đọc cookie auth_token
        window.location.href = HOME_ROUTE;
    } catch (error) {
        console.error("Lỗi đăng nhập:", error);
        showError("Không thể kết nối tới máy chủ. Vui lòng thử lại sau.");
        setLoadingState(false);
    }

    return false;
}

/* ============ Init ============ */

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    if (form) {
        form.addEventListener("submit", handleLogin);
    }

    // Nếu đã có token hợp lệ sẵn trong cookie, có thể tự điều hướng về trang chủ
    // (bỏ comment nếu muốn áp dụng)
    // if (getCookie(TOKEN_COOKIE_NAME)) {
    //     window.location.href = HOME_ROUTE;
    // }
});

export { handleLogin, getCookie, deleteCookie };