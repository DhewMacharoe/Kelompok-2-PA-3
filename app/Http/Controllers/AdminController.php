<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Ambil data pelanggan yang sedang dipanggil
        $dipanggil = Antrian::where('status', 'dipanggil')->first();

        // 2. Hitung total yang sedang menunggu
        $jumlahMenunggu = Antrian::where('status', 'menunggu')->count();

        // 3. Hitung total yang sudah selesai HARI INI
        $jumlahSelesai = Antrian::where('status', 'selesai')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        // 4. Ambil daftar pelanggan yang sedang menunggu (urutkan dari yang paling lama)
        $antrianMenunggu = Antrian::where('status', 'menunggu')
            ->orderBy('waktu_masuk', 'asc')
            ->get();

        return view('admin.dashboard', compact('dipanggil', 'jumlahMenunggu', 'jumlahSelesai', 'antrianMenunggu'));
    }
}
