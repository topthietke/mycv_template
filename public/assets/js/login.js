import { API_URL } from "/assets/js/variableApi.js";
import { msg_success, msg_error } from "/assets/js/function.js";

const API_LOGIN_URL = API_URL.login;
const auth_token = "auth_token";
const HOME_ROUTE = "/home"; // đổi thành route trang chủ thực tế nếu cần

/* ============ Cookie helpers ============ */

const isHttps = () => window.location.protocol === "https:";

function setCookie(name, value, days) {
    const expires = days
        ? `; expires=${new Date(Date.now() + days * 864e5).toUTCString()}`
        : "";
    document.cookie = `${name}=${encodeURIComponent(value)}${expires}; path=/; SameSite=Lax${isHttps() ? "; Secure" : ""}`;
    return getCookie(name) === value; // verify ghi cookie thành công
}

function getCookie(name) {
    const match = document.cookie.match(new RegExp(`(^| )${name}=([^;]+)`));
    return match ? decodeURIComponent(match[2]) : null;
}

function deleteCookie(name) {
    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; SameSite=Lax${isHttps() ? "; Secure" : ""}`;
}

/* ============ UI helpers ============ */

function showError(message) {
    let alertBox = document.getElementById("loginAlert");
    if (!alertBox) {
        alertBox = document.createElement("div");
        alertBox.id = "loginAlert";
        alertBox.className = "alert alert-danger py-2 small mb-3";
        alertBox.setAttribute("role", "alert");
        document.getElementById("loginForm").parentNode.insertBefore(alertBox, document.getElementById("loginForm"));
    }
    alertBox.textContent = message;
    alertBox.classList.remove("d-none");
}

function hideError() {
    document.getElementById("loginAlert")?.classList.add("d-none");
}

function setLoadingState(isLoading) {
    const submitBtn = document.querySelector('#loginForm button[type="submit"]');
    if (!submitBtn) return;

    if (isLoading) {
        submitBtn.dataset.originalHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang đăng nhập...';
    } else {
        submitBtn.disabled = false;
        if (submitBtn.dataset.originalHtml) submitBtn.innerHTML = submitBtn.dataset.originalHtml;
    }
}

/* ============ Validate ============ */

function validateForm(email, password) {
    if (!email) return showError("Vui lòng nhập địa chỉ Email."), false;
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return showError("Địa chỉ Email không hợp lệ."), false;
    if (!password) return showError("Vui lòng nhập mật khẩu."), false;
    return true;
}

/* ============ Submit Login ============ */

async function handleLogin(event) {    
    event.preventDefault();
    hideError();

    const email = document.getElementById("email")?.value.trim() || "";
    const password = document.getElementById("password")?.value || "";
    const rememberMe = document.getElementById("rememberMe")?.checked || false;

    if (!validateForm(email, password)) return false;

    setLoadingState(true);

    try {
        const response = await fetch(API_LOGIN_URL, {
            method: "POST",
            headers: { "Content-Type": "application/json", Accept: "application/json" },
            body: JSON.stringify({ email, password }),
        });

        const data = await response.json().catch(() => ({}));

        if (!response.ok) {
            showError(data.message || (data.errors && Object.values(data.errors)[0]?.[0]) || "Email hoặc mật khẩu không chính xác.");
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
        const cookieSaved = setCookie(auth_token, token, rememberMe ? 7 : null);

        
        // Lưu thêm vào sessionStorage để các script JS khác trong trang dùng cho Authorization header
        let sessionSaved = true;
        try {
            sessionStorage.setItem(auth_token, token);
            sessionSaved = sessionStorage.getItem(auth_token) === token;
        } catch (storageError) {
            console.error("Không thể ghi sessionStorage:", storageError);
            sessionSaved = false;
        }

        console.log(cookieSaved, sessionSaved);
        

        // Middleware phía server (CheckAuthToken) đọc token từ cookie, nên cookie là bắt buộc.
        if (!cookieSaved) {
            showError("Đăng nhập thành công nhưng trình duyệt đã chặn việc lưu cookie. Vui lòng kiểm tra cài đặt cookie/quyền riêng tư rồi thử lại.");
            setLoadingState(false);
            return false;
        }

        if (!sessionSaved) {
            console.warn("Lưu ý: sessionStorage không khả dụng, một số tính năng JS phía client có thể bị ảnh hưởng.");
        }

        if (data.user) {
            try {
                sessionStorage.setItem("auth_token", JSON.stringify(data.user));
            } catch (storageError) {
                console.error("Không thể ghi auth_token vào sessionStorage:", storageError);
            }
        }       

        // Chuyển hướng về trang chủ, middleware server-side sẽ đọc cookie auth_token
        window.location.href = "/home";
    } catch (error) {
        console.error("Lỗi đăng nhập:", error);
        showError("Không thể kết nối tới máy chủ. Vui lòng thử lại sau.");
        setLoadingState(false);
    }

    return false;
}

/* ============ Init ============ */

document.addEventListener("DOMContentLoaded", () => {    
    document.getElementById("loginForm")?.addEventListener("submit", handleLogin);
    // if (getCookie(auth_token)) window.location.href = HOME_ROUTE;
});

export { handleLogin, getCookie, deleteCookie };