<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản ứng viên</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .step-line { transition: all 0.3s ease; }
        .step-circle { transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl p-8 relative">
        
        <a href="#" class="text-blue-500 hover:underline text-sm font-medium inline-flex items-center gap-1 mb-6">
            <i class="fa-solid fa-arrow-left text-xs"></i> Đăng nhập
        </a>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Đăng ký tài khoản</h2>

        <div class="flex items-center justify-between w-full max-w-xl mx-auto mb-10 relative">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-gray-200 w-full z-0"></div>
            <div id="progress-line" class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-indigo-600 w-0 z-0 step-line"></div>
            <div class="z-10 text-center w-32">
                <div id="circle-1" class="w-10 h-10 mx-auto rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold step-circle shadow-md">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span id="text-1" class="text-xs font-semibold text-indigo-600 mt-2 block">Thông tin cá nhân</span>
            </div>

            <div class="z-10 text-center w-32">
                <div id="circle-2" class="w-10 h-10 mx-auto rounded-full bg-white border-2 border-gray-300 text-gray-500 flex items-center justify-center font-semibold step-circle">
                    <i class="fa-solid fa-list-ul"></i>
                </div>
                <span id="text-2" class="text-xs font-medium text-gray-400 mt-2 block">Chọn danh mục</span>
            </div>

            <div class="z-10 text-center w-32">
                <div id="circle-3" class="w-10 h-10 mx-auto rounded-full bg-white border-2 border-gray-300 text-gray-500 flex items-center justify-center font-semibold step-circle">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <span id="text-3" class="text-xs font-medium text-gray-400 mt-2 block">Nhập nội dung</span>
            </div>
        </div>

        <form id="multiStepForm" enctype="multipart/form-data">
            @csrf

            <div id="step-1-content" class="step-content">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Bước 1: Thông tin cá nhân</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Họ và tên <span class="text-red-500">*</span></label>
                        <input type="text" name="fullname" required placeholder="Nhập họ và tên" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Vị trí ứng tuyển <span class="text-red-500">*</span></label>
                        <input type="text" name="position" required placeholder="Nhập vị trí ứng tuyển" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ngày sinh <span class="text-red-500">*</span></label>
                        <input type="date" name="birthday" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Giới tính <span class="text-red-500">*</span></label>
                        <select name="gender" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                            <option value="">__ Chọn __</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required placeholder="Nhập email" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Số điện thoại <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" required placeholder="Nhập số điện thoại" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Số CMND/CCCD</label>
                        <input type="text" name="identity_card" placeholder="Nhập số CMND/CCCD" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ngày cấp</label>
                        <input type="date" name="identity_date" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nơi cấp</label>
                        <input type="text" name="identity_place" placeholder="Nhập nơi cấp" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Quê quán</label>
                        <input type="text" name="home_town" placeholder="Nhập quê quán" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Địa chỉ hiện tại</label>
                        <input type="text" name="current_address" placeholder="Nơi ở hiện tại" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Mức lương mong muốn (VNĐ)</label>
                        <input type="number" name="expected_salary" placeholder="Nhập Mức lương mong muốn" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ảnh đại diện</label>
                        <input type="file" name="avatar" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ảnh đại diện (Facebook)</label>
                        <input type="url" name="facebook_url" placeholder="Nhập địa chỉ Facebook" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Địa chỉ Git</label>
                        <input type="url" name="git_url" placeholder="Nhập địa chỉ Git" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Địa chỉ Website</label>
                        <input type="url" name="website_url" placeholder="Nhập địa chỉ Website" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="button" onclick="nextStep(2)" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg inline-flex items-center gap-2 transition shadow-md">
                        Tiếp theo <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </div>

            <div id="step-2-content" class="step-content hidden">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-bold text-gray-700">Bước 2: Đăng ký danh mục của cá nhân</h3>
                    <button type="button" onclick="toggleAddCategoryModal(true)" class="border border-blue-500 text-blue-500 hover:bg-blue-50 p-2 rounded-lg flex items-center justify-center transition">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mb-6">Chọn những mục bạn muốn thêm thông tin vào hồ sơ ứng viên của mình.</p>

                <div id="category-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if (!empty($categories))
                        @foreach($categories as $cat)
                        <label class="border-2 border-gray-200 rounded-xl p-4 flex items-start gap-4 cursor-pointer hover:border-indigo-300 transition select-none relative group" id="cat-card-{{ $cat->id }}">
                            <input type="checkbox" name="selected_categories[]" value="{{ $cat->id }}" data-name="{{ $cat->name }}" data-code="{{ $cat->code }}" class="hidden peer" onchange="toggleCategorySelect({{ $cat->id }})">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center text-lg shrink-0 peer-checked:bg-indigo-50 peer-checked:text-indigo-600">
                                <i class="fa-solid fa-circle-dot"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700 text-sm peer-checked:text-indigo-600">{{ $cat->name }}</h4>
                                <p class="text-xs text-gray-400 mt-0.5">Bấm chọn để kích hoạt nhập nội dung chi tiết</p>
                            </div>
                            <div class="absolute right-4 top-4 text-indigo-600 opacity-0 peer-checked:opacity-100 transition">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </label>
                        @endforeach                        
                    @endif
                </div>

                <div class="mt-8 flex justify-between">
                    <button type="button" onclick="nextStep(1)" class="border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium px-6 py-2.5 rounded-lg transition">Quay lại</button>
                    <button type="button" onclick="generateStep3Fields()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg inline-flex items-center gap-2 transition shadow-md">
                        Tiếp theo <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </div>

            <div id="step-3-content" class="step-content hidden">
                <h3 class="text-lg font-bold text-gray-700 mb-1">Bước 3: Nhập thông tin chi tiết</h3>
                <p class="text-xs text-gray-500 mb-6">Vui lòng hoàn thiện nội dung cho các phần danh mục bạn vừa lựa chọn.</p>

                <div id="dynamic-fields-container" class="space-y-6"></div>

                <div class="mt-8 flex justify-between">
                    <button type="button" onclick="nextStep(2)" class="border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium px-6 py-2.5 rounded-lg transition">Quay lại</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg inline-flex items-center gap-2 transition shadow-md">
                        <i class="fa-solid fa-circle-check"></i> Hoàn thành & Gửi
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="addCategoryModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 animate-fade-in">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Thêm mới danh mục hồ sơ</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tên danh mục <span class="text-red-500">*</span></label>
                    <input type="text" id="new_cat_name" placeholder="VD: Chứng chỉ ngoại ngữ, Giải thưởng..." class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="toggleAddCategoryModal(false)" class="px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 rounded-lg">Hủy</button>
                <button type="button" onclick="addNewCategoryAction()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">Thêm mới</button>
            </div>
        </div>
    </div>

    <script>
        // Điều hướng ẩn hiện các Bước (Steps)
        function nextStep(step) {
            // Ẩn tất cả các form nội dung
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            // Hiện form nội dung của bước hiện tại
            document.getElementById(`step-${step}-content`).classList.remove('hidden');

            // Cập nhật thanh trạng thái (Progress Bar UI)
            const progressLine = document.getElementById('progress-line');
            if (step === 1) progressLine.style.width = '0%';
            if (step === 2) progressLine.style.width = '50%';
            if (step === 3) progressLine.style.width = '100%';

            for (let i = 1; i <= 3; i++) {
                const circle = document.getElementById(`circle-${i}`);
                const text = document.getElementById(`text-${i}`);
                if (i <= step) {
                    circle.classList.remove('bg-white', 'border-gray-300', 'text-gray-500');
                    circle.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                    text.classList.add('text-indigo-600', 'font-semibold');
                    text.classList.remove('text-gray-400', 'font-medium');
                } else {
                    circle.classList.add('bg-white', 'border-gray-300', 'text-gray-500');
                    circle.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                    text.classList.remove('text-indigo-600', 'font-semibold');
                    text.classList.add('text-gray-400', 'font-medium');
                }
            }
        }

        // Bước 2: Hiệu ứng chọn danh mục (Đổi màu viền khi click check)
        function toggleCategorySelect(id) {
            const card = document.getElementById(`cat-card-${id}`);
            const checkbox = card.querySelector('input[type="checkbox"]');
            if (checkbox.checked) {
                card.classList.remove('border-gray-200');
                card.classList.add('border-indigo-600', 'bg-indigo-50/20');
            } else {
                card.classList.remove('border-indigo-600', 'bg-indigo-50/20');
                card.classList.add('border-gray-200');
            }
        }

        // Bước 2: Ẩn/Hiện Popup thêm mới danh mục nhanh
        function toggleAddCategoryModal(show) {
            const modal = document.getElementById('addCategoryModal');
            if (show) modal.classList.remove('hidden');
            else modal.classList.add('hidden');
        }

        // Bước 2: Thực hiện gọi thêm mới danh mục và hiển thị ra màn hình lập tức
        let dynamicCatIdCounter = 1000; // Khởi tạo id tạm thời cho danh mục thêm mới
        function addNewCategoryAction() {
            const nameInput = document.getElementById('new_cat_name');
            const name = nameInput.value.trim();
            
            if (!name) {
                alert('Vui lòng nhập tên danh mục!');
                return;
            }

            dynamicCatIdCounter++;
            const grid = document.getElementById('category-grid');
            
            // Chuỗi HTML cấu trúc thẻ danh mục mới giống hệt như ảnh thiết kế mẫu
            const newCardHtml = `
                <label class="border-2 border-gray-200 rounded-xl p-4 flex items-start gap-4 cursor-pointer hover:border-indigo-300 transition select-none relative group" id="cat-card-${dynamicCatIdCounter}">
                    <input type="checkbox" name="selected_categories[]" value="${dynamicCatIdCounter}" data-name="${name}" class="hidden peer" onchange="toggleCategorySelect(${dynamicCatIdCounter})">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center text-lg shrink-0 peer-checked:bg-indigo-50 peer-checked:text-indigo-600">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-700 text-sm peer-checked:text-indigo-600">${name}</h4>
                        <p class="text-xs text-gray-400 mt-0.5">Bấm chọn để kích hoạt nhập nội dung chi tiết</p>
                    </div>
                    <div class="absolute right-4 top-4 text-indigo-600 opacity-0 peer-checked:opacity-100 transition">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </label>
            `;
            
            grid.insertAdjacentHTML('beforeend', newCardHtml);
            nameInput.value = ''; // Xóa sạch dữ liệu ô input vừa nhập
            toggleAddCategoryModal(false); // Đóng modal popup
        }

        // Bước 3: Đọc các danh mục đã tích chọn ở Bước 2 để tự động sinh Form nhập văn bản
        function generateStep3Fields() {
            const checkboxes = document.querySelectorAll('input[name="selected_categories[]"]:checked');
            const container = document.getElementById('dynamic-fields-container');
            container.innerHTML = ''; // Làm rỗng trước khi dựng lại

            if (checkboxes.length === 0) {
                alert('Vui lòng chọn ít nhất 1 danh mục ở Bước 2 để tiếp tục!');
                return;
            }

            checkboxes.forEach((cb, index) => {
                const catId = cb.value;
                const catName = cb.getAttribute('data-name');
                
                // Thiết lập văn bản gợi ý mẫu (Placeholder) theo ảnh yêu cầu
                let placeholderText = `Nhập thông tin chi tiết cho ${catName}...`;
                if(catName.includes("Mục tiêu")) placeholderText = "VD: Trở thành chuyên gia phát triển hệ thống lớn, tối ưu hóa database, nâng cấp cấu trúc mã nguồn Laravel tinh gọn...";
                if(catName.includes("Kỹ năng")) placeholderText = "VD: PHP, Laravel, VueJS, OOP, Git, DBeaver, Postman";

                const fieldHtml = `
                    <div class="bg-gray-50/60 border border-gray-200 rounded-xl p-5">
                        <label class="block text-sm font-bold text-blue-600 mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-circle-notch text-xs animate-spin text-blue-400"></i> ${catName} <span class="text-red-500">*</span>
                        </label>
                        <input type="hidden" name="contents[${index}][category_id]" value="${catId}">
                        <textarea name="contents[${index}][content]" rows="3" required placeholder="${placeholderText}" 
                            class="w-full border border-gray-300 rounded-lg p-3 outline-none focus:ring-2 focus:ring-indigo-500 bg-white text-sm text-gray-700 shadow-inner"></textarea>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', fieldHtml);
            });

            nextStep(3); // Chuyển sang Bước 3 sau khi dựng xong giao diện động
        }

        // SUBMIT FORM TỔNG HỢP GỬI LÊN SERVER LARAVEL
        document.getElementById('multiStepForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);

            // Gửi dữ liệu bằng Fetch API lên API Laravel
            fetch('/api/candidate', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    alert(res.message);
                    window.location.reload(); // Đăng ký thành công reset lại trang hoặc chuyển trang cảm ơn
                } else {
                    alert('Lỗi dữ liệu đầu vào: ' + JSON.stringify(res.errors));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Đã xảy ra lỗi nghiêm trọng trong hệ thống!');
            });
        });
    </script>
</body>
</html>