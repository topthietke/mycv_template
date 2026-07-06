<form id="categoryForm" class="step-form" data-user-id="{{ $candidate['id'] }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <h6 class="fw-bold">Quản lý danh mục và nội dung</h6>
        </div>
        <div class="col-lg-6 col-md-6 text-end">
            <a href="#" data-bs-toggle="modal" data-bs-target="#editCategoriesModal">
                <i class="fa fa-plus-circle mr-2 text-primary fa-lg"></i>
            </a>
        </div>
    </div>
    <div class="dot my-2"></div>

    {{-- ====================================== Tiêu đề + icon thêm danh muc ======================================= --}}

    <div class="row mt-2 form-editor">
        @foreach ($categories as $cat)
            <div class="mb-4" data-category-id="{{ $cat['id'] }}">
                <div class="edit_slanted_bar" style="border-bottom: 1px solid #000;">{{ $cat['name'] }}</div>
                <div class="edit_dot"></div>
                <div class="my-4">
                    <textarea class="form-control experiences" name="category_details[${cat.id}]" rows="4" id="${editorId}" placeholder="Vui lòng nhập nội dung cho danh mục ${cat.name}..."></textarea>
                </div>
            </div>
        @endforeach
        <div id="category_list" class="col-md-4 text-center m-0 mt-2"></div>
    </div>

    <div class="dot mb-3 mt-0 pt-0"></div>
    <div class="row mt-3">
        <div class="col-lg-12 d-flex justify-content-end">
            <x-button type="submit" class="btn btn-next" id="category_form_submit" data-step="3">
                Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
            </x-button>
        </div>
    </div>
</form>

<script>
/**
 * ============================================================
 *  KHỞI TẠO CKEDITOR 4 VỚI ĐẦY ĐỦ CHỨC NĂNG
 * ============================================================
 * - Tự động tìm textarea bên trong class ".form-editor"
 * - Cấu hình full toolbar (định dạng chữ, bảng, ảnh, link,
 *   source code, tìm kiếm & thay thế, bảng, chèn media...)
 * - Upload ảnh (adapter đơn giản, bạn thay endpoint thật của bạn)
 * ============================================================
 */

(function () {
    // 1. Tìm phần tử textarea nằm trong .form-editor
    var wrapper = document.querySelector('.form-editor');
    if (!wrapper) {
        console.warn('Không tìm thấy .form-editor');
        return;
    }

    var textarea = wrapper.querySelector('textarea');
    if (!textarea) {
        console.warn('Không tìm thấy textarea bên trong .form-editor');
        return;
    }

    // Nếu textarea chưa có id, tự gán id để CKEditor replace được
    if (!textarea.id) {
        textarea.id = 'editor_' + Math.random().toString(36).substr(2, 9);
    }

    // 2. Cấu hình toolbar đầy đủ (Full toolbar giống bản Word)
    var fullToolbar = [
        { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
        { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
        { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
        '/',
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
        { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
        { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
        '/',
        { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
        { name: 'colors', items: ['TextColor', 'BGColor'] },
        { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
        { name: 'about', items: ['About'] }
    ];

    // 3. Khởi tạo CKEditor 4
    CKEDITOR.replace(textarea.id, {
        toolbar: fullToolbar,
        height: 400,
        language: 'vi',
        // "exportpdf" không dùng tới nên loại bỏ để tránh cảnh báo
        // "exportpdf-no-token-url". elementspath ẩn cho gọn giao diện.
        removePlugins: 'elementspath,exportpdf',

        // Tắt banner đỏ + cảnh báo console "This CKEditor x.x version is not secure"
        versionCheck: false,

        // "uploadimage" thực ra ĐÃ có sẵn trong gói full (không cần tải thêm
        // như image2 trước đó) — chỉ cần khai báo uploadUrl bên dưới là
        // dùng được tính năng dán ảnh từ clipboard (Ctrl+V) trực tiếp vào editor.
        extraPlugins: 'justify,font,colorbutton,uploadimage',

        // Cấu hình upload ảnh (thay endpoint bằng API upload thật của bạn,
        // API cần trả JSON dạng { "uploaded": 1, "fileName": "...", "url": "..." })
        filebrowserUploadUrl: '/upload-image',       // dùng cho dialog "Image" (Insert Image)
        filebrowserImageUploadUrl: '/upload-image',  // dùng cho dialog "Image"
        uploadUrl: '/upload-image',                  // dùng cho paste ảnh từ clipboard (plugin uploadimage)

        // Cấu hình font chữ
        font_names: 'Arial/Arial, Helvetica, sans-serif;' +
            'Times New Roman/Times New Roman, Times, serif;' +
            'Verdana;' +
            'Courier New/Courier New, Courier, monospace;',

        // Cấu hình cỡ chữ
        fontSize_sizes: '10/10px;12/12px;14/14px;16/16px;18/18px;24/24px;36/36px;',

        // Bỏ quảng cáo/logo CKEditor ở footer (nếu bản có)
        removeButtons: '',

        // Cho phép resize khung soạn thảo
        resize_enabled: true
    });

    // 4. Ví dụ lấy / set nội dung
    document.getElementById('btnGetContent').addEventListener('click', function () {
        var instance = CKEDITOR.instances[textarea.id];
        var html = instance.getData();
        document.getElementById('output').textContent = html;
        console.log(html);
    });

    document.getElementById('btnSetContent').addEventListener('click', function () {
        var instance = CKEDITOR.instances[textarea.id];
        instance.setData('<p><strong>Xin chào!</strong> Đây là nội dung mẫu được set từ JavaScript.</p>');
    });

    // 5. Đồng bộ nội dung vào textarea gốc trước khi submit form (quan trọng khi dùng AJAX/FormData)
    var form = wrapper.closest('form');
    if (form) {
        form.addEventListener('submit', function () {
            for (var name in CKEDITOR.instances) {
                CKEDITOR.instances[name].updateElement();
            }
        });
    }
})();

</script>
