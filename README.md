nohup php artisan queue:work > /dev/null 2>&1 &

// Lưu ý: trước đây code dùng config(env('API_URL'), env('API_URL')), đây là cách dùng
// SAI hàm config() — tham số đầu của config() phải là TÊN KHOÁ cấu hình (vd:
// 'services.api.url'), không phải giá trị URL. Vì key đó không tồn tại trong config nên
// config() luôn rơi vào giá trị mặc định (chính là env('API_URL')) — code "chạy được"
// chỉ là tình cờ. Ngoài ra không nên gọi env() trực tiếp ngoài file config/\*.php vì sẽ
// trả về null khi chạy `php artisan config:cache`.
// => Khuyến nghị: thêm 'url' vào config/services.php, vd:
// 'api' => ['url' => env('API_URL')],
// rồi dùng: config('services.api.url')



<style>
    /* ===== CV Candidate Form – style theo mẫu ảnh ===== */
    .cv-form label {
        text-transform: normal;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: .04em;
        color: #495057;
        margin-bottom: .4rem;
    }

    /* .cv-form .form-control,
    .cv-form .form-select {
        border: 1px solid #e3e6ea;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 0.95rem;
    }

    .cv-form .form-control:focus,
    .cv-form .form-select:focus {
        background-color: #fff;
        border-color: #86b7fe;
        box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .15);
    } */

    .cv-form .text-required {
        color: #dc3545;
    }

    /* Cột ảnh đại diện: căn giữa toàn bộ nội dung */
    .avatar-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .avatar-col label {
        width: 100%;
        max-width: 210px;
    }

    /* Khung ảnh đại diện */
    .avatar-upload-box {
        width: 100%;
        max-width: 210px;
        aspect-ratio: 3 / 4;
        /* border: 2px dashed #ced4da;
        border-radius: 10px; */
        background-color: #f1f3f5;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin: 0 auto .75rem auto;
        position: relative;
    }

    .avatar-upload-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
        border-radius: 8px;
    }

    .avatar-upload-box .avatar-placeholder-icon {
        font-size: 2.5rem;
        color: #adb5bd;
    }

    .avatar-upload-wrapper {
        width: 100%;
        max-width: 210px;
        margin: 0 auto;
    }

    /* .avatar-upload-wrapper .form-control {
        font-size: .85rem;
        padding: 8px 10px;
    } */

    .avatar-hint {
        margin-left: auto;
        margin-right: auto;
        font-size: .75rem;
        color: #868e96;
        margin-top: .4rem;
        max-width: 210px;
    }
</style>
