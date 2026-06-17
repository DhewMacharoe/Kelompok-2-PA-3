<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barbershop;
use Illuminate\Http\Request;

class BarbershopController extends Controller
{
    public function index()
    {
        $barbershop = Barbershop::first();
        if (!$barbershop) {
            $barbershop = Barbershop::create([
                'is_active' => true,
                'nama_brand' => "Arga Home's",
                'favicon' => 'assets/images/logo.png',
                'alaamat' => 'Jl.P.Siantar Km 2, Tampubolon, Sibolahotangaso Kec. Balige, Tobasa, Sumatera Utara',
                'email' => 'joebarberid@gmail.com',
                'kontak' => [
                    'instagram' => 'https://instagram.com',
                    'facebook' => 'https://facebook.com',
                    'whatsapp' => '082167893019',
                    'link_map' => null,
                    'map_embed' => null,
                ],
            ]);
        }
        return view('admin.barbershop.index', compact('barbershop'));
    }

    public function create()
    {
        return view('admin.barbershop.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_brand' => 'required|string|max:255',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
            'alaamat' => 'required|string',
            'email' => 'required|email|max:255',
            'whatsapp' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'link_map' => 'nullable|string',
            'map_embed' => 'nullable|string',
            'warna_primer' => 'nullable|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $faviconPath = 'favicon.png';
        if ($request->hasFile('favicon')) {
            $faviconName = time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('assets/images'), $faviconName);
            $faviconPath = 'assets/images/' . $faviconName;
        }

        $kontak = [
            'whatsapp' => $request->whatsapp,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'link_map' => $request->link_map,
            'map_embed' => $request->map_embed,
        ];

        // Jika ini barbershop pertama, set sebagai aktif
        $isActive = Barbershop::count() === 0 ? true : false;

        Barbershop::create([
            'is_active' => $isActive,
            'nama_brand' => $request->nama_brand,
            'favicon' => $faviconPath,
            'alaamat' => $request->alaamat,
            'email' => $request->email,
            'kontak' => $kontak,
            'warna_primer' => $request->warna_primer ?? '#e8a53a',
        ]);

        return redirect()->route('admin.barbershop.index')->with('success', 'Barbershop berhasil ditambahkan!');
    }

    public function edit(Barbershop $barbershop)
    {
        return view('admin.barbershop.edit', compact('barbershop'));
    }

    public function update(Request $request, Barbershop $barbershop)
    {
        $request->validate([
            'nama_brand' => 'required|string|max:255',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
            'alaamat' => 'required|string',
            'email' => 'required|email|max:255',
            'whatsapp' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'link_map' => 'nullable|string',
            'map_embed' => 'nullable|string',
            'warna_primer' => 'nullable|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $faviconPath = $barbershop->favicon;
        if ($request->hasFile('favicon')) {
            $faviconName = time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('assets/images'), $faviconName);
            $faviconPath = 'assets/images/' . $faviconName;
        }

        $kontak = [
            'whatsapp' => $request->whatsapp,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'link_map' => $barbershop->kontak['link_map'] ?? null,
            'map_embed' => $barbershop->kontak['map_embed'] ?? null,
        ];

        $barbershop->update([
            'nama_brand' => $request->nama_brand,
            'favicon' => $faviconPath,
            'alaamat' => $request->alaamat,
            'email' => $request->email,
            'kontak' => $kontak,
            'warna_primer' => $request->warna_primer ?? '#e8a53a',
        ]);

        return redirect()->route('admin.barbershop.index')->with('success', 'Barbershop berhasil diperbarui!');
    }

    public function destroy(Barbershop $barbershop)
    {
        if ($barbershop->is_active) {
            return redirect()->route('admin.barbershop.index')->with('error', 'Barbershop yang aktif tidak dapat dihapus!');
        }
        $barbershop->delete();
        return redirect()->route('admin.barbershop.index')->with('success', 'Barbershop berhasil dihapus!');
    }

    public function activateBarbershop(Request $request)
    {
        $activeBarbershop = Barbershop::where('is_active', true)->first();
        if ($activeBarbershop) {
            $activeBarbershop->is_active = false;
            $activeBarbershop->save();
        }

        $barbershop = Barbershop::findOrFail($request->id);
        $barbershop->is_active = true;
        $barbershop->save();

        return redirect()->route('admin.barbershop.index')->with('success', 'Barbershop berhasil diaktifkan!');
    }

    public function deactivateBarbershop(Request $request)
    {
        $barbershop = Barbershop::findOrFail($request->id);
        if ($barbershop->is_active) {
            $barbershop->is_active = false;
            $barbershop->save();
        }

        return redirect()->route('admin.barbershop.index')->with('success', 'Barbershop berhasil dinonaktifkan!');
    }
}
