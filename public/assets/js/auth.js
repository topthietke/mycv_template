import { API_URL } from "/assets/js/variableApi.js";
import { msg_success, msg_error, ajax } from "/assets/js/function.js";


$(document).ready(function () {
    // Lấy API host từ file .env thông qua Laravel helper

    function goToStep(step) {
        // Ẩn tất cả form
        $('.step-form').removeClass('active');

        // Xóa trạng thái active của indicator
        $('.step').removeClass('active completed');

        // Cập nhật giao diện thanh hiển thị (progress bar)
        if (step === 1) {
            $('#candidateForm').addClass('active');
            $('#indicator-1').addClass('active');
            $('#progress-line').css('width', '0%');
        } else if (step === 2) {
            $('#categoryForm').addClass('active');
            $('#indicator-1').addClass('completed');
            $('#indicator-2').addClass('active');
            $('#progress-line').css('width', '50%');
        } else if (step === 3) {
            $('#detailsForm').addClass('active');
            $('#indicator-1').addClass('completed');
            $('#indicator-2').addClass('completed');
            $('#indicator-3').addClass('active');
            $('#progress-line').css('width', '100%');
        }
    }


    $('#candidateForm').on('submit', function (e) {
        e.preventDefault();
        let isValid = true;
        // Reset error states
        $('.form-control, .form-select').removeClass('is-invalid');
        $('.error-message').hide();

        // Các trường bắt buộc theo design
        const requiredFields = ['fullname', 'position', 'birthday', 'gender', 'email', 'phone'];

        requiredFields.forEach(function (field) {
            let input = $(`[name="${field}"]`);
            let val = input.val().trim();

            if (val === '') {
                input.addClass('is-invalid');
                input.siblings('.error-message').show();
                isValid = false;
            }

            // Validate format email cơ bản
            if (field === 'email' && val !== '') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(val)) {
                    input.addClass('is-invalid');
                    input.siblings('.error-message').text('Email không đúng định dạng').show();
                    isValid = false;
                }
            }
        });

        if (!isValid) {
            return false; // Dừng lại nếu validate fail
        }

        // Đổi trạng thái button
        let $btn = $('#btnSubmit');
        let originalText = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);

        // Gom dữ liệu form (hỗ trợ cả file avatar)
        let formData = new FormData(this);
        $.ajax({
            url: API_URL.candidate,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (res) {
                if (res && res.success == true) {
                    alert(res.message || 'Thông tin đã được lưu thành công!');
                    goToStep(2); // Chuyển sang bước 2
                } else {
                    alert(res.message);
                    $btn.html(originalText).prop('disabled', false);
                    return false;
                }
            },
            error: function (xhr, status, error) {
                // ---------------------------------------------------------------
                let errorMessage = 'Thông tin đăng ký không hợp lệ';
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
                        errorMessage = errorMessagesArray.join('\n'); // Nối các lỗi bằng dấu xuống dòng
                    } else if (xhr.responseJSON.message) {
                        // Trường hợp không có errors chi tiết nhưng có message chung
                        errorMessage = xhr.responseJSON.message;
                    }
                }

                // ---------------------------------------------------------------
                // Hiển thị lỗi hoặc xử lý tiếp theo tùy thuộc vào logic của bạn
                alert(errorMessage);
                // Hoặc console.log(errorMessagesArray); nếu bạn muốn dùng mảng để map vào từng input
            }
        });

    });



    // Xóa thông báo lỗi khi người dùng bắt đầu nhập lại
    $('.form-control, .form-select').on('input change', function () {
        $(this).removeClass('is-invalid');
        $(this).siblings('.error-message').hide();
    });

});

// ========================================== Bổ sung thêm input danh mục ==========================================

