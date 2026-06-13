const API_BASE_URL = "http://api.mycv.local/api";
const TOKEN_KEY = "mycv_token";
const TOKEN_EXPIRY_DAYS = 7;

// ==================== Cookie Helpers ====================

function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${encodeURIComponent(value)};expires=${expires.toUTCString()};path=/;SameSite=Lax`;
}

function getCookie(name) {
    const match = document.cookie
        .split("; ")
        .find((row) => row.startsWith(`${name}=`));
    return match ? decodeURIComponent(match.split("=")[1]) : null;
}

function deleteCookie(name) {
    document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;`;
}

// ==================== Token Management ====================

function saveToken(token, rememberMe = false) {
    if (rememberMe) {
        // Lưu vào cookie với thời hạn 7 ngày
        setCookie(TOKEN_KEY, token, TOKEN_EXPIRY_DAYS);
        sessionStorage.removeItem(TOKEN_KEY);
    } else {
        // Lưu vào sessionStorage (tự xóa khi đóng tab)
        sessionStorage.setItem(TOKEN_KEY, token);
        deleteCookie(TOKEN_KEY);
    }
}

function getToken() {
    return getCookie(TOKEN_KEY) || sessionStorage.getItem(TOKEN_KEY);
}

function clearToken() {
    deleteCookie(TOKEN_KEY);
    sessionStorage.removeItem(TOKEN_KEY);
}

// ==================== UI Helpers ====================

function showError(message) {
    let alertBox = document.getElementById("loginAlert");

    if (!alertBox) {
        alertBox = document.createElement("div");
        alertBox.id = "loginAlert";
        alertBox.className = "alert alert-danger alert-dismissible fade show mt-3";
        alertBox.setAttribute("role", "alert");

        const form = document.getElementById("loginForm");
        form.prepend(alertBox);
    }

    alertBox.innerHTML = `
        <i class="fa fa-circle-exclamation me-2"></i>
        <span>${message}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
}

function hideError() {
    const alertBox = document.getElementById("loginAlert");
    if (alertBox) alertBox.remove();
}

function setLoadingState(isLoading) {
    const submitBtn = document.querySelector('#loginForm button[type="submit"]');
    if (!submitBtn) return;

    if (isLoading) {
        submitBtn.disabled = true;
        submitBtn.dataset.originalHtml = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Đang đăng nhập...
        `;
    } else {
        submitBtn.disabled = false;
        if (submitBtn.dataset.originalHtml) {
            submitBtn.innerHTML = submitBtn.dataset.originalHtml;
        }
    }
}

// ==================== Main Login Handler ====================

async function handleLogin(event) {
    event.preventDefault();
    hideError();

    const email = document.getElementById("email")?.value?.trim();
    const password = document.getElementById("password")?.value;
    const rememberMe = document.getElementById("rememberMe")?.checked ?? false;

    // Validate cơ bản phía client
    if (!email || !password) {
        showError("Vui lòng nhập đầy đủ email và mật khẩu.");
        return false;
    }

    setLoadingState(true);

    try {
        const response = await fetch(`${API_BASE_URL}/login`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({ email, password }),
        });

        const data = await response.json();

        if (!response.ok) {
            // Laravel thường trả lỗi trong data.message hoặc data.errors
            const errorMsg =
                data?.message ||
                Object.values(data?.errors ?? {})?.[0]?.[0] ||
                "Đăng nhập thất bại. Vui lòng thử lại.";
            showError(errorMsg);
            return false;
        }

        // Lấy token từ response (tuỳ API trả về cấu trúc nào)
        const token =
            data?.token ||
            data?.access_token ||
            data?.data?.token ||
            data?.data?.access_token;

        if (!token) {
            showError("Không nhận được token từ máy chủ.");
            return false;
        }

        // Lưu token
        saveToken(token, rememberMe);

        // Redirect sau khi đăng nhập thành công
        const redirectUrl = data?.redirect || "/dashboard";
        window.location.href = redirectUrl;
    } catch (error) {
        console.error("Login error:", error);
        showError("Không thể kết nối đến máy chủ. Vui lòng kiểm tra kết nối mạng.");
    } finally {
        setLoadingState(false);
    }

    return false;
}

// ==================== Logout ====================

function logout() {
    const token = getToken();

    if (token) {
        // Gọi API logout (không cần await, fire-and-forget)
        fetch(`${API_BASE_URL}/logout`, {
            method: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        }).catch(() => {});
    }

    clearToken();
    window.location.href = "/login";
}

// ==================== Auto-redirect nếu đã login ====================

(function checkAlreadyLoggedIn() {
    const token = getToken();
    const isLoginPage =
        window.location.pathname === "/login" ||
        window.location.pathname === "/";

    if (token && isLoginPage) {
        window.location.href = "/dashboard";
    }
})();

// Export để dùng ở file khác nếu cần
window.handleLogin = handleLogin;
window.logout = logout;
window.getToken = getToken;
window.clearToken = clearToken;