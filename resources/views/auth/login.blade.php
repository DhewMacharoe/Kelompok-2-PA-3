<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Kustomisasi CSS untuk mencocokkan desain gambar */
        body {
            background-color: #2C3E50;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 480px;
            background-color: #ffffff;
            border-radius: 4px;
            padding: 50px 40px;
        }

        .login-title {
            font-weight: bold;
            color: #000000;
            margin-bottom: 35px;
            font-size: 32px;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            font-size: 15px;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(43, 160, 255, 0.25);
            border-color: #2ba0ff;
        }

        .btn-login {
            background-color: #0578FB;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #0b66da;
        }
    </style>
</head>

<body>

    <div class="login-card text-center">
        <h2 class="login-title">Login Admin</h2>
        <form action="{{ route('login.post') }}" method="POST" class="form-section">
            @csrf
            @if (session('error'))
                <div class="error-banner" style="display:flex;">
                     {{ session('error') }}
                </div>
            @endif
            <div class="mb-3">
                <input type="email" name="email" class="form-control" id="username" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>

            </div>
            <button type="submit" class="btn btn-primary w-100 btn-login">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
