import { API_URL } from "/assets/js/variableApi.js";
import { msg_success, msg_error, ajax } from "/assets/js/function.js";

function goToStep(step) {
    // Ẩn tất cả form
    $(".step-form").removeClass("active");

    // Xóa trạng thái active của indicator
    $(".step").removeClass("active completed");

    // Cập nhật giao diện thanh hiển thị (progress bar)
    if (step === 1) {
        $("#candidateForm").addClass("active");
        $("#indicator-1").addClass("active");
        $("#progress-line").css("width", "0%");
    } else if (step === 2) {
        $("#categoryForm").addClass("active");
        $("#indicator-1").addClass("completed");
        $("#indicator-2").addClass("active");
        $("#progress-line").css("width", "80%");
    } else if (step === 3) {
        $("#detailsForm").addClass("active");
        $("#indicator-1").addClass("completed");
        $("#indicator-2").addClass("completed");
        $("#indicator-3").addClass("active");
        // $('#progress-line').css('width', '100%');
    }
}

$(document).ready(function () {
    // Lấy API host từ file .env thông qua Laravel helper

    $("#candidateForm").on("submit", function (e) {
        e.preventDefault();
        let isValid = true;
        // Reset error states
        $(".form-control, .form-select").removeClass("is-invalid");
        $(".error-message").hide();

        // Các trường bắt buộc theo design
        const requiredFields = [
            "fullname",
            "position",
            "birthday",
            "gender",
            "email",
            "phone",
        ];

        requiredFields.forEach(function (field) {
            let input = $(`[name="${field}"]`);
            let val = input.val().trim();

            if (val === "") {
                input.addClass("is-invalid");
                input.siblings(".error-message").show();
                isValid = false;
            }

            // Validate format email cơ bản
            if (field === "email" && val !== "") {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(val)) {
                    input.addClass("is-invalid");
                    input
                        .siblings(".error-message")
                        .text("Email không đúng định dạng")
                        .show();
                    isValid = false;
                }
            }
        });

        if (!isValid) {
            return false; // Dừng lại nếu validate fail
        }

        // Đổi trạng thái button
        let $btn = $("#btnSubmit");
        let originalText = $btn.html();
        $btn
            .html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...')
            .prop("disabled", true);

        // Gom dữ liệu form (hỗ trợ cả file avatar)
        let formData = new FormData(this);

        $.ajax({
            url: API_URL.candidate,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').val(),
            },
            success: function (res) {
                if (res && res.success == true) {
                    alert(res.message || "Thông tin đã được lưu thành công!");

                    // Lấy giá trị id từ response.data
                    const candidate_id = res.data.id;
                    sessionStorage.setItem("candidate_id", candidate_id);
                    goToStep(2); // Chuyển sang bước 2
                } else {
                    alert(res.message);
                    $btn.html(originalText).prop("disabled", false);
                    return false;
                }
            },
            error: function (xhr, status, error) {
                // ---------------------------------------------------------------
                let errorMessage = "Thông tin đăng ký không hợp lệ";
                let errorMessagesArray = []; // Mảng chứa tất cả các câu lỗi cụ thể

                // Kiểm tra nếu server trả về JSON có chứa errors
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    // Duyệt qua từng trường bị lỗi (facebook_url, git_url, v.v...)
                    for (let field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            // errors[field] là một mảng chứa các câu lỗi của trường đó
                            errors[field].forEach(function (msg) {
                                errorMessagesArray.push(msg);
                            });
                        }
                    }

                    // Nếu tìm thấy lỗi cụ thể, gộp chúng lại thành một chuỗi để hiển thị
                    if (errorMessagesArray.length > 0) {
                        errorMessage = errorMessagesArray.join("\n"); // Nối các lỗi bằng dấu xuống dòng
                    } else if (xhr.responseJSON.message) {
                        // Trường hợp không có errors chi tiết nhưng có message chung
                        errorMessage = xhr.responseJSON.message;
                    }
                }

                // ---------------------------------------------------------------
                // Hiển thị lỗi hoặc xử lý tiếp theo tùy thuộc vào logic của bạn
                alert(errorMessage);
                // Hoặc console.log(errorMessagesArray); nếu bạn muốn dùng mảng để map vào từng input
            },
        });
    });

    // Xóa thông báo lỗi khi người dùng bắt đầu nhập lại
    $(".form-control, .form-select").on("input change", function () {
        $(this).removeClass("is-invalid");
        $(this).siblings(".error-message").hide();
    });
});

