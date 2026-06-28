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
        const csrfToken = categoriesForm.querySelector(
            'input[name="_token"]',
        )?.value;
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
                if (checkedCategories.length === 0) {
                    alert("Vui lòng chọn ít nhất một danh mục trước khi tiếp tục!");
                    return;
                }

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

// ============================================================= Next Bước 3 ================================================
document.addEventListener("DOMContentLoaded", function () {
    const categoryForm = document.getElementById("categoryForm");
    const categoryList = document.getElementById("category_list");
    const submitBtn = document.getElementById("category_form_submit");

    if (!categoryForm || !categoryList || !submitBtn) return;

    // ============================================================
    // PHÂN TRANG (PAGE SYSTEM) - Kéo thả danh mục vào page
    // ============================================================

    // Inject CSS cho hệ thống page và drag-drop
    const pageCss = `
    <style>
      /* === PAGE SYSTEM STYLES === */
      #pages-container {
        margin-top: 20px;
      }
      .cv-page-block {
        border: 2px dashed #c7c9f0;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
        background: #f8f9ff;
        position: relative;
        min-height: 80px;
        transition: border-color 0.2s, background 0.2s;
      }
      .cv-page-block.drag-over {
        border-color: #5b5fc7;
        background: #eef0ff;
      }
      .cv-page-block .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
      }
      .cv-page-block .page-title {
        font-weight: 700;
        color: #5b5fc7;
        font-size: 14px;
      }
      .cv-page-block .page-drop-hint {
        color: #aaa;
        font-size: 13px;
        text-align: center;
        padding: 10px 0 4px;
      }
      .cv-page-block .page-categories {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        min-height: 36px;
      }
      .page-category-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #5b5fc7;
        color: #fff;
        border-radius: 20px;
        padding: 4px 12px 4px 10px;
        font-size: 13px;
        font-weight: 500;
        animation: fadeIn 0.2s ease;
      }
      .page-category-tag .remove-tag-btn {
        background: none;
        border: none;
        color: #fff;
        cursor: pointer;
        font-size: 15px;
        line-height: 1;
        padding: 0;
        opacity: 0.8;
        transition: opacity 0.15s;
      }
      .page-category-tag .remove-tag-btn:hover { opacity: 1; }
      @keyframes fadeIn { from { opacity: 0; transform: scale(0.85); } to { opacity: 1; transform: scale(1); } }

      /* === DANH MỤC DRAGGABLE === */
      .category-card[draggable="true"] {
        cursor: grab;
        transition: opacity 0.2s, box-shadow 0.2s;
      }
      .category-card[draggable="true"]:active { cursor: grabbing; }
      .category-card.dragging {
        opacity: 0.45;
        box-shadow: 0 4px 16px rgba(91,95,199,0.25);
      }
      .category-card.disabled-card {
        opacity: 0.4;
        pointer-events: none;
        filter: grayscale(0.6);
      }

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
      #add-page-btn:hover { background: #eef0ff; }
    </style>
  `;
    document.head.insertAdjacentHTML("beforeend", pageCss);

    // Tìm vị trí chèn nút Add Page (sau category_list hoặc trong categoryForm)
    // Tạo wrapper pages container ngay sau category_list
    let pagesWrapper = document.getElementById("pages-wrapper");
    if (!pagesWrapper) {
        pagesWrapper = document.createElement("div");
        pagesWrapper.id = "pages-wrapper";
        pagesWrapper.innerHTML = `
      <div id="pages-container"></div>
      <button type="button" id="add-page-btn">
        <i class="fas fa-plus"></i> Thêm trang
      </button>
    `;
        // Chèn sau categoryList
        categoryList.parentNode.insertBefore(pagesWrapper, categoryList.nextSibling);
    }

    const pagesContainer = document.getElementById("pages-container");
    const addPageBtn = document.getElementById("add-page-btn");

    let pageCount = 0;
    let draggedCategoryId = null;

    // ---- Hàm tạo một page block mới ----
    function createPage() {
        pageCount++;
        const pageId = `cv-page-${pageCount}`;
        const pageBlock = document.createElement("div");
        pageBlock.className = "cv-page-block";
        pageBlock.id = pageId;
        pageBlock.setAttribute("data-page-id", pageId);
        pageBlock.innerHTML = `
      <div class="page-header">
        <span class="page-title"><i class="fas fa-file-alt me-1"></i> Trang ${pageCount}</span>
        <button type="button" class="btn btn-sm btn-outline-danger remove-page-btn" title="Xóa trang">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="page-drop-hint">Kéo thả danh mục vào đây</div>
      <div class="page-categories" data-page-ref="${pageId}"></div>
    `;

        // Sự kiện xóa page: trả lại tất cả danh mục trong page
        pageBlock.querySelector(".remove-page-btn").addEventListener("click", function () {
            const tags = pageBlock.querySelectorAll(".page-category-tag");
            tags.forEach((tag) => {
                const catId = tag.getAttribute("data-cat-id");
                enableCategoryCard(catId);
            });
            pageBlock.remove();
        });

        // Drag-over events cho drop zone
        pageBlock.addEventListener("dragover", function (e) {
            e.preventDefault();
            pageBlock.classList.add("drag-over");
        });
        pageBlock.addEventListener("dragleave", function () {
            pageBlock.classList.remove("drag-over");
        });
        pageBlock.addEventListener("drop", function (e) {
            e.preventDefault();
            pageBlock.classList.remove("drag-over");
            if (!draggedCategoryId) return;

            // Kiểm tra xem danh mục đã có trong page này chưa
            const existing = pageBlock.querySelector(
                `.page-category-tag[data-cat-id="${draggedCategoryId}"]`
            );
            if (existing) return;

            // Lấy tên danh mục
            const catCard = document.querySelector(
                `#category_list [data-id="${draggedCategoryId}"]`
            );
            const catName = catCard
                ? catCard.querySelector("h6")?.textContent?.trim()
                : draggedCategoryId;

            // Tạo tag danh mục trong page
            addCategoryTagToPage(pageBlock, draggedCategoryId, catName);

            // Vô hiệu hóa card gốc
            disableCategoryCard(draggedCategoryId);

            draggedCategoryId = null;
        });

        pagesContainer.appendChild(pageBlock);
    }

    // ---- Thêm tag danh mục vào page ----
    function addCategoryTagToPage(pageBlock, catId, catName) {
        const hint = pageBlock.querySelector(".page-drop-hint");
        if (hint) hint.style.display = "none";

        const categoriesDiv = pageBlock.querySelector(".page-categories");
        const tag = document.createElement("span");
        tag.className = "page-category-tag";
        tag.setAttribute("data-cat-id", catId);
        tag.innerHTML = `
      <i class="fas fa-bullseye" style="font-size:12px;opacity:0.8"></i>
      ${catName}
      <button type="button" class="remove-tag-btn" title="Xóa khỏi trang">×</button>
    `;

        // Nút X xóa tag khỏi page → trả lại card
        tag.querySelector(".remove-tag-btn").addEventListener("click", function () {
            enableCategoryCard(catId);
            tag.remove();
            // Nếu page không còn tag nào → hiện lại hint
            if (categoriesDiv.querySelectorAll(".page-category-tag").length === 0) {
                if (hint) hint.style.display = "";
            }
        });

        categoriesDiv.appendChild(tag);
    }

    // ---- Vô hiệu hóa card danh mục (đã kéo vào page) ----
    function disableCategoryCard(catId) {
        const colDiv = document.querySelector(`#category_list [data-id="${catId}"]`);
        if (!colDiv) return;
        const card = colDiv.querySelector(".category-card");
        if (card) {
            card.classList.add("disabled-card");
            card.removeAttribute("draggable");
            // Bỏ check nếu đang checked
            const checkbox = colDiv.querySelector('input[type="checkbox"]');
            if (checkbox) checkbox.checked = false;
        }
    }

    // ---- Kích hoạt lại card danh mục (khi xóa khỏi page) ----
    function enableCategoryCard(catId) {
        const colDiv = document.querySelector(`#category_list [data-id="${catId}"]`);
        if (!colDiv) return;
        const card = colDiv.querySelector(".category-card");
        if (card) {
            card.classList.remove("disabled-card");
            card.setAttribute("draggable", "true");
        }
    }

    // ---- Kích hoạt drag trên các card hiện có và card được thêm mới ----
    function activateDraggable(cardContainer) {
        const cards = cardContainer.querySelectorAll(
            '[data-id] .category-card:not(.disabled-card)'
        );
        cards.forEach((card) => {
            if (!card.getAttribute("draggable")) {
                card.setAttribute("draggable", "true");
            }
            // Tránh gán event nhiều lần
            if (!card._dragBound) {
                card._dragBound = true;
                card.addEventListener("dragstart", function (e) {
                    const colDiv = card.closest("[data-id]");
                    draggedCategoryId = colDiv ? colDiv.getAttribute("data-id") : null;
                    card.classList.add("dragging");
                    e.dataTransfer.effectAllowed = "move";
                });
                card.addEventListener("dragend", function () {
                    card.classList.remove("dragging");
                });
            }
        });
    }

    // Kích hoạt drag cho các card ban đầu
    activateDraggable(categoryList);

    // Observer để tự động kích hoạt drag khi thêm card mới qua Ajax
    const listObserver = new MutationObserver(function () {
        activateDraggable(categoryList);
    });
    listObserver.observe(categoryList, { childList: true, subtree: true });

    // Nút thêm page
    addPageBtn.addEventListener("click", function () {
        createPage();
    });

    // ============================================================
    // CÁC SỰ KIỆN GỐC: Click chọn card, submit, ...
    // ============================================================

    // 1. Dùng Event Delegation để lắng nghe khi click vào các card
    categoryList.addEventListener("click", function (e) {
        const card = e.target.closest(".category-card");
        if (card && !card.classList.contains("disabled-card")) {
            setTimeout(() => {
                updateSubmitButton();
                syncSelectedCategoriesToDetailsForm();
            }, 50);
        }
    });

    // Hàm cập nhật trạng thái disable/enable của nút "Tiếp theo"
    function updateSubmitButton() {
        const anyChecked =
            categoryList.querySelectorAll('input[name="categories[]"]:checked')
                .length > 0;
        submitBtn.disabled = !anyChecked;
    }

    // Hàm đồng bộ dữ liệu ID và Name sang form Bước 3 (detailsForm) dưới dạng hidden input
    function syncSelectedCategoriesToDetailsForm() {
        const detailsForm = document.getElementById("detailsForm");
        if (!detailsForm) return;

        // Xóa các hidden input cũ đã đồng bộ trước đó để tránh trùng lặp
        detailsForm
            .querySelectorAll(".synced-category")
            .forEach((el) => el.remove());

        // Lấy tất cả các checkbox đang được check
        const checkedBoxes = categoryList.querySelectorAll(
            'input[name="categories[]"]:checked',
        );

        checkedBoxes.forEach(function (checkbox) {
            const colDiv = checkbox.closest("[data-id]");
            const categoryId = colDiv
                ? colDiv.getAttribute("data-id")
                : checkbox.value;
            const categoryName = colDiv
                ? colDiv.querySelector("h6")?.textContent?.trim()
                : "";

            // Tạo Hidden input cho ID
            const inputId = document.createElement("input");
            inputId.type = "hidden";
            inputId.name = "category_ids[]";
            inputId.value = categoryId;
            inputId.classList.add("synced-category");

            // Tạo Hidden input cho Name
            const inputName = document.createElement("input");
            inputName.type = "hidden";
            inputName.name = "category_names[]";
            inputName.value = categoryName;
            inputName.classList.add("synced-category");

            // Đẩy vào detailsForm
            detailsForm.appendChild(inputId);
            detailsForm.appendChild(inputName);
        });
    }

    // 2. Xử lý sự kiện click vào nút "Tiếp theo" (id="category_form_submit")
    submitBtn.addEventListener("click", function (e) {
        e.preventDefault();

        // Kiểm tra xem đã chọn ít nhất 1 danh mục chưa
        const checkedBoxes = categoryList.querySelectorAll(
            'input[name="categories[]"]:checked',
        );
        if (checkedBoxes.length === 0) {
            alert("Vui lòng chọn ít nhất một danh mục trước khi tiếp tục!");
            return;
        }

        // Đưa biến ra phạm vi toàn cục (window) để file/script khác có thể sử dụng
        window.selectedCategories = [];
        checkedBoxes.forEach((checkbox) => {
            const colDiv = checkbox.closest("[data-id]");
            window.selectedCategories.push({
                id: colDiv ? colDiv.getAttribute("data-id") : checkbox.value,
                name: colDiv ? colDiv.querySelector("h6")?.textContent?.trim() : "",
            });
        });

        // Gọi hàm hiển thị giao diện động ở Bước 3
        renderDetailsForm(window.selectedCategories);

        // Chuyển sang Bước 3: Gọi hàm goToStep(3) có sẵn của bạn để đồng bộ giao diện / progress line
        if (typeof goToStep === "function") {
            goToStep(3);
        } else {
            // Backend dự phòng nếu không tìm thấy hàm goToStep
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