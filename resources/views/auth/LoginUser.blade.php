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

        <button id="googleLoginButton" type="button" class="btn btn-outline-light w-100">Masuk dengan Google</button>

        <form id="firebaseLoginForm" action="{{ route('firebase.login') }}" method="POST" class="d-none">
            @csrf
            <input type="hidden" name="idToken" id="firebaseIdToken">
        </form>

        <script type="module">
            const firebaseConfig = {
                apiKey: "{{ config('firebase.api_key') }}",
                authDomain: "{{ config('firebase.auth_domain') }}",
                projectId: "{{ config('firebase.project_id') }}",
                storageBucket: "{{ config('firebase.storage_bucket') }}",
                messagingSenderId: "{{ config('firebase.messaging_sender_id') }}",
                appId: "{{ config('firebase.app_id') }}",
                measurementId: "{{ config('firebase.measurement_id') }}"
            };

            import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
            import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";

            const app = initializeApp(firebaseConfig);
            const auth = getAuth(app);
            const provider = new GoogleAuthProvider();

            document.getElementById('googleLoginButton').addEventListener('click', async () => {
                try {
                    const result = await signInWithPopup(auth, provider);
                    const idToken = await result.user.getIdToken();
                    document.getElementById('firebaseIdToken').value = idToken;
                    document.getElementById('firebaseLoginForm').submit();
                } catch (error) {
                    console.error('Firebase Google login failed:', error);
                    alert('Login Google gagal: ' + error.message);
                }
            });
        </script>

    </div>
</div>

</body>
</html>
