
export function msg_success(message = 'Thành công') {
    toastr.success(message);
    // setTimeout(function () {
    //     document.location.reload();
    // }, 1000);

}

export function msg_error(message = 'Không thành công') {
    toastr.error(message);
    // setTimeout(function () {
    //     document.location.reload();
    // }, 1000);
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


