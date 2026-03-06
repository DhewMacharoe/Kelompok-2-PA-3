<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <div class="page-wrapper" style="justify-content:center;">

        <div class="main-content"
            style="padding-bottom:0; display:flex; flex-direction:column; justify-content:center; min-height:100vh;">

            <div style="text-align:center; padding:48px 16px 32px;">
                <div
                    style="width:72px; height:72px; border:2px solid var(--border); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:32px; margin:0 auto 12px;">
                    ✂</div>
                <div
                    style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted);">
                    Barbershop Admin Panel</div>
            </div>

            <section class="hero"
                style="padding:16px 16px 20px; text-align:center; margin:0 16px; border-radius:var(--radius-lg);">
                <div class="hero-title" style="font-size:16px;">Masuk ke Akun Admin</div>
                <div style="font-size:12px; color:rgba(255,255,255,0.5); margin-top:4px;">Kelola antrian barbershop Anda
                </div>
            </section>

            <div class="spacer-md"></div>

            <form action="{{ route('login.post') }}" method="POST" class="form-section">
                @csrf

                @if (session('error'))
                    <div class="error-banner" style="display:flex;">
                        ⚠ {{ session('error') }}
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Email Admin</label>
                    <input type="email" name="email" class="form-input" placeholder="admin@barbershop.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div style="position:relative;">
                        <input type="password" name="password" class="form-input" placeholder="Masukkan password..."
                            id="password" style="padding-right:48px;" required>
                        <button type="button" onclick="togglePw()"
                            style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; font-size:16px;">👁</button>
                    </div>
                </div>

                <div style="padding-top:16px;">
                    <button type="submit" class="btn btn-primary">MASUK</button>
                </div>
            </form>

            <div class="spacer-sm"></div>
            <div style="padding:0 16px; text-align:right;">
                <a href="#" style="font-size:12px; color:var(--text-muted); text-decoration:underline;">Lupa
                    password?</a>
            </div>

            <div class="spacer-lg"></div>

            <div style="text-align:center; padding-bottom:32px;">
                <a href="{{ url('/') }}"
                    style="font-size:11px; color:var(--text-muted); text-decoration:underline;">← Kembali ke Halaman
                    Publik</a>
            </div>

        </div>

    </div>

    <script>
        // Fungsi untuk memunculkan/menyembunyikan password
        function togglePw() {
            const pw = document.getElementById('password');
            pw.type = pw.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>

</html>
