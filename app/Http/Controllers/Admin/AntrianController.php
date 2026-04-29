<?php

namespace App\Http\Controllers\Admin;

use App\Events\AntreanListUpdate;
use App\Events\AntreanUpadate;
use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        $antrian = Antrian::getQueueBeingServed();

        return view('admin.antrian.test', compact('antrian'));
    }

    public function panggil(Request $request)
    {
        $antrian = Antrian::todayWaitingQueues()->first();

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada antrian yang menunggu.',
            ]);
        }

        $antrian->markAsServing();
        $this->broadcastQueueStatusUpdate($antrian);
        $this->broadcastQueueListUpdate();

        return response()->json([
            'success' => true,
            'message' => 'Antrian ' . $antrian->nomor_antrian . ' sedang dilayani.',
        ]);
    }

    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,batal',
        ]);

        $antrian = Antrian::findOrFail($id);
        
        if ($request->status === 'selesai') {
            $antrian->markAsComplete();
        } else {
            $antrian->cancelQueue();
        }

        $this->broadcastQueueStatusUpdate($antrian);
        $this->broadcastQueueListUpdate();

        return response()->json([
            'success' => true,
            'message' => 'Status antrian ' . $antrian->nomor_antrian . ' diubah menjadi ' . $request->status . '.',
        ]);
    }

    public function updateStatus(Request $request, Antrian $antrean)
    {
        $antrean->update(['status' => $request->status]);
        $this->broadcastQueueStatusUpdate($antrean);

        return back();
    }

    // ============ PRIVATE HELPERS ============

    private function broadcastQueueStatusUpdate(Antrian $antrian): void
    {
        broadcast(new AntreanUpadate($antrian));
    }

    private function broadcastQueueListUpdate(): void
    {
        $antrianList = Antrian::getTodayWaitingQueues();
        event(new AntreanListUpdate($antrianList));
    }
}
