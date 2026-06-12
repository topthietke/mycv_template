<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #1a73e8;
            color: #ffffff;
            padding: 24px 32px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .body {
            padding: 32px;
            color: #333333;
            line-height: 1.7;
        }

        .body p {
            margin: 0 0 16px;
        }

        .footer {
            background-color: #f0f0f0;
            text-align: center;
            padding: 16px;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ $subject }}</h1>
        </div>
        <div class="body">
            <p>Xin chào <strong>{{ $candidateName }}</strong>,</p>
            {!! $content !!}
            <p>Trân trọng,<br><strong>{{ config('app.name') }}</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>