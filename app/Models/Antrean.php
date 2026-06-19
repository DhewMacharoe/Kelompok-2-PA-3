<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Tenancy\Traits\BelongsToTenant;

class Antrean extends Model
{
    use BelongsToTenant;

    protected $table = 'antreans';

    protected $fillable = [
        'nomor_antrean',
        'nomor_antrean_seq',
        'nama_pelanggan',
        'layanan_id1',
        'layanan_id2',
        'status',
        'alasan_batal',
        'waktu_masuk',
        'is_booking',
        'tanggal_booking',
        'waktu_booking',
        'waktu_selesai',
        'user_id',
        'barbershop_id',
    ];

    protected $appends = [
        'total_estimasi_waktu',
    ];

    protected $dates = [
        'waktu_masuk',
        'waktu_selesai',
        'tanggal_booking',
        'created_at',
        'updated_at',
    ];

    public static function generateNomorAntrean(): string
    {
        return 'A' . now()->format('YmdHis') . rand(10, 99);
    }

    public static function cancelExpiredWaitingQueues(?Carbon $referenceDate = null): int
    {
        $today = ($referenceDate ?? Carbon::today())->toDateString();

        return static::where('status', 'menunggu')
            ->whereDate('created_at', '<', $today)
            ->update([
                'status' => 'batal',
                'alasan_batal' => 'Sudah lewat hari',
                'waktu_selesai' => now(),
            ]);
    }

    public static function isOperationalHour(): bool
    {
        $jam_buka = \App\Models\Setting::get('queue_jam_buka', '09:00');
        $jam_tutup = \App\Models\Setting::get('queue_jam_tutup', '21:00');
        $now = now()->format('H:i');

        return $now >= $jam_buka && $now <= $jam_tutup;
    }

    public static function getAvailableTimeSlots($date, $durationMinutes = 30): array
    {
        $jam_buka = \App\Models\Setting::get('queue_jam_buka', '09:00');
        $jam_tutup = \App\Models\Setting::get('queue_jam_tutup', '21:00');

        $isToday = Carbon::parse($date)->isToday();
        $dateObj = Carbon::parse($date);
        $startTime = Carbon::parse($date . ' ' . $jam_buka);
        $endTime = Carbon::parse($date . ' ' . $jam_tutup);

        if ($isToday) {
            // Check walk-in queues and active bookings for today to calculate when the shop will be free.
            // But wait, the prompt asks for available slots.
            // We should find the start time of availability.
            $activeQueues = static::whereIn('status', ['menunggu', 'sedang dilayani'])
                                  ->whereDate('created_at', Carbon::today())
                                  ->where('is_booking', false)
                                  ->get();

            $totalMins = 0;
            foreach ($activeQueues as $q) {
                if ($q->status === 'sedang dilayani') {
                    $elapsed = now()->diffInMinutes($q->updated_at);
                    $totalMins += max(0, $q->total_estimasi_waktu - $elapsed);
                } else {
                    $totalMins += $q->total_estimasi_waktu;
                }
            }

            $earliestAvailable = now()->addMinutes($totalMins);
            if ($earliestAvailable->greaterThan($startTime)) {
                $startTime = $earliestAvailable;
            }
        }

        // Fetch bookings for that date
        $bookings = static::where('is_booking', true)
                          ->whereDate('tanggal_booking', $date)
                          ->whereIn('status', ['menunggu', 'booking']) // Include future bookings
                          ->get();

        $slots = [];
        $currentSlot = $startTime->copy();

        // Round up to nearest 30 mins
        $minute = $currentSlot->minute;
        if ($minute > 0 && $minute <= 30) {
            $currentSlot->minute(30)->second(0);
        } elseif ($minute > 30) {
            $currentSlot->addHour()->minute(0)->second(0);
        }

        while ($currentSlot->copy()->addMinutes($durationMinutes)->lessThanOrEqualTo($endTime)) {
            $slotEnd = $currentSlot->copy()->addMinutes($durationMinutes);
            $isConflict = false;

            foreach ($bookings as $booking) {
                $bStart = Carbon::parse($booking->tanggal_booking->format('Y-m-d') . ' ' . $booking->waktu_booking);
                $bEnd = $bStart->copy()->addMinutes($booking->total_estimasi_waktu);

                // If current slot overlaps with this booking
                if ($currentSlot->lessThan($bEnd) && $slotEnd->greaterThan($bStart)) {
                    $isConflict = true;
                    break;
                }
            }

            if (!$isConflict && $currentSlot->greaterThan(now())) {
                $slots[] = $currentSlot->format('H:i');
            }

            // Move to next 30 min slot
            $currentSlot->addMinutes(30);
        }

        return $slots;
    }


    public function updateStatus(string $statusBaru): bool
    {
        $this->status = $statusBaru;

        if ($statusBaru === 'selesai') {
            $this->waktu_selesai = now();
        }

        return $this->save();
    }

    public function getTotalEstimasiWaktuAttribute(): int
    {
        $total = 0;

        $layanans = $this->layananUntukRekap();
        foreach ($layanans as $layanan) {
            if ($layanan && $layanan->estimasi_waktu) {
                // Konversi string (misal "30") ke int
                $total += (int) $layanan->estimasi_waktu;
            }
        }

        // Jika tidak ada estimasi dari layanan, default ke 30 menit
        return $total > 0 ? $total : 30;
    }

    public function hitungEstimasiSelesai(): ?string
    {
        if (! $this->waktu_masuk) {
            return null;
        }

        return Carbon::parse($this->waktu_masuk)
            ->addMinutes($this->total_estimasi_waktu)
            ->toDateTimeString();
    }

