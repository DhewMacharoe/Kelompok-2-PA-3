<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil pelanggan beserta riwayat antrean.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        $riwayatAntrean = \App\Models\Antrean::withoutGlobalScopes()
            ->with(['layanan1', 'layanan2', 'barbershop'])
            ->where('nama_pelanggan', $user->username)
            ->whereIn('status', ['selesai', 'batal'])
            ->orderBy('created_at', 'desc')
            ->get();

        $bookingAktif = \App\Models\Antrean::withoutGlobalScopes()
            ->with(['layanan1', 'layanan2', 'barbershop'])
            ->where('nama_pelanggan', $user->username)
            ->where('is_booking', true)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->orderBy('tanggal_booking', 'asc')
            ->orderBy('waktu_booking', 'asc')
            ->get();

        $activeBarbershop = new \App\Models\Barbershop();
        $activeBarbershop->nama_brand = 'Arga Barbershop';
        $activeBarbershop->warna_primer = '#d4af37'; // Warna general
        $activeDesign = $activeBarbershop;

        return view('pelanggan.profile.index', compact('user', 'riwayatAntrean', 'bookingAktif', 'activeBarbershop', 'activeDesign'));
    }
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

        $activeBarbershop = new \App\Models\Barbershop();
        $activeBarbershop->nama_brand = 'Arga Barbershop';
        $activeBarbershop->warna_primer = '#d4af37';
        $activeDesign = $activeBarbershop;

        return view('pelanggan.profile.edit', compact('user', 'activeBarbershop', 'activeDesign'));
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
            'no_whatsapp' => trim((string) $request->input('no_whatsapp')),
        ]);

        $validated = $request->validate([
            'username' => 'required|string|min:3|max:20|unique:users,username,' . $user->id,
            'no_whatsapp' => 'required|string|regex:/^08[0-9]{8,13}$/',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.max' => 'Username maksimal 20 karakter.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex' => 'Format nomor WhatsApp tidak valid (harus diawali 08 dan berisi 10-15 angka).',
        ]);

        $user->username = $validated['username'];
        $user->no_whatsapp = $validated['no_whatsapp'];
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
