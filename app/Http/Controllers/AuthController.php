<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;

class AuthController extends Controller
{
    // Menampilkan halaman login admin
    public function showLogin()
    {
        return view('auth.login');
    }

    // Menampilkan halaman login pengguna
    public function showUserLogin()
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin yang sedang login tidak dapat masuk sebagai user.');
        }

        if (Auth::check()) {
            return redirect()->intended('/');
        }

        // Simpan URL sebelumnya ke intended URL jika bukan halaman auth
        $previousUrl = url()->previous();
        if ($previousUrl && !Str::contains($previousUrl, ['login', 'register', 'firebase-login', 'set-username'])) {
            session()->put('url.intended', $previousUrl);
        }

        return view('auth.LoginUser');
    }

    // Menampilkan halaman register pengguna
    public function showUserRegister()
    {
        return view('auth.register');
    }

    // Memproses register pengguna
    public function doUserRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_whatsapp' => 'required|string|regex:/^08[0-9]{8,13}$/',
        ], [
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex' => 'Format nomor WhatsApp tidak valid (harus diawali 08 dan berisi 10-15 angka).',
        ]);

        try {
            $auth = $this->createFirebaseFactory()->createAuth();

            // Create user in Firebase Auth
            $firebaseUser = $auth->createUser([
                'email' => $request->email,
                'password' => $request->password,
                'displayName' => $request->name,
                'emailVerified' => true, // Mark as verified for manual registration
            ]);

            // Create user in Laravel database
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password), // Still hash for potential local use
                'no_whatsapp' => $request->no_whatsapp,
                'firebase_uid' => $firebaseUser->uid,
                'email_verified_at' => now(),
            ]);

            $user->assignRole('user');

            // For now, don't auto-login since Firebase handles auth
            // Auth::login($user);
            // $request->session()->regenerate();

            return redirect()->route('login.user')->with('success', 'Registrasi berhasil! Silakan login dengan email dan password Anda.');
        } catch (\Throwable $exception) {
            $message = 'Registrasi gagal. Terjadi kendala saat mendaftarkan akun Anda. Silakan coba lagi.';
            if (str_contains(strtolower($exception->getMessage()), 'email_exists') || str_contains(strtolower($exception->getMessage()), 'already in use')) {
                $message = 'Registrasi gagal. Alamat email tersebut sudah terdaftar.';
            }
            return back()->with('error', $message)->withInput();
        }
    }

    // Memproses data login admin
    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Harap isi email anda terlebih dahulu',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Harap isi password terlebih dahulu',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $intended = session()->pull('url.intended', '');

            if (Auth::user()->hasRole('super_admin')) {
                if ($intended && \Illuminate\Support\Str::contains($intended, '/super-admin')) {
                    return redirect($intended);
                }
                return redirect('super-admin/dashboard');
            }

            if (Auth::user()->hasRole('admin')) {
                if ($intended && \Illuminate\Support\Str::contains($intended, '/admin')) {
                    return redirect($intended);
                }
                return redirect('admin/dashboard');
            }

            return redirect($intended ?: '/');
        }

        // Ditambahkan ->withInput() agar email yang sudah diketik tidak hilang saat kata sandi salah
        return back()
            ->with('error', 'Email atau kata sandi salah.')
            ->withInput($request->only('email'));
    }

    // Memproses login Google via Firebase
    public function firebaseLogin(Request $request)
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin yang sedang login tidak dapat login sebagai user.');
        }

        $request->validate([
            'idToken' => 'required|string',
        ]);

        try {
            $auth = $this->createFirebaseFactory()->createAuth();
            $verifiedToken = $auth->verifyIdToken($request->input('idToken'));
        } catch (\Throwable $exception) {
            return back()->with('error', 'Gagal memverifikasi akun Anda. Silakan coba masuk kembali.');
        }

        /** @var \Kreait\Firebase\JWT\Contract\Token $verifiedToken */
        $payload = $verifiedToken->payload();
        $firebaseUid = $request->input('firebase_uid') ?: ($payload['sub'] ?? null);
        $email = $request->input('firebase_email') ?: ($payload['email'] ?? null);
        $name = $request->input('firebase_name') ?: ($payload['name'] ?? ($email ? explode('@', $email)[0] : 'Pengguna'));

        if (!$firebaseUid) {
            return back()->with('error', 'Data akun Firebase tidak lengkap.');
        }

        if (!$email) {
            $email = $firebaseUid . '@firebase.local';
        }

        // Find or create user by firebase_uid
        $user = User::where('firebase_uid', $firebaseUid)->first();

        if (!$user) {
            // If not found by uid, try by email for existing users
            $user = User::where('email', $email)->first();
            if ($user) {
                // Update with uid
                $user->update(['firebase_uid' => $firebaseUid]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'firebase_uid' => $firebaseUid,
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(32)), // Random password since auth is via Firebase
                ]);
                $user->assignRole('user');
            }
        }

        // If user doesn't have username or no_whatsapp, redirect to set profile
        if (!$user->username || !$user->no_whatsapp) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('set.username');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    // Menampilkan halaman set username
    public function showSetUsername()
    {
        if (!Auth::check()) {
            return redirect()->route('login.user');
        }

        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin tidak memerlukan pengaturan username pelanggan.');
        }

        if (Auth::user()->username && Auth::user()->no_whatsapp) {
            return redirect()->intended('/');
        }

        return view('auth.set_username');
    }

    // Memproses set username
    public function doSetUsername(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login.user')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin tidak dapat mengubah username pelanggan.');
        }

        if (Auth::user()->username && Auth::user()->no_whatsapp) {
            return redirect()->intended('/')
                ->with('info', 'Profil sudah lengkap.');
        }

        $request->merge([
            'username' => trim((string) $request->input('username')),
            'no_whatsapp' => trim((string) $request->input('no_whatsapp')),
        ]);

        $validated = $request->validate([
            'username' => 'required|string|min:3|max:20|unique:users,username,' . Auth::id(),
            'no_whatsapp' => 'required|string|regex:/^08[0-9]{8,13}$/',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.max' => 'Username maksimal 20 karakter.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex' => 'Format nomor WhatsApp tidak valid (harus diawali 08 dan berisi 10-15 angka).',
        ]);

        $user = Auth::user();
        $user->username = $validated['username'];
        $user->no_whatsapp = $validated['no_whatsapp'];
        $user->save();

        return redirect()->intended('/')->with('success', 'Profil berhasil dilengkapi!');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function createFirebaseFactory(): Factory
    {
        $serviceAccountJson = config('firebase.service_account_json');
        $serviceAccountBase64 = config('firebase.service_account_base64');
        $serviceAccountPath = config('firebase.service_account_path');

        if ($serviceAccountJson) {
            return (new Factory())->withServiceAccount($serviceAccountJson);
        }

        if ($serviceAccountBase64) {
            $decoded = base64_decode($serviceAccountBase64, true);
            if ($decoded === false) {
                throw new \RuntimeException('Firebase service account base64 value is invalid.');
            }

            return (new Factory())->withServiceAccount($decoded);
        }

        if ($serviceAccountPath) {
            $fullPath = base_path($serviceAccountPath);

            if (!file_exists($fullPath)) {
                throw new \RuntimeException('Firebase service account file not found at: ' . $fullPath);
            }

            return (new Factory())->withServiceAccount($fullPath);
        }

        throw new \RuntimeException('Firebase service account configuration is missing.');
    }

    // Test Firebase connection
    public function testFirebase() {}
}
