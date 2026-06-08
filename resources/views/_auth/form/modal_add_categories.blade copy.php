<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Thêm danh mục mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <form id="categories_form" method="POST">
                    @csrf
                    <div id="category_fields">
                        <div class="category-field-group mb-3 d-flex align-items-end gap-2">
                            <div class="flex-grow-1">
                                <x-input name="categories_name[]" type="text" label="Tên danh mục"
                                    placeholder="Nhập tên danh mục" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 text-center">
                            <button type="button" class="btn btn-outline-secondary w-100" id="addCategoryFieldBtn">
                                <i class="bi bi-plus bi-lg text-dark"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="add_new_categories()">Lưu lại</button>
            </div>
        </div>
    </div>
</div>

<script>
    import { API_URL } from "/assets/js/variableApi.js";
    import { msg_success, msg_error, ajax } from "/assets/js/function.js";

    document.getElementById('addCategoryFieldBtn').addEventListener('click', function () {
        alert(1111);
        const container = document.getElementById('category_fields');

        // Hiện nút xóa ở tất cả các row khi có hơn 1 row
        const newGroup = document.createElement('div');
        newGroup.className = 'category-field-group mb-3 d-flex align-items-end gap-2';
        newGroup.innerHTML = `
        <div class="flex-grow-1">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="categories_name[]" class="form-control" placeholder="Nhập tên danh mục"/>
        </div>
        <button type="button" class="btn btn-outline-danger btn-remove-field mb-1">
            <i class="bi bi-trash"></i>
        </button>`;
        container.appendChild(newGroup);

        // Hiện nút xóa ở row đầu tiên nếu có >= 2 row
        updateRemoveButtons();
    });

    document.getElementById('category_fields').addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove-field')) {
            e.target.closest('.category-field-group').remove();
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const groups = document.querySelectorAll('.category-field-group');
        groups.forEach(group => {
            const btn = group.querySelector('.btn-remove-field');
            if (groups.length > 1) {
                btn.classList.remove('d-none');
            } else {
                btn.classList.add('d-none');
            }
        });
    }

    function add_new_categories() {
        const categories = getCategoriesData();
        console.log(API_URL.addCategories);
        
        // const data = ajax(API_URL.addCategories, categories, 'POST');
        // console.log(data);        


        // // Hoặc gắn vào FormData để gửi AJAX
        // const formData = new FormData();
        // getCategoriesData().forEach(name => {
        //     formData.append('categories_name[]', name);
        // });
    }

    function getCategoriesData() {
        const inputs = document.querySelectorAll('input[name="categories_name[]"]');
        const categories = [];
        inputs.forEach((input, index) => {
            const value = input.value.trim();
            if (value !== '') {
                categories.push(value);
            }
        });
        return categories;
    }

</script>