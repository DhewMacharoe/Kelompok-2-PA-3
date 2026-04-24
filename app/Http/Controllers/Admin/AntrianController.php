<?php

namespace App\Http\Controllers\Admin;

use App\Events\AntreanListUpdate;
use App\Events\AntreanUpadate;
use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,batal',
        ]);

        $antrian = Antrian::findOrFail($id);
        $antrian->update([
            'status' => $request->status,
            'waktu_selesai' => $request->status === 'selesai' ? now() : null,
        ]);
        event(new AntreanUpadate($antrian));

        $antrianList = Antrian::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc')
            ->get();

        event(new AntreanListUpdate($antrianList));

        return response()->json([
            'success' => true,
            'message' => 'Status antrian ' . $antrian->nomor_antrian . ' diubah menjadi ' . $request->status . '.',
        ]);
    }

    public function panggil(Request $request)
    {
        $antrian = Antrian::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc')
            ->first();

        if ($antrian) {
            $antrian->update(['status' => 'sedang dilayani']);

            event(new AntreanUpadate($antrian));

            $antrianList = Antrian::where('status', 'menunggu')
                ->whereDate('created_at', Carbon::today())
                ->orderBy('waktu_masuk', 'asc')
                ->get();

            event(new AntreanListUpdate($antrianList));

            return response()->json([
                'success' => true,
                'message' => 'Antrian ' . $antrian->nomor_antrian . ' sedang dilayani.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada antrian yang menunggu.',
        ]);
    }

    public function updateStatus(Request $request, Antrian $antrean)
    {
        $antrean->update(['status' => $request->status]);

        event(new AntreanUpadate($antrean));

        return back();
    }

    public function index()
    {
        $antrian = Antrian::where('status', 'sedang dilayani')
            ->whereDate('created_at', Carbon::today())
            ->first();

        return view('admin.antrian.test', compact('antrian'));
    }
}
