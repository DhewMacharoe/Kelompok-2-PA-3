<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Barbershop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarbershopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barbershops = Barbershop::all();
        return view('super_admin.barbershops.index', compact('barbershops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.barbershops.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:barbershops,slug',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }
        $data['is_active'] = $request->has('is_active');

        Barbershop::create($data);

        return redirect()->route('super-admin.barbershops.index')->with('success', 'Barbershop berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barbershop $barbershop)
    {
        return view('super_admin.barbershops.edit', compact('barbershop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barbershop $barbershop)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:barbershops,slug,' . $barbershop->id,
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }
        $data['is_active'] = $request->has('is_active');

        $barbershop->update($data);

        return redirect()->route('super-admin.barbershops.index')->with('success', 'Barbershop berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barbershop $barbershop)
    {
        $barbershop->delete();
        return redirect()->route('super-admin.barbershops.index')->with('success', 'Barbershop berhasil dihapus.');
    }
}
