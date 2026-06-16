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
                'deskripsi_hero' => 'Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming terbaik!',
                'gambar_hero' => null,
                'judul_hero_layanan' => 'Daftar Layanan',
                'deskripsi_hero_layanan' => 'Lihat pilihan layanan yang tersedia beserta harga dan estimasi waktunya.',
                'gambar_hero_layanan' => null,
                'judul_hero_galeri' => 'Galeri Kami',
                'deskripsi_hero_galeri' => 'Lihat suasana barbershop, hasil potongan rambut, dan area coffee sebelum datang ke tempat.',
                'gambar_hero_galeri' => null,
                'judul_hero_menu' => 'Menu Café',
                'deskripsi_hero_menu' => 'Nikmati berbagai pilihan makanan dan minuman kopi yang tersedia di barbershop kami.',
                'gambar_hero_menu' => null,
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
            
            // Home Hero
            'deskripsi_hero' => 'required|string',
            'gambar_hero' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',

            // Layanan Hero
            'judul_hero_layanan' => 'required|string|max:255',
            'deskripsi_hero_layanan' => 'required|string',
            'gambar_hero_layanan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',

            // Galeri Hero
            'judul_hero_galeri' => 'required|string|max:255',
            'deskripsi_hero_galeri' => 'required|string',
            'gambar_hero_galeri' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',

            // Menu Cafe Hero
            'judul_hero_menu' => 'required|string|max:255',
            'deskripsi_hero_menu' => 'required|string',
            'gambar_hero_menu' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
        ]);

        $faviconPath = 'favicon.png';
        if ($request->hasFile('favicon')) {
            $faviconName = time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('assets/images'), $faviconName);
            $faviconPath = 'assets/images/' . $faviconName;
        }

        $gambarHeroPath = null;
        if ($request->hasFile('gambar_hero')) {
            $heroName = time() . '_' . uniqid() . '.' . $request->gambar_hero->extension();
            $request->gambar_hero->move(public_path('assets/images/hero'), $heroName);
            $gambarHeroPath = 'assets/images/hero/' . $heroName;
        }

        $gambarHeroLayananPath = null;
        if ($request->hasFile('gambar_hero_layanan')) {
            $heroName = time() . '_layanan_' . uniqid() . '.' . $request->gambar_hero_layanan->extension();
            $request->gambar_hero_layanan->move(public_path('assets/images/hero'), $heroName);
            $gambarHeroLayananPath = 'assets/images/hero/' . $heroName;
        }

        $gambarHeroGaleriPath = null;
        if ($request->hasFile('gambar_hero_galeri')) {
            $heroName = time() . '_galeri_' . uniqid() . '.' . $request->gambar_hero_galeri->extension();
            $request->gambar_hero_galeri->move(public_path('assets/images/hero'), $heroName);
            $gambarHeroGaleriPath = 'assets/images/hero/' . $heroName;
        }

        $gambarHeroMenuPath = null;
        if ($request->hasFile('gambar_hero_menu')) {
            $heroName = time() . '_menu_' . uniqid() . '.' . $request->gambar_hero_menu->extension();
            $request->gambar_hero_menu->move(public_path('assets/images/hero'), $heroName);
            $gambarHeroMenuPath = 'assets/images/hero/' . $heroName;
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
            
            'deskripsi_hero' => $request->deskripsi_hero,
            'gambar_hero' => $gambarHeroPath,
            'judul_hero_layanan' => $request->judul_hero_layanan,
            'deskripsi_hero_layanan' => $request->deskripsi_hero_layanan,
            'gambar_hero_layanan' => $gambarHeroLayananPath,
            'judul_hero_galeri' => $request->judul_hero_galeri,
            'deskripsi_hero_galeri' => $request->deskripsi_hero_galeri,
            'gambar_hero_galeri' => $gambarHeroGaleriPath,
            'judul_hero_menu' => $request->judul_hero_menu,
            'deskripsi_hero_menu' => $request->deskripsi_hero_menu,
            'gambar_hero_menu' => $gambarHeroMenuPath,
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
            
            // Home Hero
            'deskripsi_hero' => 'required|string',
            'gambar_hero' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',

            // Layanan Hero
            'judul_hero_layanan' => 'required|string|max:255',
            'deskripsi_hero_layanan' => 'required|string',
            'gambar_hero_layanan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',

            // Galeri Hero
            'judul_hero_galeri' => 'required|string|max:255',
            'deskripsi_hero_galeri' => 'required|string',
            'gambar_hero_galeri' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',

            // Menu Cafe Hero
            'judul_hero_menu' => 'required|string|max:255',
            'deskripsi_hero_menu' => 'required|string',
            'gambar_hero_menu' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
        ]);

        $faviconPath = $design->favicon;
        if ($request->hasFile('favicon')) {
            $faviconName = time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('assets/images'), $faviconName);
            $faviconPath = 'assets/images/' . $faviconName;
        }

        $gambarHeroPath = $design->gambar_hero;
        if ($request->hasFile('gambar_hero')) {
            if ($design->gambar_hero && file_exists(public_path($design->gambar_hero))) {
                @unlink(public_path($design->gambar_hero));
            }
            $heroName = time() . '_' . uniqid() . '.' . $request->gambar_hero->extension();
            $request->gambar_hero->move(public_path('assets/images/hero'), $heroName);
            $gambarHeroPath = 'assets/images/hero/' . $heroName;
        }

        $gambarHeroLayananPath = $design->gambar_hero_layanan;
        if ($request->hasFile('gambar_hero_layanan')) {
            if ($design->gambar_hero_layanan && file_exists(public_path($design->gambar_hero_layanan))) {
                @unlink(public_path($design->gambar_hero_layanan));
            }
            $heroName = time() . '_layanan_' . uniqid() . '.' . $request->gambar_hero_layanan->extension();
            $request->gambar_hero_layanan->move(public_path('assets/images/hero'), $heroName);
            $gambarHeroLayananPath = 'assets/images/hero/' . $heroName;
        }

        $gambarHeroGaleriPath = $design->gambar_hero_galeri;
        if ($request->hasFile('gambar_hero_galeri')) {
            if ($design->gambar_hero_galeri && file_exists(public_path($design->gambar_hero_galeri))) {
                @unlink(public_path($design->gambar_hero_galeri));
            }
            $heroName = time() . '_galeri_' . uniqid() . '.' . $request->gambar_hero_galeri->extension();
            $request->gambar_hero_galeri->move(public_path('assets/images/hero'), $heroName);
            $gambarHeroGaleriPath = 'assets/images/hero/' . $heroName;
        }

        $gambarHeroMenuPath = $design->gambar_hero_menu;
        if ($request->hasFile('gambar_hero_menu')) {
            if ($design->gambar_hero_menu && file_exists(public_path($design->gambar_hero_menu))) {
                @unlink(public_path($design->gambar_hero_menu));
            }
            $heroName = time() . '_menu_' . uniqid() . '.' . $request->gambar_hero_menu->extension();
            $request->gambar_hero_menu->move(public_path('assets/images/hero'), $heroName);
            $gambarHeroMenuPath = 'assets/images/hero/' . $heroName;
        }

        $kontak = [
            'whatsapp' => $request->whatsapp,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'link_map' => $request->link_map,
            'map_embed' => $request->map_embed,
        ];

        $design->update([
            'nama_brand' => $request->nama_brand,
            'favicon' => $faviconPath,
            'alaamat' => $request->alaamat,
            'email' => $request->email,
            'kontak' => $kontak,
            'warna_primer' => $request->warna_primer ?? '#e8a53a',
            'slogan' => $request->slogan ?? 'Barber, Coffee & Food',
            
            'deskripsi_hero' => $request->deskripsi_hero,
            'gambar_hero' => $gambarHeroPath,
            'judul_hero_layanan' => $request->judul_hero_layanan,
            'deskripsi_hero_layanan' => $request->deskripsi_hero_layanan,
            'gambar_hero_layanan' => $gambarHeroLayananPath,
            'judul_hero_galeri' => $request->judul_hero_galeri,
            'deskripsi_hero_galeri' => $request->deskripsi_hero_galeri,
            'gambar_hero_galeri' => $gambarHeroGaleriPath,
            'judul_hero_menu' => $request->judul_hero_menu,
            'deskripsi_hero_menu' => $request->deskripsi_hero_menu,
            'gambar_hero_menu' => $gambarHeroMenuPath,
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
