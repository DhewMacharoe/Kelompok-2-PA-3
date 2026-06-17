<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesPublicImageUploads;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuCafeController extends Controller
{
    use HandlesPublicImageUploads;

    private function checkCafeActive()
    {
        $activeDesign = \App\Models\Design::where('is_active', true)->first();
        if ($activeDesign && !$activeDesign->is_cafe_active) {
            abort(404);
        }
    }

    public function index()
    {
        $this->checkCafeActive();

        $menus = Menu::orderByDesc('updated_at')->get();
        $categories = ['Makanan', 'Minuman'];

        return view('admin.menu.menu', compact('menus'));
    }

    public function create()
    {
        $this->checkCafeActive();

        return redirect()->route('admin.menu.index');
    }

    public function store(Request $request)
    {
        $this->checkCafeActive();

        $data = $request->validate([
            'nama' => 'required',
            'kategori' => 'required|string',
            'harga' => 'required|integer',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'required|boolean'
        ]);

        if ($request->hasFile('foto')) {
            $folder = 'menus';
            $data['foto'] = $this->storeImageToPublic($request->file('foto'), $folder);
        }

        Menu::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $this->checkCafeActive();

        return redirect()->route('admin.menu.index');
    }

    public function update(Request $request, Menu $menu)
    {
        $this->checkCafeActive();

        $data = $request->validate([
            'nama' => 'required',
            'kategori' => 'required|string',
            'harga' => 'required|integer',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'required|boolean'
        ]);

        if (!$request->filled('kategori')) {
            $data['kategori'] = $menu->kategori;
        }

        if ($request->hasFile('foto')) {
            $folder = 'menus';
            $this->deleteImageFromPublic($menu->foto);
            $data['foto'] = $this->storeImageToPublic($request->file('foto'), $folder);
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $this->checkCafeActive();

        $this->deleteImageFromPublic($menu->foto);

        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
