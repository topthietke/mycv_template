
(function () {
    // 1. Tìm tất cả các textarea cần khởi tạo CKEditor
    var wrapper = document.querySelector('.form-editor');
    if (!wrapper) {
        console.warn('Không tìm thấy .form-editor');
        return;
    }

    var textareas = wrapper.querySelectorAll('textarea.experiences');
    if (textareas.length === 0) {
        console.warn('Không tìm thấy textarea nào có class "experiences" bên trong .form-editor');
        return;
    }

    // 2. Cấu hình toolbar
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

    // 3. Lặp qua từng textarea và khởi tạo CKEditor
    textareas.forEach(function (textarea) {
        // Nếu textarea chưa có id, tự gán id để CKEditor replace được
        if (!textarea.id) {
            textarea.id = 'editor_' + Math.random().toString(36).substr(2, 9);
        }

        // Kiểm tra nếu CKEditor đã được khởi tạo trên element này rồi thì bỏ qua
        if (CKEDITOR.instances[textarea.id]) {
            return;
        }

        CKEDITOR.replace(textarea.id, {
            toolbar: fullToolbar,
            height: 250, // Giảm chiều cao một chút cho hợp lý khi có nhiều editor
            language: 'vi',
            removePlugins: 'elementspath,exportpdf',
            versionCheck: false,
            extraPlugins: 'justify,font,colorbutton,uploadimage',
            filebrowserUploadUrl: '/upload-image',
            filebrowserImageUploadUrl: '/upload-image',
            uploadUrl: '/upload-image',
            font_names: 'Arial/Arial, Helvetica, sans-serif;' +
                'Times New Roman/Times New Roman, Times, serif;' +
                'Verdana;' +
                'Courier New/Courier New, Courier, monospace;',
            fontSize_sizes: '10/10px;12/12px;14/14px;16/16px;18/18px;24/24px;36/36px;',
            removeButtons: '',
            resize_enabled: true
        });
    });

    // 4. Bỏ các nút ví dụ không cần thiết
    // document.getElementById('btnGetContent').addEventListener('click', function () {
    //     var instance = CKEDITOR.instances[textarea.id];
    //     var html = instance.getData();
    //     document.getElementById('output').textContent = html;
    //     console.log(html);
    // });
    //
    // document.getElementById('btnSetContent').addEventListener('click', function () {
    //     var instance = CKEDITOR.instances[textarea.id];
    //     instance.setData('<p><strong>Xin chào!</strong> Đây là nội dung mẫu được set từ JavaScript.</p>');
    // });

    // 5. Đồng bộ nội dung vào textarea gốc trước khi submit form (quan trọng khi dùng AJAX/FormData)
    // Đoạn code này vẫn đúng vì nó sẽ lặp qua tất cả các instance của CKEditor
    var form = wrapper.closest('form');
    if (form) {
        form.addEventListener('submit', function () {
            for (var name in CKEDITOR.instances) {
                CKEDITOR.instances[name].updateElement();
            }
        });
    }
})();


// --------------------------------------------------------------------------

(function () {
    var modalEl = document.getElementById('editCategoriesModal');
    var textareaId = 'modal_category_details';
    if (modalEl) {
        modalEl.addEventListener('shown.bs.modal', function () {
            if (typeof CKEDITOR === 'undefined') {
                console.error('CKEDITOR chưa được nạp. Hãy đảm bảo custom_ckeditor.js / ckeditor.js đã load trước khi mở modal.');
                return;
            }
            // Tránh lỗi "editor instance already exists" nếu mở modal nhiều lần
            if (CKEDITOR.instances[textareaId]) {
                CKEDITOR.instances[textareaId].destroy(true);
            }
            CKEDITOR.replace(textareaId);
        });
        modalEl.addEventListener('hidden.bs.modal', function () {
            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[textareaId]) {
                CKEDITOR.instances[textareaId].destroy(true);
                document.getElementById(textareaId).value = '';
            }
        });
    }

})();