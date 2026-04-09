<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Barber & Coffee</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1A1A1A;
        }

        .register-container {
            height: 100vh;
        }

        .card-custom {
            background-color: #222;
            border-radius: 15px;
            padding: 40px;
            color: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .brand {
            font-size: 24px;
            font-weight: 600;
            color: #C5A059;
        }

        .brand span {
            color: white;
        }

        .form-control {
            background-color: #1A1A1A;
            border: 1px solid #444;
            color: white;
        }

        .form-control:focus {
            border-color: #C5A059;
            box-shadow: none;
        }

        .btn-gold {
            background-color: #C5A059;
            color: #1A1A1A;
            font-weight: 600;
        }

        .btn-gold:hover {
            background-color: #b8954f;
        }

        a {
            color: #C5A059;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center register-container">
    <div class="card-custom text-center col-md-4">

        <div class="brand mb-3">Barber<span>&Coffee</span></div>

        <h4>Register</h4>
        <p class="text-muted">Daftar untuk mulai antre</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.user.post') }}" method="POST">
            @csrf

            <div class="mb-3 text-start">
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3 text-start">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3 text-start">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3 text-start">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-gold w-100 mt-3">Daftar</button>
        </form>

        <!-- LINK KE LOGIN -->
        <p class="mt-3">
            Sudah punya akun?
            <a href="{{ route('login.user') }}">Masuk di sini</a>
        </p>

    </div>
</div>

</body>
</html>