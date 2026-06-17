<?php

namespace App\Http\Controllers\Pelanggan;

use App\Events\AntreanListUpdate;
use App\Http\Controllers\Concerns\ValidatesQueueLocation;
use App\Http\Controllers\Controller;
use App\Models\Antrean;
use App\Models\Layanan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AntreanController extends Controller
{
    use ValidatesQueueLocation;

    public function index()
    {
        $data_antrean = Antrean::getTodayWaitingQueues();
        $dipanggil = Antrean::getQueueBeingServed();
        $layananAktif = Layanan::where('is_active', true)
            ->orderBy('nama', 'asc')
            ->get();

        $punyaAntreanAktif = false;
        $antreanSayaAktif = null;
        $posisiAntreanSaya = null;

        if (Auth::check() && Auth::user()->username) {
            $antreanSayaAktif = Antrean::with(['layanan1', 'layanan2'])
                ->byCustomerName(Auth::user()->username)
                ->todayActiveQueues()
                ->orderBy('waktu_masuk', 'asc')
                ->first();

            $punyaAntreanAktif = (bool) $antreanSayaAktif;

            if ($antreanSayaAktif && $antreanSayaAktif->status === 'menunggu') {
                $posisiAntreanSaya = $antreanSayaAktif->calculateQueuePosition();
            }
        }

        return view('pelanggan.antrean.antrean', compact(
            'data_antrean',
            'dipanggil',
            'punyaAntreanAktif',
            'layananAktif',
            'antreanSayaAktif',
            'posisiAntreanSaya'
        ));
    }

    public function create()
    {
        return view('antrean.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login.user')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return back()->with('error', 'Admin tidak diperbolehkan mengambil antrean.');
        }

        if (!$user->username || !$user->no_whatsapp) {
            return redirect()->route('set.username')->with('error', 'Silakan lengkapi profil terlebih dahulu untuk mengantri.');
        }

        $this->validateQueueRequest($request);

        if (!Antrean::isOperationalHour()) {
            $jam_buka = Setting::get('queue_jam_buka', '09:00');
            $jam_tutup =Setting::get('queue_jam_tutup', '21:00');
            return back()->with('error', 'Maaf, antrean ditutup. Jam operasional: '.$jam_buka.' - '.$jam_tutup);
        }

        if (Antrean::customerHasActiveQueue($user->username)) {
            return back()->with('error', 'Anda sudah berada di dalam daftar antrean saat ini.');
        }

        // Menentukan apakah ini booking
        $isBooking = $request->input('is_booking') === '1' || $request->input('is_booking') === 'true';

        if (!$isBooking) {
            $locationValidation = $request->validate([
                'user_latitude' => 'required|numeric|between:-90,90',
                'user_longitude' => 'required|numeric|between:-180,180',
            ], [
                'user_latitude.required' => 'Akses lokasi gagal. Silakan aktifkan GPS/location dan coba lagi.',
                'user_longitude.required' => 'Akses lokasi gagal. Silakan aktifkan GPS/location dan coba lagi.',
                'user_latitude.numeric' => 'Data lokasi tidak valid.',
                'user_longitude.numeric' => 'Data lokasi tidak valid.',
            ]);

            $queueLocation = $this->queueLocationConfig();
            $targetLatitude = (float) ($queueLocation['latitude'] ?? 0);
            $targetLongitude = (float) ($queueLocation['longitude'] ?? 0);
            $radiusMeters = (int) ($queueLocation['radius_meters'] ?? 200);

            if ($targetLatitude === 0.0 && $targetLongitude === 0.0) {
                return back()->with('error', 'Konfigurasi lokasi antrean belum tersedia.')->withInput();
            }

            $distanceMeters = $this->distanceInMeters(
                (float) $locationValidation['user_latitude'],
                (float) $locationValidation['user_longitude'],
                $targetLatitude,
                $targetLongitude
            );

            if ($distanceMeters > $radiusMeters) {
                return back()->with('error', 'Anda harus berada dalam radius maksimal ' . $radiusMeters . ' meter dari lokasi antrean untuk mengambil antrean.')->withInput();
            }
        }

        // Generate nomor antrean dengan format 2-digit yang auto-reset per hari
        $nomorFormat = Antrean::generateDailyQueueNumber();

        if ($isBooking) {
            $request->validate([
                'tanggal_booking' => 'required|date|after_or_equal:today',
                'waktu_booking' => 'required|date_format:H:i',
            ]);

            Antrean::create([
                'is_booking' => true,
                'tanggal_booking' => $request->tanggal_booking,
                'waktu_booking' => $request->waktu_booking,
                'nomor_antrean_seq' => $nomorFormat, // Nomor seq tetap digenerate tapi ini booking
                'nama_pelanggan' => $user->username,
                'user_id' => $user->id,
                'layanan_id1' => $request->input('layanan_id1'),
                'layanan_id2' => $request->input('layanan_id2'),
                'status' => 'menunggu', // Status booking
                'waktu_masuk' => $request->tanggal_booking . ' ' . $request->waktu_booking,
            ]);

            return back()->with('success', 'Booking berhasil dibuat untuk tanggal ' . $request->tanggal_booking . ' jam ' . $request->waktu_booking);
        } else {
            Antrean::create([
                'is_booking' => false,
                'nomor_antrean_seq' => $nomorFormat,
                'nama_pelanggan' => $user->username,
                'user_id' => $user->id,
                'layanan_id1' => $request->input('layanan_id1'),
                'layanan_id2' => $request->input('layanan_id2'),
                'status' => 'menunggu',
                'waktu_masuk' => now()
            ]);

            $this->broadcastQueueUpdate();

            return back()->with('success', 'Antrean anda terdaftar silahkan tunggu.');
        }
    }

    public function cancelMyQueue(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login.user')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'alasan_batal' => 'required|string|max:1000'
        ], [
            'alasan_batal.required' => 'Mohon isi form alasan pembatalan.'
        ]);

        $user = Auth::user();
        if (!$user->username || !$user->no_whatsapp) {
            return redirect()->route('set.username')->with('error', 'Silakan lengkapi profil terlebih dahulu.');
        }

        $antreanAktif = Antrean::getCustomerActiveQueue($user->username);

        if (!$antreanAktif) {
            return back()->with('error', 'Tidak ada antrean aktif yang bisa dibatalkan.');
        }

        $antreanAktif->update([
            'status' => 'batal',
            'alasan_batal' => $request->alasan_batal,
            'waktu_selesai' => now(),
        ]);
        $this->broadcastQueueUpdate();

        return back()->with('success', 'Antrean Anda berhasil dibatalkan.');
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'layanan_id1' => 'required|exists:layanans,id',
            'layanan_id2' => 'nullable|exists:layanans,id|different:layanan_id1',
        ]);

        $layanan1 = Layanan::find($request->layanan_id1);
        $layanan2 = Layanan::find($request->layanan_id2);

        $duration = (int) $layanan1->estimasi_waktu;
        if ($layanan2) {
            $duration += (int) $layanan2->estimasi_waktu;
        }

        // If duration is 0 for some reason, default to 30
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

    private function validateQueueRequest(Request $request): void
    {
        $request->validate([
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
            'layanan_id1.required' => 'Harap pilih minimal 1 layanan',
            'layanan_id2.different' => 'Layanan 2 tidak boleh sama dengan layanan 1',
        ]);
    }

    private function broadcastQueueUpdate(): void
    {
        try {
            $antreanList = Antrean::getTodayWaitingQueues();
            event(new AntreanListUpdate($antreanList));
        } catch (\Exception $e) {
            \Log::warning('Realtime broadcast failed: ' . $e->getMessage());
        }
        // broadcast(new AntreanListUpdate($antreanList))->toOthers();
    }
}
