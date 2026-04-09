<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;
use Lcobucci\JWT\Token\Plain as JwtPlainToken;

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
        ]);

        $serviceAccountPath = config('firebase.service_account_path');

        if (!$serviceAccountPath) {
            return back()->with('error', 'Firebase service account path not configured.');
        }

        $fullPath = base_path($serviceAccountPath);

        if (!file_exists($fullPath)) {
            return back()->with('error', 'Firebase service account file not found.');
        }

        try {
            $auth = (new Factory())
                ->withServiceAccount($fullPath)
                ->createAuth();

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
                'firebase_uid' => $firebaseUser->uid,
                'email_verified_at' => now(),
            ]);

            // For now, don't auto-login since Firebase handles auth
            // Auth::login($user);
            // $request->session()->regenerate();

            return redirect()->route('login.user')->with('success', 'Registrasi berhasil! Silakan login dengan email dan password Anda.');
        } catch (\Throwable $exception) {
            return back()->with('error', 'Registrasi gagal: ' . $exception->getMessage())->withInput();
        }
    }

    // Memproses data login admin
    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard'); // Arahkan ke dashboard jika sukses
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // Memproses login Google via Firebase
    public function firebaseLogin(Request $request)
    {
        $request->validate([
            'idToken' => 'required|string',
        ]);

        $serviceAccountPath = config('firebase.service_account_path');

        if (!$serviceAccountPath) {
            return back()->with('error', 'Firebase service account path not configured.');
        }

        $fullPath = base_path($serviceAccountPath);

        if (!file_exists($fullPath)) {
            return back()->with('error', 'Firebase service account file not found.');
        }

        try {
            $auth = (new Factory())
                ->withServiceAccount($fullPath)
                ->createAuth();

            $verifiedToken = $auth->verifyIdToken($request->input('idToken'));
        } catch (\Throwable $exception) {
            return back()->with('error', 'Verifikasi token Firebase gagal: ' . $exception->getMessage());
        }

        if (!$verifiedToken instanceof JwtPlainToken) {
            return back()->with('error', 'Token Firebase tidak valid.');
        }

        $firebaseUid = $verifiedToken->claims()->get('sub'); // UID is in 'sub' claim
        $email = $verifiedToken->claims()->get('email');
        $name = $verifiedToken->claims()->get('name') ?? explode('@', $email)[0];

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
            }
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Test Firebase connection
    public function testFirebase()
    {
        $serviceAccountPath = config('firebase.service_account_path');

        if (!$serviceAccountPath) {
            return response()->json(['status' => 'error', 'message' => 'Firebase service account path not configured in config.']);
        }

        $fullPath = base_path($serviceAccountPath);

        if (!file_exists($fullPath)) {
            return response()->json(['status' => 'error', 'message' => 'Firebase service account file not found at: ' . $fullPath]);
        }

        try {
            $auth = (new Factory())
                ->withServiceAccount($fullPath)
                ->createAuth();

            // Try to get the project ID as a basic connectivity test
            $projectId = config('firebase.project_id');
            if (!$projectId) {
                return response()->json(['status' => 'error', 'message' => 'Firebase project ID not configured.']);
            }

            return response()->json(['status' => 'success', 'message' => 'Firebase is connected. Project ID: ' . $projectId]);
        } catch (\Throwable $exception) {
            return response()->json(['status' => 'error', 'message' => 'Firebase connection failed: ' . $exception->getMessage()]);
        }
    }
}