document.addEventListener('DOMContentLoaded', function () {
    const categoryFields = document.getElementById('category_fields');
    const addBtn = document.getElementById('addCategoryFieldBtn');

    // Lắng nghe sự kiện click vào nút Thêm (+)
    addBtn.addEventListener('click', function () {
        // Tạo một div wrapper mới
        const newGroup = document.createElement('div');
        newGroup.className = 'category-field-group mb-3 d-flex align-items-end gap-2';

        // Đoạn HTML cấu trúc input thuần (thay cho x-input) và nút xóa
        newGroup.innerHTML = `
            <div class="flex-grow-1">
                <label class="form-label">Tên danh mục</label>
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
    categoryFields.addEventListener('click', function (e) {
        // Kiểm tra xem user có click vào nút xóa hoặc icon bên trong nút xóa không
        const removeBtn = e.target.closest('.remove-category-btn');

        if (removeBtn) {
            // Tìm đến group cha gần nhất và xóa nó
            const fieldGroup = removeBtn.closest('.category-field-group');
            fieldGroup.remove();
        }
    });
});

// ==============================================  Thêm mới danh mục ===============================================
document.addEventListener('DOMContentLoaded', function () {
    const categoryFields = document.getElementById('category_fields');    
    const saveCategoryBtn = document.getElementById('saveCategoryBtn');
    const categoriesForm = document.getElementById('categories_form');
    
    // Lấy instance của Bootstrap Modal để đóng sau khi lưu thành công
    const categoryModalEl = document.getElementById('categoryModal');
    const categoryModal = bootstrap.Modal.getOrCreateInstance(categoryModalEl); 

    // Chức năng xóa bớt ô nhập (Ủy quyền sự kiện - Event Delegation)
    categoryFields.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-category-btn') || e.target.closest('.remove-category-btn')) {
            const group = e.target.closest('.category-field-group');
            // Giữ lại ít nhất 1 ô nhập, không cho xóa hết sạch
            if (categoryFields.querySelectorAll('.category-field-group').length > 1) {
                group.remove();
            } else {
                alert('Phải giữ lại ít nhất một danh mục!');
            }
        }
    });

    // 2. Chức năng gửi API khi bấm nút "Thêm mới"
    saveCategoryBtn.addEventListener('click', async function () {
        // Thu thập tất cả các giá trị từ các input có name="categories_name[]"
        const inputs = categoriesForm.querySelectorAll('input[name="categories_name[]"]');
        const categories = Array.from(inputs).map(input => input.value.trim()).filter(val => val !== '');

        // Kiểm tra nếu người dùng chưa nhập gì
        if (categories.length === 0) {
            alert('Vui lòng nhập ít nhất một tên danh mục!');
            return;
        }

        // Lấy Token CSRF từ Blade template (nếu có dùng Laravel)
        const csrfToken = categoriesForm.querySelector('input[name="_token"]')?.value;
        // Chuẩn bị dữ liệu gửi đi (bọc trong object để API dễ xử lý)
        const payload = { name: categories };

        // Vô hiệu hóa nút bấm tránh gửi trùng lặp (Double click)
        saveCategoryBtn.disabled = true;
        saveCategoryBtn.innerText = 'Đang lưu...';

        try {
            const response = await fetch(API_URL.create_multiple_categories, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Thêm vào nếu API chung domain và bật CSRF
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (response.ok) {
                alert('Thêm danh mục thành công!');
                
                // Reset form và xóa các ô nhập extra
                categoriesForm.reset();
                categoryFields.innerHTML = `
                    <div class="category-field-group mb-3 d-flex align-items-end gap-2">
                        <div class="flex-grow-1">
                            <input name="categories_name[]" type="text" class="form-control" placeholder="Nhập tên danh mục" />
                        </div>
                    </div>
                `;

                // Ẩn modal sau khi lưu thành công
                categoryModal.hide();

                // Tùy chọn: Gọi hàm load lại danh sách danh mục ở trang chính (nếu có)
                // if (typeof loadCategories === 'function') loadCategories();
                
            } else {
                // Xử lý lỗi trả về từ API (Ví dụ: validate lỗi)
                alert('Có lỗi xảy ra: ' + (result.message || 'Vui lòng thử lại.'));
            }
        } catch (error) {
            console.error('Error post data:', error);
            alert('Không thể kết nối đến máy chủ API!');
        } finally {
            // Mở lại trạng thái nút bấm
            saveCategoryBtn.disabled = false;
            saveCategoryBtn.innerText = 'Thêm mới';
        }
    });
});