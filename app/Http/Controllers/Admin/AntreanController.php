<?php

namespace App\Http\Controllers\Admin;

use App\Events\AntreanListUpdate;
use App\Events\AntreanUpadate;
use App\Http\Controllers\Controller;
use App\Models\Antrean;
use Illuminate\Http\Request;

class AntreanController extends Controller
{
    public function index()
    {
        $antrean = Antrean::getQueueBeingServed();

        return view('admin.antrean.test', compact('antrean'));
    }

    public function panggil(Request $request)
    {
        $antrean = Antrean::todayWaitingQueues()->first();

        if (!$antrean) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada antrean yang menunggu.',
            ]);
        }

        $antrean->markAsServing();
        $this->broadcastQueueStatusUpdate($antrean);
        $this->broadcastQueueListUpdate();

        return response()->json([
            'success' => true,
            'message' => 'Antrean ' . $antrean->nomor_antrean . ' sedang dilayani.',
        ]);
    }

    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,batal',
        ]);

        $antrean = Antrean::findOrFail($id);

        if ($request->status === 'selesai') {
            $antrean->markAsComplete();
        } else {
            $antrean->cancelQueue();
        }

        $this->broadcastQueueStatusUpdate($antrean);
        $this->broadcastQueueListUpdate();

        return response()->json([
            'success' => true,
            'message' => 'Status antrean ' . $antrean->nomor_antrean . ' diubah menjadi ' . $request->status . '.',
        ]);
    }

    public function updateStatus(Request $request, Antrean $antrean)
    {
        $antrean->update(['status' => $request->status]);
        $this->broadcastQueueStatusUpdate($antrean);

        return back();
    }

    // ============ PRIVATE HELPERS ============

    private function broadcastQueueStatusUpdate(Antrean $antrean): void
    {
        broadcast(new AntreanUpadate($antrean));
    }

    private function broadcastQueueListUpdate(): void
    {
        $antreanList = Antrean::getTodayWaitingQueues();
        event(new AntreanListUpdate($antreanList));
    }

    public function simpanPelanggan(Request $request)
    {
        // 1. Validasi Input dengan Pesan Kustom
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'layanan_id1'    => 'required',
        ], [
            'nama_pelanggan.required' => 'Harap isi nama terlebih dahulu',
            'layanan_id1.required'    => 'Harap pilih minimal 1 layanan',
        ]);

        // 2. Buat Nomor Antrean Baru
        $lastNumber = Antrean::getLastQueueNumberToday();
        $nomorFormat = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

        // 3. Simpan Data ke Database
        $antrean = Antrean::create([
            'nomor_antrean'  => $nomorFormat,
            'nama_pelanggan' => $request->nama_pelanggan,
            'layanan_id1'    => $request->layanan_id1,
            'layanan_id2'    => $request->layanan_id2,
            'status'         => 'menunggu',
            'waktu_masuk'    => now()
        ]);

        // 4. Broadcast Update (Opsional, agar tampilan real-time terupdate)
        $this->broadcastQueueListUpdate();

        // 5. Kembali dengan pesan sukses
        return back()->with('success', 'Antrean baru berhasil ditambahkan.');
    }
}
