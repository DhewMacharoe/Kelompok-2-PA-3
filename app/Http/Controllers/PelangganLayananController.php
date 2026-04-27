<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesPublicImageUploads;
use Illuminate\Http\Request;
use App\Models\Layanan;

class PelangganLayananController extends Controller
{
    use HandlesPublicImageUploads;

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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('foto')) {
            $folder = 'layanan';
            $this->deleteImageFromPublic($layanan->foto);
            $data['foto'] = $this->storeImageToPublic($request->file('foto'), $folder);
        }
        $layanan->update($data);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        $this->deleteImageFromPublic($layanan->foto);

        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
