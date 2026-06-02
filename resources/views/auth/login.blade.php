<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/design-tokens.css') }}">

    <style>
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

        .btn-login {
            background-color: var(--color-primary);
            border: 1px solid var(--color-primary);
            color: #ffffff;
            padding: 0.875rem 1rem;
            min-height: 44px;
            font-weight: 700;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            margin-top: 10px;
            transition: transform var(--transition-standard), box-shadow var(--transition-standard), background-color var(--transition-standard), border-color var(--transition-standard);
        }

        .btn-login:hover {
            background-color: var(--color-primary-strong);
            border-color: var(--color-primary-strong);
            transform: translateY(-1px);
        }

        .btn-login:focus-visible {
            outline: 3px solid rgba(200, 162, 74, 0.35);
            outline-offset: 2px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/app-theme.css') }}">
</head>

<body>

    <div class="login-card text-center">
        <h2 class="login-title">Masuk Admin</h2>
        <form action="{{ route('login.post') }}" method="POST" class="form-section" novalidate>
            @csrf

            @if (session('error'))
                <div class="alert alert-danger text-start p-2 mb-3" role="alert" style="font-size: 14px;">
                    {{ session('error') }}
                </div>
            @endif

            <x-form.field
                label="Email"
                name="email"
                type="email"
                :value="old('email')"
                placeholder="Email admin"
                help="Gunakan email admin yang terdaftar di sistem."
                wrapperClass="mb-3 text-start"
                labelClass="form-label text-start"
                controlClass="bg-white"
                id="email"
                required
            />

            <x-form.field
                label="Password"
                name="password"
                type="password"
                placeholder="Password"
                help="Password harus sesuai dengan akun admin Anda."
                wrapperClass="mb-3 text-start"
                labelClass="form-label text-start"
                controlClass="bg-white"
                id="password"
                required
            />

            <button type="submit" class="btn btn-primary w-100 btn-login">Masuk</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
