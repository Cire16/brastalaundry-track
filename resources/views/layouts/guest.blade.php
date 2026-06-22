<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }} - Laundry Track</title>
    @vite(['resources/css/app.css', 'resources/css/auth.css', 'resources/js/app.js'])
</head>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f1ed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            display: flex;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            min-height: 550px;
        }

        .auth-sidebar {
            background: #3d2e2e;
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 300px;
            text-align: center;
        }

        .auth-sidebar h1 {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .auth-sidebar .star {
            font-size: 24px;
            margin-left: 5px;
        }

        .auth-body {
            flex: 1;
            padding: 60px 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-title {
            font-size: 32px;
            font-weight: 700;
            color: #2d2d2d;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2d2d2d;
            font-size: 15px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 16px 50px 16px 20px;
            border: 2px solid #e8e4df;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            background: #faf9f7;
            color: #2d2d2d;
        }

        .input-wrapper input::placeholder {
            color: #999;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #3d2e2e;
            background: white;
        }

        .input-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            opacity: 0.5;
        }

        .form-error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 8px;
        }

        .form-footer-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .form-footer-links a {
            color: #6b5b4f;
            text-decoration: none;
            font-size: 14px;
        }

        .form-footer-links a:hover {
            text-decoration: underline;
            color: #3d2e2e;
        }

        .btn {
            width: 100%;
            padding: 16px;
            background: #3d2e2e;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn:hover {
            background: #2d1e1e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(61, 46, 46, 0.3);
        }

        .form-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }

        .form-footer a {
            color: #6b5b4f;
            text-decoration: underline;
            font-weight: 600;
        }

        .form-footer a:hover {
            color: #3d2e2e;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background: #efe;
            color: #3a3;
            border: 1px solid #cfc;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-group label {
            margin-bottom: 0;
            font-weight: normal;
            cursor: pointer;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }
            .auth-sidebar {
                width: 100%;
                padding: 40px 20px;
            }
            .auth-body {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-sidebar">
            <h1>BRASTA<br>LAUNDRY</h1>
        </div>
        <div class="auth-body">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
