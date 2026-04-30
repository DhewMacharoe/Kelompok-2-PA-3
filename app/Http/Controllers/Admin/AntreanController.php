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
}
