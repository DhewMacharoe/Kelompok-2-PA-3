<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Arga Home's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/arga-auth.css') }}">
</head>

<body class="auth-page auth-page--login">

    <div class="auth-shell">
        <div class="auth-card auth-card--compact">
            <div class="auth-form">
                <div class="auth-form-inner">


                    <div class="auth-kicker">Selamat datang</div>
                    <h2 class="auth-section-title">Masuk ke Arga Home's</h2>
                    <p class="auth-section-copy">Masuk dengan Google untuk Mengambil Antrian Lebih Cepat</p>

                    @if (session('error'))
                        <div class="auth-alert auth-alert--error small text-start">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="auth-alert auth-alert--success small text-start">
                            {{ session('success') }}
                        </div>
                    @endif

                    <button id="googleLoginButton" type="button"
                        class="auth-button auth-button--google d-flex align-items-center justify-content-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 18 18" aria-hidden="true" focusable="false">
                            <path fill="#EA4335"
                                d="M17.64 9.2045c0-.6382-.0573-1.2518-.1636-1.8409H9v3.4818h4.8436c-.2086 1.125-.8427 2.0782-1.7963 2.7164v2.2582h2.9086c1.7018-1.5668 2.6841-3.8741 2.6841-6.6155z" />
                            <path fill="#34A853"
                                d="M9 18c2.43 0 4.4673-.8059 5.9564-2.1791l-2.9086-2.2582c-.8059.54-1.8368.8591-3.0477.8591-2.3441 0-4.3282-1.5823-5.0364-3.7091H.9573v2.3318C2.4382 15.9832 5.4818 18 9 18z" />
                            <path fill="#4A90E2"
                                d="M3.9636 10.7127C3.7832 10.1727 3.6818 9.5959 3.6818 9s.1014-1.1727.2818-1.7127V4.9555H.9573C.3477 6.1705 0 7.5441 0 9s.3477 2.8295.9573 4.0445l3.0063-2.3318z" />
                            <path fill="#FBBC05"
                                d="M9 3.5782c1.3214 0 2.5077.4541 3.44 1.3459l2.5814-2.5814C13.4636.8918 11.43 0 9 0 5.4818 0 2.4382 2.0168.9573 4.9555l3.0063 2.3318C4.6718 5.1605 6.6559 3.5782 9 3.5782z" />
                        </svg>
                        <span>Masuk dengan Google</span>
                    </button>

                    <p id="loginStatus" class="small auth-status mb-0"></p>

                    <form id="firebaseLoginForm" action="{{ route('firebase.login') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="idToken" id="firebaseIdToken">
                        <input type="hidden" name="firebase_uid" id="firebaseUid">
                        <input type="hidden" name="firebase_email" id="firebaseEmail">
                        <input type="hidden" name="firebase_name" id="firebaseName">
                    </form>

                    <p class="auth-footer-copy mb-0">
                        Dengan melanjutkan, Anda setuju untuk menggunakan akun Google sebagai identitas masuk ke layanan
                        Arga Home's.
                    </p>

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

                        import {
                            initializeApp
                        } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
                        import {
                            getAuth,
                            GoogleAuthProvider,
                            signInWithPopup
                        } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";

                        const app = initializeApp(firebaseConfig);
                        const auth = getAuth(app);
                        const provider = new GoogleAuthProvider();
                        const loginButton = document.getElementById('googleLoginButton');
                        const loginStatus = document.getElementById('loginStatus');

                        provider.setCustomParameters({
                            prompt: 'select_account'
                        });

                        loginButton.addEventListener('click', async () => {
                            try {
                                loginButton.disabled = true;
                                loginStatus.textContent = 'Menghubungkan ke Firebase...';

                                const result = await signInWithPopup(auth, provider);
                                const idToken = await result.user.getIdToken();
                                document.getElementById('firebaseUid').value = result.user.uid || '';
                                document.getElementById('firebaseEmail').value = result.user.email || '';
                                document.getElementById('firebaseName').value = result.user.displayName || '';
                                document.getElementById('firebaseIdToken').value = idToken;
                                document.getElementById('firebaseLoginForm').submit();
                            } catch (error) {
                                console.error('Firebase Google login failed:', error);
                                loginStatus.textContent = 'Login gagal: ' + error.message;
                                loginButton.disabled = false;
                                alert('Login Google gagal: ' + error.message);
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
