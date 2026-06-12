<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MyCv Platform – Thông Tin Tài Khoản</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css"
        integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"
        integrity="sha512-EKWWs1ZcA2ZY9lbLISPz8aGR2+L7JVYqBAYTq5AXgBkSjRSuQEGqWx8R1zAX16KdXPaCjOCaKE8MCpU0wcHlHA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="/assets/css/email.css" />

</head>

<body>
    <?php 
        if (empty($name))    $name                     = "Quý khách";
        if (empty($hello))    $hello                   = "Kính gửi!";
        if (empty($app_name))    $app_name             = env('APP_NAME') ?? 'Hệ thống quản lý hồ sơ cá nhân';
        if (empty($content))    $content               = "Tài khoản của bạn đã được đăng ký thành công trên hệ thống <b><span class = 'text-danger'>" . $app_name . "</span></b>. <br>Dưới đây là thông tin tài khoản của bạn — hãy giữ bí mật và không chia sẻ cho bất kỳ ai nhé. ";
        if (empty($title))    $title                   = "Thông tin tài khoản";
        if (empty($name_title))    $name_title         = "Họ Tên";
        if (empty($email_title))    $email_title       = "Email";
        if (empty($email))    $email                   = "noreply@gmail.com";
        if (empty($password_title))    $password_title = "Mật Khẩu";
        if (empty($url_title))    $url_title           = "Địa chỉ website: ";
        if (empty($url))    $url                       = env('APP_URL');
        if (empty($note))    $note                     = "Mật khẩu trên đã được mã hóa. Vui lòng đổi mật khẩu ngay sau khi đăng nhập lần đầu để bảo mật tài khoản của bạn.";
        if (empty($password))    $password             = "Chưa xác định";
    
    ?>
    <div class="greeting-section">
        <h3> {{$hello}} <span class="name greeting-title">{{ $name }}</span></h3>
        {{-- <p class="greeting-body"> {!! $content !!} </p> --}}
        <p> {!! $content !!} </p>
    </div>
    <table>
        <tr>
            <td><strong>{{ $name_title }}:</strong></td>
            <td class="px-2">{{ $name }}</td>
        </tr>    
        <tr>
            <td><strong>{{ $email_title }}:</strong></td>
            <td class="px-2">{{ $email }}</td>
        </tr>    
        <tr>
            <td><strong>{{ $password_title }}:</strong></td>
            <td class="px-2">{{ $password }}</td>
        </tr>    
        <tr>
            <td><strong>{{ $url_title }}:</strong></td>
            <td class="px-2">{{ $url }}</td>
        </tr>            
    </table>

    <br>
    <div class="mx-0 px-0alert alert-muted" role="alert">
        <small class="text-muted">
            <i><strong>Ghi chú:</strong> {{ $note }}</i>
        </small>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>