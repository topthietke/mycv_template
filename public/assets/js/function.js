
export function msg_success(message = 'Thành công') {
    new bootstrap.Modal(document.getElementById('successModal')).show();
    success_message.textContent = message || 'Cập nhật thông tin thành công!';
}

export function msg_error(message = 'Không thành công') {
    new bootstrap.Modal(document.getElementById('errorsModal')).show();
    errors_message.textContent = message || 'Cập nhật thông tin thất bại!';
}

export function ajax(url, data, method) {
    $.ajax({
        url: url,
        method: method,
        data: data,
        processData: false,
        contentType: false,
        success: (res) => {
            if (res && res.code == 200) {
                msg_success(res.message, 'success');
            } else {
                msg_error(res.message, 'error');
            }

        },
        error: err => {
            msg_error('Cập nhật không thành công', 'error');
        },
    });
}


