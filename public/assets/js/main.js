document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("multiStepForm");
    const steps = Array.from(document.querySelectorAll(".form-step"));
    const nextBtns = document.querySelectorAll(".next-step");
    const prevBtns = document.querySelectorAll(".prev-step");
    const categoryCards = document.querySelectorAll(".category-card");
    const dynamicArea = document.getElementById("dynamic-content-area");

    let currentStep = 0;
    let selectedCategories = [];

    // --- 1. Xử lý chuyển bước Form ---
    nextBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            if (validateStep(currentStep)) {
                if (currentStep === 1) {
                    // Nếu đang từ bước 2 sang bước 3, render các ô nhập dữ liệu tương ứng
                    renderStep3Fields();
                }
                currentStep++;
                updateFormSteps();
            }
        });
    });

    prevBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            currentStep--;
            updateFormSteps();
        });
    });

    function updateFormSteps() {
        steps.forEach((step, index) => {
            step.classList.toggle("active", index === currentStep);

            // Cập nhật trạng thái thanh Tiến trình (Stepper)
            const indicator = document.getElementById(`step-indicator-${index + 1}`);
            if (indicator) {
                indicator.classList.toggle("active", index <= currentStep);
            }
        });
    }

    // Validate nhanh phía Client
    function validateStep(stepIndex) {
        if (stepIndex === 0) {
            const inputs = steps[0].querySelectorAll("[required]");
            let valid = true;
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = "red";
                    valid = false;
                } else {
                    input.style.borderColor = "";
                }
            });
            if (!valid) alert("Vui lòng điền đầy đủ các thông tin bắt buộc (*)");
            return valid;
        }
        if (stepIndex === 1) {
            if (selectedCategories.length === 0) {
                alert("Vui lòng chọn ít nhất một danh mục để tiếp tục.");
                return false;
            }
            return true;
        }
        return true;
    }

    // --- 2. Xử lý chọn Danh mục (Bước 2) ---
    categoryCards.forEach(card => {
        card.addEventListener("click", () => {
            card.classList.toggle("selected");
            const catId = card.getAttribute("data-id");
            const catName = card.querySelector("h4").innerText;
            const catCode = card.getAttribute("data-code");

            const index = selectedCategories.findIndex(item => item.id === catId);
            if (index > -1) {
                selectedCategories.splice(index, 1); // Bỏ chọn
            } else {
                selectedCategories.push({ id: catId, name: catName, code: catCode }); // Chọn thêm
            }
        });
    });

    // --- 3. Render Động các trường nhập liệu tại Bước 3 ---
    function renderStep3Fields() {
        dynamicArea.innerHTML = ""; // Reset nội dung cũ

        // Gợi ý placeholder tương tự như hình ảnh minh họa
        const placeholders = {
            objective: "VD: Trở thành chuyên gia phát triển hệ thống lớn, tối ưu hóa database, nâng cấp cấu trúc mã nguồn Laravel tinh gọn...",
            skill: "VD: PHP, Laravel, VueJS, OOP, Git, DBeaver, Postman",
            experience: "VD: 2 năm làm việc tại công ty A, phát triển hệ thống thương mại điện tử...",
            education: "VD: Tốt nghiệp Đại học Bách Khoa Hà Nội, Chứng chỉ TOIEC 750..."
        };

        selectedCategories.forEach((cat) => {
            const placeholder = placeholders[cat.code] || "Nhập thông tin chi tiết...";
            const box = document.createElement("div");
            box.className = "dynamic-box";
            box.innerHTML = `
                <h4>${cat.name} <span class="required">*</span></h4>
                <p class="step-desc">Chi tiết ${cat.name.toLowerCase()} ngắn hạn & dài hạn</p>
                <input type="hidden" name="contents[${cat.id}][category_id]" value="${cat.id}">
                <textarea name="contents[${cat.id}][content]" placeholder="${placeholder}" required></textarea>
            `;
            dynamicArea.appendChild(box);
        });
    }

    // --- 4. Submit toàn bộ Form dữ liệu lên Laravel Backend ---
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        // Tạo đối tượng FormData để chứa dữ liệu text và file upload
        const formData = new FormData(form);
        
        // Gọi API sử dụng Fetch
        fetch("/api/candidate", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Accept": "application/json"
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload(); // Hoặc redirect đi trang khác
                } else {
                    // Xử lý hiển thị lỗi validate từ hệ thống nếu có
                    alert("Đăng ký thất bại. Vui lòng kiểm tra lại dữ liệu.");
                    console.error(data.errors);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Có lỗi kết nối hệ thống!");
            });
    });
});