    public function layanan1()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id1');
    }

    public function layanan2()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id2');
    }

    public function layanans()
    {
        return $this->belongsToMany(Layanan::class, 'antrean_layanan', 'antrean_id', 'layanan_id')
            ->withTimestamps();
    }

    public function layananUntukRekap(): Collection
    {
        $layanans = $this->relationLoaded('layanans')
            ? $this->layanans
            : $this->layanans()->get();

        if ($layanans->isNotEmpty()) {
            return $layanans->unique('id')->values();
        }

        return collect([
            $this->relationLoaded('layanan1') ? $this->layanan1 : $this->layanan1()->first(),
            $this->relationLoaded('layanan2') ? $this->layanan2 : $this->layanan2()->first(),
        ])->filter()->unique('id')->values();
    }

    public function totalPemasukanRekap(): int
    {
        return $this->layananUntukRekap()->sum('harga');
    }

    // ============ SCOPES ============

    /**
     * Scope untuk mengambil antrean menunggu hari ini yang sudah diurutkan
     */
    public function scopeTodayWaitingQueues($query)
    {
        return $query->where('status', 'menunggu')
            ->whereDate('waktu_masuk', Carbon::today())
            ->orderBy('waktu_masuk', 'asc');
    }

    /**
     * Scope untuk mengambil antrean aktif (menunggu atau sedang dilayani) hari ini
     */
    public function scopeTodayActiveQueues($query)
    {
        return $query->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->whereDate('waktu_masuk', Carbon::today());
    }

    /**
     * Scope untuk mengambil antrean aktif (menunggu atau sedang dilayani)
     */
    public function scopeActiveQueues($query)
    {
        return $query->whereIn('status', ['menunggu', 'sedang dilayani']);
    }

    /**
     * Scope untuk mengambil antrean berdasarkan nama pelanggan hari ini
     */
    public function scopeByCustomerName($query, $nama)
    {
        return $query->where('nama_pelanggan', $nama);
    }

    // ============ QUERY METHODS ============


    public static function getTodayWaitingQueues()
    {
        return static::todayWaitingQueues()->get();
    }

    /**
     * Ambil antrean yang sedang dilayani
     */
    public static function getQueueBeingServed()
    {
        return static::where('status', 'sedang dilayani')
            ->first();
    }

    /**
     * Cek apakah pelanggan sudah punya antrean aktif di seluruh cabang barbershop
     */
    public static function customerHasActiveQueue(string $namaCustomer): bool
    {
        return static::withoutGlobalScopes()
            ->byCustomerName($namaCustomer)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->exists();
    }

    /**
     * Ambil antrean aktif pelanggan hari ini
     */
    public static function getCustomerActiveQueue(string $namaCustomer)
    {
        return static::withoutGlobalScopes()
            ->byCustomerName($namaCustomer)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->orderBy('waktu_masuk', 'asc')
            ->first();
    }

    /**
     * Dapatkan nomor antrean terakhir hari ini
     * Return: integer (0 jika tidak ada, atau nomor terakhir)
     */
    public static function getLastQueueNumberToday(): int
    {
        $lastAntrean = static::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastAntrean || !$lastAntrean->nomor_antrean_seq) {
            return 0;
        }

        // Ekstrak angka dari nomor_antrean_seq (bisa format '01', '02', atau pure number)
        $nomorStr = (string)$lastAntrean->nomor_antrean_seq;
        $nomor = (int)$nomorStr;

        return $nomor >= 0 ? $nomor : 0;
    }

    /**
     * Generate nomor antrean dengan format 2-digit (01, 02, ..., 99)
     * Reset otomatis setiap hari
     */
    public static function generateDailyQueueNumber(): string
    {
        $lastNumber = static::getLastQueueNumberToday();
        $nextNumber = $lastNumber + 1;

        // Jika sudah mencapai 99, warn (tapi tetap simpan)
        if ($nextNumber > 99) {
            \Log::warning('Queue number exceeded 99 on ' . Carbon::today());
        }

        return str_pad((string)$nextNumber, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Hitung posisi antrean pelanggan dalam daftar menunggu
     */
    public function calculateQueuePosition(): int
    {
        if ($this->status !== 'menunggu') {
            return 0;
        }

        return static::withoutGlobalScopes()
            ->where('barbershop_id', $this->barbershop_id)
            ->where('status', 'menunggu')
            ->whereDate('waktu_masuk', Carbon::parse($this->waktu_masuk)->toDateString())
            ->where(function ($query) {
                $query->where('waktu_masuk', '<', $this->waktu_masuk)
                    ->orWhere(function ($sameTimeQuery) {
                        $sameTimeQuery->where('waktu_masuk', $this->waktu_masuk)
                            ->where('id', '<=', $this->id);
                    });
            })
            ->count();
    }

    /**
     * Batalkan antrean dan set waktu selesai
     */
    public function cancelQueue(): bool
    {
        // Validasi: hanya bisa batalkan jika menunggu atau sedang dilayani
        if (!in_array($this->status, ['menunggu', 'sedang dilayani'])) {
            return false;
        }

        return $this->update([
            'status' => 'batal',
            'waktu_selesai' => now(),
        ]);
    }

    /**
     * Set antrean menjadi sedang dilayani
     */
    public function markAsServing(): bool
    {
        // Validasi: hanya bisa mulai dilayani jika masih menunggu
        if ($this->status !== 'menunggu') {
            return false;
        }

        return $this->update(['status' => 'sedang dilayani']);
    }

    /**
     * Set antrean menjadi selesai
     */
    public function markAsComplete(): bool
    {
        // Validasi: hanya bisa selesai jika sedang dilayani
        if ($this->status !== 'sedang dilayani') {
            return false;
        }

        return $this->update([
            'status' => 'selesai',
            'waktu_selesai' => now(),
        ]);
    }

    /**
     * Get the user that owns the antrean.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
