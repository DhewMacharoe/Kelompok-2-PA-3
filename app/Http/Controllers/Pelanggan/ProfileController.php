<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil pelanggan.
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Pastikan hanya pelanggan (bukan admin) yang dapat mengakses halaman ini
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin tidak dapat mengedit profil dari halaman pelanggan.');
        }

        return view('pelanggan.profile.edit', compact('user'));
    }

    /**
     * Memproses pembaruan data profil pelanggan.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin tidak dapat mengedit profil dari halaman pelanggan.');
        }

        $request->merge([
            'username' => trim((string) $request->input('username')),
        ]);

        $validated = $request->validate([
            'username' => 'required|string|min:3|max:20|unique:users,username,' . $user->id,
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.max' => 'Username maksimal 20 karakter.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
        ]);

        $user->username = $validated['username'];
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
