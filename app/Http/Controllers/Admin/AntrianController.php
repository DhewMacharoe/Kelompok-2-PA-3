<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;

class AntrianController extends Controller
{
    public function panggil($id)
    {

        Antrian::where('status', 'sedang dilayani')->update([
            'status' => 'selesai',
            'waktu_selesai' => now()
        ]);
        $antrian = Antrian::findOrFail($id);
        $antrian->update(['status' => 'sedang dilayani']);

        return redirect()->back()->with('success', 'Antrian ' . $antrian->nomor_antrian . ' sedang dilayani.');
    }

    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,batal',
        ]);

        $antrian = Antrian::findOrFail($id);
        $antrian->update([
            'status' => $request->status,
            'waktu_selesai' => $request->status === 'selesai' ? now() : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status antrian ' . $antrian->nomor_antrian . ' diubah menjadi ' . $request->status . '.',
        ]);
    }
}

