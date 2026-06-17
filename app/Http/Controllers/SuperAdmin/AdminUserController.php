<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Barbershop;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::role('admin')->with('barbershop')->get();
        return view('super_admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barbershops = Barbershop::all();
        return view('super_admin.admins.create', compact('barbershops'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:20|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'barbershop_id' => 'required|exists:barber_shops,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'barbershop_id' => $request->barbershop_id,
        ]);

        $user->assignRole('admin');

        return redirect()->route('super-admin.admins.index')->with('success', 'Admin Barbershop berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        $barbershops = Barbershop::all();
        return view('super_admin.admins.edit', compact('admin', 'barbershops'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:20|unique:users,username,' . $admin->id,
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8',
            'barbershop_id' => 'required|exists:barber_shops,id',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'barbershop_id' => $request->barbershop_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $admin->update($data);

        return redirect()->route('super-admin.admins.index')->with('success', 'Admin Barbershop berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect()->route('super-admin.admins.index')->with('success', 'Admin Barbershop berhasil dihapus.');
    }
}