// ========================================== Bổ sung thêm input danh mục ==========================================
document.addEventListener("DOMContentLoaded", function () {
    const categoryFields = document.getElementById("category_fields");
    const categoryList = document.getElementById("category_list");
    const addBtn = document.getElementById("addCategoryFieldBtn");
    const saveCategoryBtn = document.getElementById("saveCategoryBtn");
    const categoriesForm = document.getElementById("categories_form");

    // Lấy instance của Bootstrap Modal để đóng sau khi lưu thành công
    const categoryModalEl = document.getElementById("categoryModal");
    const categoryModal = bootstrap.Modal.getOrCreateInstance(categoryModalEl);

    // Lắng nghe sự kiện click vào nút Thêm (+)
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

    // Sử dụng Event Delegation để lắng nghe sự kiện click nút Xóa (kể cả các nút tạo mới)
    categoryFields.addEventListener("click", function (e) {
        // Kiểm tra xem user có click vào nút xóa hoặc icon bên trong nút xóa không
        const removeBtn = e.target.closest(".remove-category-btn");

        if (removeBtn) {
            // Tìm đến group cha gần nhất và xóa nó
            const fieldGroup = removeBtn.closest(".category-field-group");
            fieldGroup.remove();
        }
    });

    // Chức năng xóa bớt ô nhập (Ủy quyền sự kiện - Event Delegation)
    categoryFields.addEventListener("click", function (e) {
        if (
            e.target.classList.contains("remove-category-btn") ||
            e.target.closest(".remove-category-btn")
        ) {
            const group = e.target.closest(".category-field-group");
            // Giữ lại ít nhất 1 ô nhập, không cho xóa hết sạch
            if (categoryFields.querySelectorAll(".category-field-group").length > 1) {
                group.remove();
            } else {
                alert("Phải giữ lại ít nhất một danh mục!");
            }
        }
    });

    // ==============================================  Thêm mới danh mục ===============================================
    // 2. Chức năng gửi API khi bấm nút "Thêm mới"
    saveCategoryBtn.addEventListener("click", async function () {
        let candidate_id = sessionStorage.getItem("candidate_id");
        // Thu thập tất cả các giá trị từ các input có name="categories_name[]"
        const inputs = categoriesForm.querySelectorAll(
            'input[name="categories_name[]"]',
        );
        const categories = Array.from(inputs)
            .map((input) => input.value.trim())
            .filter((val) => val !== "");

        // Kiểm tra nếu người dùng chưa nhập gì
        if (categories.length === 0) {
            alert("Vui lòng nhập ít nhất một tên danh mục!");
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
                alert("Thêm danh mục thành công!");

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
                alert("Có lỗi xảy ra: " + (result.message || "Vui lòng thử lại."));
            }
        } catch (error) {
            console.error("Error post data:", error);
            alert("Không thể kết nối đến máy chủ API!");
        } finally {
            // Mở lại trạng thái nút bấm
            saveCategoryBtn.disabled = false;
            saveCategoryBtn.innerText = "Thêm mới";
        }
    });

    // Thực hiện bước số 3
    const categoryForm = document.getElementById("categoryForm");
    if (categoryForm) {
        const nextButton = categoryForm.querySelector(".btn-next");

        // Lắng nghe sự kiện click vào nút "Tiếp theo"
        if (nextButton) {
            nextButton.addEventListener("click", function (e) {
                e.preventDefault(); // Ngăn chặn hành vi reload trang mặc định của button

                // 1. Kiểm tra xem người dùng đã chọn ít nhất 1 danh mục chưa (Tùy chọn)
                const checkedCategories = categoryForm.querySelectorAll(
                    'input[name="categories[]"]:checked',
                );

                // if (checkedCategories.length === 0) {
                //   alert("Vui lòng chọn ít nhất một danh mục trước khi tiếp tục!");
                //   return;
                // }

                // 2. Lấy dữ liệu của form hiện tại bằng FormData (Nếu bạn cần dùng sau này)
                const formData = new FormData(categoryForm);

                // 3. Tìm form chi tiết ở bước 3 (id="detailsForm")
                const detailsForm = document.getElementById("detailsForm");

                if (detailsForm) {
                    // Ẩn form bước 2 (bằng cách xóa class 'active' hoặc ẩn style)
                    categoryForm.classList.remove("active");
                    categoryForm.style.display = "none";

                    // Hiển thị form bước 3
                    detailsForm.classList.add("active");
                    detailsForm.style.display = "block"; // Hoặc style phù hợp với giao diện của bạn

                    console.log("Đã chuyển sang bước 3 thành công.");
                } else {
                    console.error(
                        'Không tìm thấy form với id="detailsForm" ở file content_form.',
                    );
                }
            });
        }

        // Xử lý thêm cho nút "Quay lại" (Nếu bạn cần)
        const backButton = categoryForm.querySelector(".btn-back-step");
        if (backButton) {
            backButton.addEventListener("click", function () {
                // Code xử lý quay lại bước 1 tại đây...
            });
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryCards = document.querySelectorAll(
        "#category_list .category-card",
    );
    const submitBtn = document.getElementById("category_form_submit");

    categoryCards.forEach(function (card) {
        card.addEventListener("click", function () {
            updateSubmitButton();
            syncSelectedCategoriesToDetailsForm();
        });
    });

    function updateSubmitButton() {
        const anyChecked =
            document.querySelectorAll(
                '#category_list input[name="categories[]"]:checked',
            ).length > 0;
        submitBtn.disabled = !anyChecked;
    }

    function syncSelectedCategoriesToDetailsForm() {
        const detailsForm = document.getElementById("detailsForm");
        if (!detailsForm) return;

        // Xóa các hidden input cũ đã sync trước đó
        detailsForm
            .querySelectorAll(".synced-category")
            .forEach((el) => el.remove());

        const checkedBoxes = document.querySelectorAll(
            '#category_list input[name="categories[]"]:checked',
        );

        checkedBoxes.forEach(function (checkbox) {
            const colDiv = checkbox.closest("[data-id]");
            const categoryId = colDiv
                ? colDiv.getAttribute("data-id")
                : checkbox.value;
            const categoryName = colDiv
                ? colDiv.querySelector("h6")?.textContent?.trim()
                : "";

            // Hidden input cho ID
            const inputId = document.createElement("input");
            inputId.type = "hidden";
            inputId.name = "category_ids[]";
            inputId.value = categoryId;
            inputId.classList.add("synced-category");

            // Hidden input cho Name
            const inputName = document.createElement("input");
            inputName.type = "hidden";
            inputName.name = "category_names[]";
            inputName.value = categoryName;
            inputName.classList.add("synced-category");

            detailsForm.appendChild(inputId);
            detailsForm.appendChild(inputName);
        });
    }
});

// ============================================================= Next Bước 3 + Page & Drag-Drop ================================================
document.addEventListener("DOMContentLoaded", function () {
    const categoryForm = document.getElementById("categoryForm");
    const categoryList = document.getElementById("category_list");
    const submitBtn = document.getElementById("category_form_submit");

    if (!categoryForm || !categoryList || !submitBtn) return;

    // ── CSS động cho tính năng page & drag-drop ──────────────────────────────
    const pageStyles = `
    <style>
      /* Khu vực thêm page */
      #page-section { margin-top: 16px; }
      /* === NÚT THÊM PAGE === */
      #add-page-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        border: 2px dashed #5b5fc7;
        background: none;
        color: #5b5fc7;
        border-radius: 10px;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        width: 100%;
        justify-content: center;
        transition: background 0.15s;
        margin-top: 8px;
      }
      #add-page-btn:hover { background: #f0eeff; }

      /* Khung page */
      .page-box {
        border: 2px solid #e0daf7; border-radius: 12px;
        padding: 14px 16px; margin-top: 14px; background: #faf9ff;
        position: relative;
      }
      .page-box-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 10px;
      }
      .page-box-title {
        font-weight: 700; font-size: 13px; color: #5b4fcf;
      }
      .page-box-id {
        font-size: 11px; color: #999; margin-left: 8px;
      }
      .page-drop-zone {
        min-height: 70px; border: 2px dashed #c5bee8; border-radius: 8px;
        padding: 10px; display: flex; flex-wrap: wrap; gap: 8px;
        background: #fff; transition: background .2s;
      }
      .page-drop-zone.dragover { background: #ede9ff; border-color: #7c6fcd; }

      /* Tag danh mục bên trong page */
      .page-cat-tag {
        display: inline-flex; align-items: center; gap: 6px;
        background: #5f5c5c; color: #fff; border-radius: 8px;
        padding: 4px 12px; font-size: 18px; font-weight: 600;
        user-select: none;
      }
      .page-cat-tag .remove-tag {
        cursor: pointer; font-size: 14px; line-height: 1;
        opacity: .8; transition: opacity .15s;
      }
      .page-cat-tag .remove-tag:hover { opacity: 1; }

      /* Card danh mục bị disabled (đã kéo vào page) */
      .category-card.is-dropped {
        opacity: .4; pointer-events: none; cursor: not-allowed;
      }
      .col-md-6[data-id].dragging { opacity: .4; }

      /* Nút xoá page */
      .btn-remove-page {
        background: none; border: none; color: #c0392b;
        cursor: pointer; font-size: 13px; padding: 0 4px;
      }
      .btn-remove-page:hover { color: #e74c3c; }
    </style>`;
    document.head.insertAdjacentHTML("beforeend", pageStyles);

    // ── Inject khu vực "Thêm page" vào sau #category_list ───────────────────
    const pageSection = document.createElement("div");
    pageSection.id = "page-section";
    pageSection.innerHTML = `
    <button type="button" id="add-page-btn">
      <i class="fas fa-plus"></i> Thêm trang (page)
    </button>
    <div id="page-list"></div>`;
    categoryList.insertAdjacentElement("afterend", pageSection);

    let pageCounter = 0; // đếm số page đã tạo

    // ── Thêm page mới ────────────────────────────────────────────────────────
    document.getElementById("add-page-btn").addEventListener("click", function () {
        pageCounter++;
        const pageId = pageCounter;
        const pageBox = document.createElement("div");
        pageBox.className = "page-box";
        pageBox.dataset.pageId = pageId;
        pageBox.innerHTML = `
      <div class="page-box-header">
        <span class="page-box-title">
          Trang ${pageCounter}
          <span class="page-box-id">#${pageId}</span>
        </span>
        <button type="button" class="btn-remove-page" title="Xoá page này">
          <i class="fas fa-times-circle"></i> Xoá trang
        </button>
      </div>
      <div class="page-drop-zone" data-page-id="${pageId}">
        <span class="drop-hint" style="color:#bbb;font-size:12px;align-self:center;">
          Kéo danh mục vào đây…
        </span>
      </div>`;
        document.getElementById("page-list").appendChild(pageBox);
        bindDropZone(pageBox.querySelector(".page-drop-zone"));
    });

    // ── Xoá page → trả danh mục về ──────────────────────────────────────────
    document.getElementById("page-list").addEventListener("click", function (e) {
        const removeBtn = e.target.closest(".btn-remove-page");
        if (!removeBtn) return;
        const box = removeBtn.closest(".page-box");
        // Trả lại tất cả card đang bị disabled trong page này
        box.querySelectorAll(".page-cat-tag").forEach(function (tag) {
            restoreCategoryCard(tag.dataset.catId);
        });
        box.remove();
    });

    // ── Kích hoạt drag trên mỗi card danh mục (dùng Event Delegation) ────────
    categoryList.addEventListener("dragstart", function (e) {
        const col = e.target.closest(".col-md-6[data-id]");
        if (!col) return;
        const card = col.querySelector(".category-card");
        if (card && card.classList.contains("is-dropped")) {
            e.preventDefault();
            return;
        }
        col.classList.add("dragging");
        e.dataTransfer.setData("text/plain", col.dataset.id);
        e.dataTransfer.effectAllowed = "move";
    });

    categoryList.addEventListener("dragend", function (e) {
        const col = e.target.closest(".col-md-6[data-id]");
        if (col) col.classList.remove("dragging");
    });

    // Đảm bảo các col có thể drag
    function enableDragOnCards() {
        categoryList.querySelectorAll(".col-md-6[data-id]").forEach(function (col) {
            col.setAttribute("draggable", "true");
        });
    }
    enableDragOnCards();

    // Quan sát DOM khi category mới được thêm (ajax) → tự gán draggable
    const observer = new MutationObserver(enableDragOnCards);
    observer.observe(categoryList, { childList: true, subtree: true });

    // ── Bind drag-over / drop vào drop-zone ──────────────────────────────────
    function bindDropZone(zone) {
        zone.addEventListener("dragover", function (e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = "move";
            zone.classList.add("dragover");
        });
        zone.addEventListener("dragleave", function () {
            zone.classList.remove("dragover");
        });
        zone.addEventListener("drop", function (e) {
            e.preventDefault();
            zone.classList.remove("dragover");

            const catId = e.dataTransfer.getData("text/plain");
            if (!catId) return;

            // Kiểm tra nếu danh mục đã có trong page này rồi thì bỏ qua
            if (zone.querySelector(`.page-cat-tag[data-cat-id="${catId}"]`)) return;

            const col = categoryList.querySelector(`.col-md-6[data-id="${catId}"]`);
            if (!col) return;
            const catName = col.querySelector("h6")?.textContent?.trim() || catId;

            // Ẩn gợi ý "kéo vào đây" nếu còn
            const hint = zone.querySelector(".drop-hint");
            if (hint) hint.remove();

            // Tạo tag trong drop-zone
            const tag = document.createElement("span");
            tag.className = "page-cat-tag";
            tag.dataset.catId = catId;
            tag.dataset.catName = catName;
            tag.innerHTML = `${catName} <span class="remove-tag" title="Xoá khỏi trang">&times;</span>`;
            zone.appendChild(tag);

            // Disable card gốc
            col.querySelector(".category-card")?.classList.add("is-dropped");

            // Xử lý nút X trên tag
            tag.querySelector(".remove-tag").addEventListener("click", function () {
                restoreCategoryCard(catId);
                tag.remove();
                // Nếu zone trống → hiển thị lại gợi ý
                if (!zone.querySelector(".page-cat-tag")) {
                    zone.insertAdjacentHTML(
                        "beforeend",
                        `<span class="drop-hint" style="color:#bbb;font-size:12px;align-self:center;">Kéo danh mục vào đây…</span>`,
                    );
                }
            });
        });
    }

    // ── Trả card về trạng thái bình thường ──────────────────────────────────
    function restoreCategoryCard(catId) {
        const col = categoryList.querySelector(`.col-md-6[data-id="${catId}"]`);
        if (col) {
            col.querySelector(".category-card")?.classList.remove("is-dropped");
        }
    }

    // ── Lấy danh mục từ tất cả các page (cho submit) ────────────────────────
    function getCategoriesFromPages() {
        const result = [];
        document.querySelectorAll("#page-list .page-box").forEach(function (box) {
            const pageId = box.dataset.pageId;
            box.querySelectorAll(".page-cat-tag").forEach(function (tag) {
                result.push({
                    id: tag.dataset.catId,
                    name: tag.dataset.catName,
                    pages: pageId,
                });
            });
        });
        return result;
    }
    // ──────────────────────────────────Update Page ───────────────────
    async function update_pages(payload) {
        try {
            // Lấy Token CSRF từ Blade template (nếu có dùng Laravel)
            const csrfToken = document.querySelector(
                'input[name="_token"]',
            )?.value;
            const response = await fetch(API_URL.update_pages, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ items: payload }),
            });
            if (response.ok) {
                return true
            } else {
                return false;
            }
        } catch (error) {
            return false
        } finally {            
            saveCategoryBtn.disabled = false;
            saveCategoryBtn.innerText = "Thêm mới";
        }
    }
    // ── Submit: lấy danh mục từ các page thay vì checkbox ───────────────────
    submitBtn.addEventListener("click", function (e) {
        e.preventDefault();
        const pageCategories = getCategoriesFromPages();
        update_pages(pageCategories);        
        // Đưa ra phạm vi toàn cục để các script khác dùng
        window.selectedCategories = pageCategories;
        // Gọi hàm render bước 3
        renderDetailsForm(pageCategories);

        if (typeof goToStep === "function") {
            goToStep(3);
        } else {
            const detailsForm = document.getElementById("detailsForm");
            if (detailsForm) {
                categoryForm.classList.remove("active");
                categoryForm.style.display = "none";
                detailsForm.classList.add("active");
                detailsForm.style.display = "block";
            }
        }
    });

    // Hàm tự động sinh các form-section dựa trên danh mục được chọn
    function renderDetailsForm(categories) {
        const container = document.getElementById("dynamic-categories-container");
        if (!container) return;

        container.innerHTML = "";
        // Chèn CSS trực tiếp để đảm bảo hiển thị đúng giao diện header
        const styleHtml = `
            <style>
                .slanted-bar {background: #000;color: #fff;font-weight: 700;padding: 10px 55px 10px 20px;display: inline-block;clip-path: polygon(0 0, calc(100% - 35px) 0, 100% 100%, 0 100%); border-top-left-radius: 8px;}
                .dot {height: 2px;background: linear-gradient(90deg, #000, transparent);}
            </style>`;
        container.insertAdjacentHTML("beforeend", styleHtml);

        // Duyệt qua từng danh mục người dùng đã chọn để sinh HTML
        categories.forEach((cat) => {
            // form-section mb-4
            const editorId = `editor-${cat.id}`;
            const sectionHtml = `<div class="mb-4" data-category-id="${cat.id}">
                <div class="slanted-bar" style="border-bottom: 1px solid #000;">${cat.name}</div>
                <div class="dot"></div>                
                <div class="my-4">                        
                    <textarea class="form-control experiences" name="category_details[${cat.id}]" rows="4" id="${editorId}" placeholder="Vui lòng nhập nội dung cho danh mục ${cat.name}..."></textarea>
                </div>
                </div>`;
            container.insertAdjacentHTML("beforeend", sectionHtml);

            // Khởi tạo CKEditor 5 cho textarea vừa render
            if (typeof ClassicEditor !== "undefined" || !ClassicEditor) {
                ClassicEditor.create(document.querySelector(`#${editorId}`), {
                    placeholder: `Vui lòng nhập nội dung cho danh mục ${cat.name}...`,
                })
                    .then((editor) => {
                        // Thiết lập chiều cao tối thiểu cho vùng soạn thảo (ví dụ 300px)
                        editor.editing.view.change((writer) => {
                            writer.setStyle(
                                "min-height",
                                "300px",
                                editor.editing.view.document.getRoot(),
                            );
                        });
                        // Lưu instance vào element để truy xuất dữ liệu khi submit
                        document.querySelector(`#${editorId}`).ckeditorInstance = editor;
                    })
                    .catch((error) => {
                        console.error("Có lỗi xảy ra khi khởi tạo CKEditor:", error);
                    });
            }
        });
    }
});
// ======================================================= Submit Form Details =========================================================================

