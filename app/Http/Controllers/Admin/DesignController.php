<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Design;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function index()
    {
        $design = Design::first();
        if (!$design) {
            $design = Design::create([
                'is_active' => true,
                'nama_brand' => "Arga Home's",
                'favicon' => 'assets/images/logo.png',
                'alaamat' => 'Jl.P.Siantar Km 2, Tampubolon, Sibolahotangaso Kec. Balige, Tobasa, Sumatera Utara',
                'email' => 'joebarberid@gmail.com',
                'slogan' => 'Barber, Coffee & Food',
                'kontak' => [
                    'instagram' => 'https://instagram.com',
                    'facebook' => 'https://facebook.com',
                    'whatsapp' => '082167893019',
                    'link_map' => null,
                    'map_embed' => null,
                ],
            ]);
        }
        return view('admin.design_web.index', compact('design'));
    }

    public function create()
    {
        return view('admin.design_web.create');
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
            'slogan' => 'nullable|string|max:255',
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

        // Jika ini design pertama, set sebagai aktif
        $isActive = Design::count() === 0 ? true : false;

        Design::create([
            'is_active' => $isActive,
            'nama_brand' => $request->nama_brand,
            'favicon' => $faviconPath,
            'alaamat' => $request->alaamat,
            'email' => $request->email,
            'kontak' => $kontak,
            'warna_primer' => $request->warna_primer ?? '#e8a53a',
            'slogan' => $request->slogan ?? 'Barber, Coffee & Food',
        ]);

        return redirect()->route('admin.design.index')->with('success', 'Design berhasil ditambahkan!');
    }

    public function edit(Design $design)
    {
        return view('admin.design_web.edit', compact('design'));
    }

    public function update(Request $request, Design $design)
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
            'slogan' => 'nullable|string|max:255',
        ]);

        $faviconPath = $design->favicon;
        if ($request->hasFile('favicon')) {
            $faviconName = time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('assets/images'), $faviconName);
            $faviconPath = 'assets/images/' . $faviconName;
        }

        $kontak = [
            'whatsapp' => $request->whatsapp,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'link_map' => $design->kontak['link_map'] ?? null,
            'map_embed' => $design->kontak['map_embed'] ?? null,
        ];

        $design->update([
            'nama_brand' => $request->nama_brand,
            'favicon' => $faviconPath,
            'alaamat' => $request->alaamat,
            'email' => $request->email,
            'kontak' => $kontak,
            'warna_primer' => $request->warna_primer ?? '#e8a53a',
            'slogan' => $request->slogan ?? 'Barber, Coffee & Food',
        ]);

        return redirect()->route('admin.design.index')->with('success', 'Design berhasil diperbarui!');
    }

    public function destroy(Design $design)
    {
        if ($design->is_active) {
            return redirect()->route('admin.design.index')->with('error', 'Design yang aktif tidak dapat dihapus!');
        }
        $design->delete();
        return redirect()->route('admin.design.index')->with('success', 'Design berhasil dihapus!');
    }

    public function activateDesign(Request $request)
    {
        $activeDesign = Design::where('is_active', true)->first();
        if ($activeDesign) {
            $activeDesign->is_active = false;
            $activeDesign->save();
        }

        $design = Design::findOrFail($request->id);
        $design->is_active = true;
        $design->save();

        return redirect()->route('admin.design.index')->with('success', 'Design berhasil diaktifkan!');
    }

    public function deactivateDesign(Request $request)
    {
        $design = Design::findOrFail($request->id);
        if ($design->is_active) {
            $design->is_active = false;
            $design->save();
        }

        return redirect()->route('admin.design.index')->with('success', 'Design berhasil dinonaktifkan!');
    }
}
