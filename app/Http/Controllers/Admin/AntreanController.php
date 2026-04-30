<?php

namespace App\Http\Controllers\Admin;

use App\Events\AntreanListUpdate;
use App\Events\AntreanUpdate;
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

        // Validasi: tidak boleh ada antrean yang sedang dilayani
        $sedangDilayani = Antrean::where('status', 'sedang dilayani')
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->first();

        if ($sedangDilayani) {
            return response()->json([
                'success' => false,
                'message' => 'Antrean ' . $sedangDilayani->nomor_antrean . ' masih sedang dilayani. Selesaikan atau batalkan dulu sebelum memanggil antrean berikutnya.',
            ]);
        }

        $success = $antrean->markAsServing();

        if ($success) {
            $this->broadcastQueueStatusUpdate($antrean);
            $this->broadcastQueueListUpdate();
        }

        return response()->json([
            'success' => $success,
            'message' => $success 
                ? 'Antrean ' . $antrean->nomor_antrean . ' sedang dilayani.'
                : 'Gagal memanggil antrean.',
        ]);
    }

    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,batal',
        ]);

        $antrean = Antrean::findOrFail($id);

        $statusBaru = $request->status;
        $success = false;
        $message = 'Status tidak dapat diubah';

        if ($statusBaru === 'selesai') {
            $success = $antrean->markAsComplete();
            if (!$success) {
                $message = 'Antrean hanya bisa diselesaikan jika sedang dilayani.';
            } else {
                $message = 'Status antrean ' . $antrean->nomor_antrean . ' berhasil diubah menjadi selesai.';
            }
        } else {
            $success = $antrean->cancelQueue();
            if (!$success) {
                $message = 'Antrean hanya bisa dibatalkan jika menunggu atau sedang dilayani.';
            } else {
                $message = 'Status antrean ' . $antrean->nomor_antrean . ' berhasil diubah menjadi batal.';
            }
        }

        if ($success) {
            $this->broadcastQueueStatusUpdate($antrean);
            $this->broadcastQueueListUpdate();
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
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
        broadcast(new AntreanUpdate($antrean));
    }

    private function broadcastQueueListUpdate(): void
    {
        $antreanList = Antrean::getTodayWaitingQueues();
        event(new AntreanListUpdate($antreanList));
    }
}