document
    .getElementById("detailsForm")
    .addEventListener("submit", async function (event) {
        // Ngăn chặn hành động submit mặc định của form
        event.preventDefault();
        // 1. Lấy tất cả các section chứa dữ liệu danh mục
        const sections = document.querySelectorAll(
            "#dynamic-categories-container > div[data-category-id]",
        );
        let isValid = true;
        const requestDataList = [];

        // Lấy candidate_id từ sessionStorage
        const candidateId = sessionStorage.getItem("candidate_id");
        if (!candidateId) {
            alert("Không tìm thấy thông tin ứng viên. Vui lòng quay lại bước 1.");
            return;
        }
        // 2. Duyệt qua từng section để kiểm tra và lấy dữ liệu
        sections.forEach((section) => {
            const categoryId = section.getAttribute("data-category-id");
            const textarea = section.querySelector("textarea.experiences");

            // Lấy nội dung từ CKEditor instance nếu có, ngược lại lấy từ value gốc
            const content = textarea.ckeditorInstance
                ? textarea.ckeditorInstance.getData().trim()
                : textarea.value.trim();

            const categoryName = section
                .querySelector(".slanted-bar")
                .textContent.trim();

            // Kiểm tra nếu nội dung trống
            if (!content) {
                alert(`Vui lòng nhập nội dung cho danh mục: ${categoryName}`);
                if (textarea.ckeditorInstance) {
                    textarea.ckeditorInstance.editing.view.focus();
                } else {
                    textarea.focus();
                }
                isValid = false;
                // Không return ở đây để có thể validate tất cả các trường
            }

            // Nếu hợp lệ, push object vào danh sách chờ gửi API
            requestDataList.push({
                candidate_id: parseInt(candidateId),
                category_id: parseInt(categoryId),
                content: content,
            });
        });

        // Nếu có ít nhất 1 trường chưa nhập, dừng xử lý tiếp theo
        if (!isValid) return;

        // 3. Tiến hành gọi API bằng AJAX khi tất cả dữ liệu đã hợp lệ
        const submitBtn = this.querySelector(".btn-submit");

        try {
            // Thay đổi trạng thái nút submit sang loading
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<i class="fas fa-spinner fa-spin me-1"></i> Đang xử lý...';

            const apiUrl = API_URL.contents;

            // Tạo mảng chứa các request AJAX (mỗi $.ajax trả về một Deferred/Promise object)
            const apiRequests = requestDataList.map((data) => {
                return $.ajax({
                    url: apiUrl,
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(data),
                    // headers: { 'Authorization': 'Bearer ' + token } // Thêm nếu cần
                });
            });

            // Chờ tất cả các request AJAX hoàn thành (Tương đương Promise.all)
            await $.when.apply($, apiRequests);

            alert("Thêm mới thông tin chi tiết thành công!");

            setTimeout(function () {
                window.location.href = "/login"; // Thay đổi đường dẫn '/login' theo dự án của bạn
            }, 2000);
        } catch (error) {
            console.error("Error:", error);
            alert("Đã có lỗi xảy ra trong quá trình lưu dữ liệu. Vui lòng thử lại!");
        } finally {
            // Khôi phục lại trạng thái nút submit
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check-circle me-1"></i> Kết thúc';
        }
    });