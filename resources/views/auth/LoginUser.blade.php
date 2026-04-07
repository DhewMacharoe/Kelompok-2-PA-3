<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Barber & Coffee</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1A1A1A;
        }

        .login-container {
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

<div class="container d-flex justify-content-center align-items-center login-container">
    <div class="card-custom text-center col-md-4">

        <div class="brand mb-3">Barber<span>&Coffee</span></div>

        <h4>Login</h4>
        <p class="text-muted">Masuk untuk mulai antre</p>

        <form>
            <div class="mb-3 text-start">
                <label>Email</label>
                <input type="email" class="form-control">
            </div>

            <div class="mb-3 text-start">
                <label>Password</label>
                <input type="password" class="form-control">
            </div>

            <button class="btn btn-gold w-100 mt-3">Login</button>
        </form>

        <!-- LINK KE REGISTER -->
        <p class="mt-3">
            Belum punya akun?
            <a href="register.html">Daftar di sini</a>
        </p>

    </div>
</div>

</body>
</html>
