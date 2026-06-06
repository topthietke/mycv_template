
$(document).ready(function () {
    // Lấy API host từ file .env thông qua Laravel helper
    const API_URL = "{{ env('APP_URL') }}/api/candidate";

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
            url: API_URL,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (res) {
                if (res.success) {
                    alert('Thông tin đã được lưu thành công!');
                } else {
                    alert('Đã xảy ra lỗi: ' + (res.message || 'Không thể lưu thông tin'));
                    $btn.html(originalText).prop('disabled', false);
                    return false;
                }

            },
            error: function (xhr, status, error) {
                $btn.html(originalText).prop('disabled', false);
                alert('Đã xảy ra lỗi khi lưu thông tin. Vui lòng thử lại!');
                console.error(xhr.responseText);
            }
        });
    });

    // Xóa thông báo lỗi khi người dùng bắt đầu nhập lại
    $('.form-control, .form-select').on('input change', function () {
        $(this).removeClass('is-invalid');
        $(this).siblings('.error-message').hide();
    });
});
