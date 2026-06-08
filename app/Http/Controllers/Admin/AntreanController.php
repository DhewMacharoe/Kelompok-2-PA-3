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
        $sedangDilayani = Antrean::getQueueBeingServed();

        if ($sedangDilayani) {
            return response()->json([
                'success' => false,
                'message' => 'Antrean ' . $sedangDilayani->nomor_antrean_seq . ' masih sedang dilayani. Selesaikan atau batalkan dulu sebelum memanggil antrean berikutnya.',
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
                ? 'Antrean ' . $antrean->nomor_antrean_seq . ' sedang dilayani.'
                : 'Gagal memanggil antrean.',
            'antrean' => $antrean
        ]);
    }

    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,batal',
            'alasan_batal' => 'nullable|string',
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
                $message = 'Status antrean ' . $antrean->nomor_antrean_seq . ' berhasil diubah menjadi selesai.';
            }
        } else {
            // Cancel queue manually
            if (!in_array($antrean->status, ['menunggu', 'sedang dilayani'])) {
                $success = false;
                $message = 'Antrean hanya bisa dibatalkan jika menunggu atau sedang dilayani.';
            } else {
                $antrean->update([
                    'status' => 'batal',
                    'alasan_batal' => $request->alasan_batal,
                    'waktu_selesai' => now(),
                ]);
                $success = true;
                $message = 'Status antrean ' . $antrean->nomor_antrean_seq . ' berhasil diubah menjadi batal.';
            }
        }

        if ($success) {
            $this->broadcastQueueStatusUpdate($antrean);
            $this->broadcastQueueListUpdate();
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'antrean' => $antrean,
        ]);
    }

    public function batalMasal(Request $request)
    {
        $request->validate([
            'queue_ids' => 'required|array',
            'queue_ids.*' => 'integer',
            'alasan_batal' => 'required|string'
        ]);

        $ids = $request->queue_ids;
        $alasan = $request->alasan_batal;

        // Cancel the selected queues
        $updatedCount = Antrean::whereIn('id', $ids)
            ->whereIn('status', ['menunggu'])
            ->update([
                'status' => 'batal',
                'alasan_batal' => $alasan,
                'waktu_selesai' => now(),
            ]);

        if ($updatedCount > 0) {
            $this->broadcastQueueListUpdate();
        }

        return response()->json([
            'success' => true,
            'message' => $updatedCount . ' antrean berhasil dibatalkan.'
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
        try {
            broadcast(new AntreanUpdate($antrean));
        } catch (\Exception $e) {
            \Log::warning('Realtime broadcast status update failed: ' . $e->getMessage());
        }
    }

    private function broadcastQueueListUpdate(): void
    {
        try {
            $antreanList = Antrean::getTodayWaitingQueues();
            event(new AntreanListUpdate($antreanList));
        } catch (\Exception $e) {
            \Log::warning('Realtime broadcast list update failed: ' . $e->getMessage());
        }
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
            'nomor_antrean_seq'  => $nomorFormat,
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
