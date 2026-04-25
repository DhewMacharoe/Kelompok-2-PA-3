<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(Request $request)

    {
        $query = Layanan::latest();

        $layanans = $query->get();

        return view('admin.layanan.index', compact('layanans'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function show(Layanan $layanan)
    {
        return view('admin.layanan.show', compact('layanan'));
    }

    public function toggleStatus(Layanan $layanan)
    {
        $layanan->update(['is_active' => !$layanan->is_active]);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Status layanan berhasil diubah.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'estimasi_waktu' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);


        Layanan::create($data);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
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
