<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cập nhật lại mật khẩu - FIT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .content {
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            border-radius: 4px;
            text-decoration: none;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Cập nhật lại mật khẩu</h2>
        </div>
        <div class="content">
            <p>Xin chào,</p>
            <p>Bạn nhận được thư này vì chúng đã nhận được một yêu cầu cập nhật lại mật khẩu từ tài khoản của bạn.</p>
            <p>Mã cập nhật mật khẩu của bạn là:</p>
            <h3>{{ $token }}</h3>
            <p>Nếu bạn không yêu cầu đặt lại mật khẩu thì không cần thực hiện thêm hành động nào.</p>
        </div>
        <div class="footer">
            <p>Trân trọng,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
