<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function lokasi()
    {
        $defaultConfig = config('queue_location.location', []);

        $latitude = \App\Models\Setting::get('queue_latitude', $defaultConfig['latitude'] ?? 2.33758);
        $longitude = \App\Models\Setting::get('queue_longitude', $defaultConfig['longitude'] ?? 99.079255);
        $radius = \App\Models\Setting::get('queue_radius_meters', $defaultConfig['radius_meters'] ?? 100);
        $jam_buka = \App\Models\Setting::get('queue_jam_buka', '09:00');
        $jam_tutup = \App\Models\Setting::get('queue_jam_tutup', '21:00');
        $keterangan_libur = \App\Models\Setting::get('queue_libur_note', 'libur');
        $is_booking_enabled = \App\Models\Setting::get('is_booking_enabled', '1');
        $activeDesign = \App\Models\Barbershop::where('is_active', true)->first();

        return view('admin.lokasi.index', compact('latitude', 'longitude', 'radius', 'jam_buka', 'jam_tutup', 'keterangan_libur', 'is_booking_enabled', 'activeDesign'));
    }

    public function simpanLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meters' => 'required|integer|min:1',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i',
            'keterangan_libur' => 'required|in:libur,buka',
            'is_booking_enabled' => 'required|in:1,0',
        ]);

        \App\Models\Setting::set('queue_latitude', $request->input('latitude'));
        \App\Models\Setting::set('queue_longitude', $request->input('longitude'));
        \App\Models\Setting::set('queue_radius_meters', $request->input('radius_meters'));
        \App\Models\Setting::set('queue_jam_buka', $request->input('jam_buka'));
        \App\Models\Setting::set('queue_jam_tutup', $request->input('jam_tutup'));
        \App\Models\Setting::set('queue_libur_note', $request->input('keterangan_libur'));
        \App\Models\Setting::set('is_booking_enabled', $request->input('is_booking_enabled'));

        return redirect()->back()->with('success', 'Pengaturan antrean berhasil diperbarui.');
    }
}
