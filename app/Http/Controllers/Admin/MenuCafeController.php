<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesPublicImageUploads;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuCafeController extends Controller
{
    use HandlesPublicImageUploads;

    public function index()
    {
        $menus = Menu::orderByDesc('updated_at')->get();

        return view('admin.menu', compact('menus'));
    }

    public function create()
    {
        return redirect()->route('admin.menu.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
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

        return redirect()->route('admin.menu.index');
    }

    public function edit(Menu $menu)
    {
        return redirect()->route('admin.menu.index');
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'nama' => 'required',
            'harga' => 'required|integer',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'required|boolean'
        ]);

        if ($request->hasFile('foto')) {
            $folder = 'menus';
            $this->deleteImageFromPublic($menu->foto);
            $data['foto'] = $this->storeImageToPublic($request->file('foto'), $folder);
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index');
    }

    public function destroy(Menu $menu)
    {
        $this->deleteImageFromPublic($menu->foto);

        $menu->delete();

        return redirect()->route('admin.menu.index');
    }
}
