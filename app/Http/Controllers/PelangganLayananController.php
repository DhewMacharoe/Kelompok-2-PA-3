<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Layanan;

class PelangganLayananController extends Controller
{
    public function index()
    {
        $layanans = \App\Models\Layanan::where('is_active', true)->get();

        return view('pelanggan.layanan.layanan', compact('layanans'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'estimasi_waktu' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $layanan->update($data);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {

        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
