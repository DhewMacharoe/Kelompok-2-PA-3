<?php

namespace App\Http\Controllers\Admin;

use App\Events\AntreanListUpdate;
use App\Events\AntreanUpdate;
use App\Http\Controllers\Controller;
use App\Models\Antrean;
use App\Models\Layanan;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AntreanController extends Controller
{
    public function index()
    {
        Antrean::cancelExpiredWaitingQueues();

        $validated = request()->validate([
            'tanggal' => ['nullable', 'date_format:Y-m-d'],
            'status' => ['nullable', Rule::in(['all', 'menunggu', 'selesai', 'batal'])],
        ]);

        $selectedTanggal = $validated['tanggal'] ?? null;
        $selectedStatus = $validated['status'] ?? 'menunggu';

        $layananAktif = Layanan::where('is_active', true)
            ->orderBy('nama', 'asc')
            ->get();

        $jumlahMenungguHariIni = Antrean::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Ambil data "sedang dilayani"
        $currentServing = Antrean::getQueueBeingServed();

        $antreans = Antrean::query()
            ->orderBy('created_at', 'asc')
            ->when($selectedStatus !== 'all', function ($query) use ($selectedStatus) {
                $query->where('status', $selectedStatus);
            })
            ->when($selectedTanggal, function ($query) use ($selectedTanggal, $selectedStatus) {
                $query->where(function ($dateQuery) use ($selectedTanggal, $selectedStatus) {
                    if (in_array($selectedStatus, ['selesai', 'batal'], true)) {
                        $dateQuery->whereDate('waktu_selesai', $selectedTanggal);
                        return;
                    }

                    if ($selectedStatus === 'all') {
                        $dateQuery->whereDate('created_at', $selectedTanggal)
                            ->orWhereDate('waktu_selesai', $selectedTanggal);
                        return;
                    }

                    $dateQuery->whereDate('created_at', $selectedTanggal);
                });
            })
            ->get();

        return view('admin.antrean.antrean', compact(
            'antreans',
            'layananAktif',
            'selectedTanggal',
            'selectedStatus',
            'currentServing',
            'jumlahMenungguHariIni'
        ));
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
            
            if ($antrean->user && $antrean->user->no_whatsapp) {
                WhatsAppService::sendPanggilan($antrean->user->no_whatsapp, $antrean);
            }
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
                
                if ($antrean->user && $antrean->user->no_whatsapp) {
                    WhatsAppService::sendBatal($antrean->user->no_whatsapp, $antrean, $request->alasan_batal ?? 'Dibatalkan oleh Admin');
                }
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
        $antreans = Antrean::whereIn('id', $ids)->whereIn('status', ['menunggu'])->get();
        
        $updatedCount = 0;
        foreach ($antreans as $antrean) {
            $antrean->update([
                'status' => 'batal',
                'alasan_batal' => $alasan,
                'waktu_selesai' => now(),
            ]);
            $updatedCount++;
            
            if ($antrean->user && $antrean->user->no_whatsapp) {
                WhatsAppService::sendBatal($antrean->user->no_whatsapp, $antrean, $alasan);
            }
        }

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

    public function tambahPelanggan()
    {
        return view('admin.tambah-pelanggan');
    }

    public function simpanPelanggan(Request $request)
    {
        if (!Antrean::isOperationalHour()) {
            return redirect()->back()->withErrors(['nama_pelanggan' => 'Antrean tidak dapat ditambah di luar jam operasional.'])->withInput();
        }

        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'layanan_id1' => [
                'required',
                Rule::exists('layanans', 'id')->where(function ($query) {
                    $query->where('is_active', true);
                }),
            ],
            'layanan_id2' => [
                'nullable',
                'different:layanan_id1',
                Rule::exists('layanans', 'id')->where(function ($query) {
                    $query->where('is_active', true);
                }),
            ],
        ], [
            'nama_pelanggan.required' => 'Harap isi nama terlebih dahulu',
            'layanan_id1.required'    => 'Harap pilih minimal 1 layanan',
        ]);

        // Generate nomor antrean dengan format 2-digit yang auto-reset per hari
        $nomorFormat = Antrean::generateDailyQueueNumber();

        // Simpan ke database
        $layananId1 = $request->input('layanan_id1');
        $layananId2 = $request->input('layanan_id2');

        $antrean = Antrean::create([
            'nomor_antrean_seq' => $nomorFormat,
            'nama_pelanggan' => $request->nama_pelanggan,
            'layanan_id1' => $layananId1,
            'layanan_id2' => $layananId2,
            'status' => 'menunggu',
            'waktu_masuk' => now()
        ]);

        $antrean->layanans()->sync(array_values(array_filter([$layananId1, $layananId2])));

        $this->broadcastQueueListUpdate();

        return redirect()->route('admin.antrean')->with('success', 'Pelanggan atas nama ' . $request->nama_pelanggan . ' berhasil ditambahkan ke antrean.');
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
}
