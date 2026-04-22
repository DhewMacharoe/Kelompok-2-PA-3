<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuCafeController extends Controller
{
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
            'foto' => 'nullable|image',
            'is_available' => 'required|boolean'
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menus', 'public');
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
            'foto' => 'nullable|image',
            'is_available' => 'required|boolean'
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menu.index');
    }
}
