<?php

namespace App\Http\Controllers\Admin;

use App\Events\AntreanListUpdate;
use App\Events\AntreanUpdate;
use App\Http\Controllers\Controller;
use App\Models\Antrean;
use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\WhatsAppService;

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

        $now = Carbon::now();

        if ($antrean->is_booking) {
            $waktuBooking = Carbon::parse($antrean->tanggal_booking . ' ' . $antrean->waktu_booking);
            if ($now->lessThan($waktuBooking)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memanggil. Antrean pertama adalah booking untuk jam ' . Carbon::parse($antrean->waktu_booking)->format('H:i') . ' (belum waktunya).'
                ]);
            }
        } else {
            // Ini antrean walk-in. Cek apakah ada booking yang akan bertabrakan dengan estimasi waktu walk-in ini.
            $estimasiMenit = $antrean->total_estimasi_waktu ?? 30;
            $waktuSelesaiMaks = $now->copy()->addMinutes($estimasiMenit);

            $upcomingBooking = Antrean::where('is_booking', true)
                ->where('status', 'menunggu')
                ->whereDate('tanggal_booking', Carbon::today())
                ->orderBy('waktu_booking', 'asc')
                ->first();

            if ($upcomingBooking) {
                $waktuBookingNext = Carbon::parse($upcomingBooking->tanggal_booking . ' ' . $upcomingBooking->waktu_booking);
                if ($waktuSelesaiMaks->greaterThan($waktuBookingNext)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal memanggil antrean walk-in. Melayani pelanggan ini memakan waktu ' . $estimasiMenit . ' menit dan akan melewati jadwal booking pada jam ' . Carbon::parse($upcomingBooking->waktu_booking)->format('H:i') . '.'
                    ]);
                }
            }
        }

        $success = $antrean->markAsServing();

        if ($success) {
            $this->broadcastQueueStatusUpdate($antrean);
            $this->broadcastQueueListUpdate();

            if ($antrean->user && $antrean->user->no_whatsapp) {
                WhatsAppService::sendPanggilan($antrean->user->no_whatsapp, $antrean);
            }

            // Notify next 1-2 queues
            $nextQueues = Antrean::todayWaitingQueues()
                ->where('is_notified_near', false)
                ->take(2)
                ->get();

            foreach ($nextQueues as $index => $nextQueue) {
                if ($nextQueue->user && $nextQueue->user->no_whatsapp) {
                    $jarak = $index + 1; // 1 or 2
                    WhatsAppService::sendPengingatDekat($nextQueue->user->no_whatsapp, $nextQueue, $jarak);
                }
                // Mark as notified whether they have whatsapp or not to prevent retries
                $nextQueue->update(['is_notified_near' => true]);
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
            'batal_oleh' => 'nullable|in:admin,no_show',
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
                if ($antrean->user && $antrean->user->no_whatsapp) {
                    WhatsAppService::sendSelesai($antrean->user->no_whatsapp, $antrean);
                }
            }
        } else {
            // Cancel queue manually
            if (!in_array($antrean->status, ['menunggu', 'sedang dilayani'])) {
                $success = false;
                $message = 'Antrean hanya bisa dibatalkan jika menunggu or sedang dilayani.';
            } else {
                $antrean->update([
                    'status' => 'batal',
                    'alasan_batal' => $request->alasan_batal,
                    'waktu_selesai' => now(),
                    'batal_oleh' => $request->input('batal_oleh', 'admin'),
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
        $isBooking = $request->input('is_booking') === '1' || $request->input('is_booking') === 'true';

        if (!$isBooking && !Antrean::isOperationalHour()) {
            return redirect()->back()->withErrors(['nama_pelanggan' => 'Antrean langsung (Walk-in) tidak dapat ditambah di luar jam operasional.'])->withInput();
        }

        if (Antrean::customerHasActiveQueue($request->input('nama_pelanggan'))) {
            return redirect()->back()->withErrors(['nama_pelanggan' => 'Pelanggan atas nama ini sudah memiliki antrean atau booking aktif.'])->withInput();
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
        // Generate nomor antrean dengan format 2-digit yang auto-reset per hari
        $nomorFormat = Antrean::generateDailyQueueNumber();

        // Simpan ke database
        $layananId1 = $request->input('layanan_id1');
        $layananId2 = $request->input('layanan_id2');

        if ($isBooking) {
            $request->validate([
                'tanggal_booking' => 'required|date|after_or_equal:today',
                'waktu_booking' => 'required|date_format:H:i',
            ]);

            $antrean = Antrean::create([
                'is_booking' => true,
                'tanggal_booking' => $request->tanggal_booking,
                'waktu_booking' => $request->waktu_booking,
                'nomor_antrean_seq' => $nomorFormat,
                'nama_pelanggan' => $request->nama_pelanggan,
                'layanan_id1' => $layananId1,
                'layanan_id2' => $layananId2,
                'status' => 'menunggu',
                'waktu_masuk' => $request->tanggal_booking . ' ' . $request->waktu_booking
            ]);

            $antrean->layanans()->sync(array_values(array_filter([$layananId1, $layananId2])));
            
            $this->broadcastQueueListUpdate();
            
            return redirect()->route('admin.antrean')->with('success', 'Booking atas nama ' . $request->nama_pelanggan . ' berhasil ditambahkan untuk tanggal ' . $request->tanggal_booking . ' jam ' . $request->waktu_booking . '.');
        } else {
            $antrean = Antrean::create([
                'is_booking' => false,
                'nomor_antrean_seq' => $nomorFormat,
                'nama_pelanggan' => $request->nama_pelanggan,
                'layanan_id1' => $layananId1,
                'layanan_id2' => $layananId2,
                'status' => 'menunggu',
                'waktu_masuk' => now()
            ]);

            $antrean->layanans()->sync(array_values(array_filter([$layananId1, $layananId2])));

            $this->broadcastQueueListUpdate();

            return redirect()->route('admin.antrean')->with('success', 'Pelanggan atas nama ' . $request->nama_pelanggan . ' berhasil ditambahkan ke antrean walk-in.');
        }
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'layanan_id1' => 'required|exists:layanans,id',
            'layanan_id2' => 'nullable|exists:layanans,id|different:layanan_id1',
        ]);

        $layanan1 = \App\Models\Layanan::find($request->layanan_id1);
        $layanan2 = \App\Models\Layanan::find($request->layanan_id2);
        $duration = (int) $layanan1->estimasi_waktu;
        if ($layanan2) {
            $duration += (int) $layanan2->estimasi_waktu;
        }

        if ($duration <= 0) {
            $duration = 30;
        }

        $slots = Antrean::getAvailableTimeSlots($request->date, $duration);

        return response()->json([
            'status' => 'success',
            'slots' => $slots,
            'duration' => $duration
        ]);
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
