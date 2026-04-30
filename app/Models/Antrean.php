<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Antrean extends Model
{
    protected $table = 'antreans';

    protected $fillable = [
        'nomor_antrean',
        'nama_pelanggan',
        'layanan_id1',
        'layanan_id2',
        'status',
        'waktu_masuk',
        'waktu_selesai',
    ];

    protected $dates = [
        'waktu_masuk',
        'waktu_selesai',
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
                'waktu_selesai' => now(),
            ]);
    }

    public function updateStatus(string $statusBaru): bool
    {
        $this->status = $statusBaru;

        if ($statusBaru === 'selesai') {
            $this->waktu_selesai = now();
        }

        return $this->save();
    }

    public function hitungEstimasiSelesai(): ?string
    {
        if (! $this->waktu_masuk) {
            return null;
        }

        return Carbon::parse($this->waktu_masuk)
            ->addMinutes($this->layanan1?->estimasi_waktu ?? 30)
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
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc');
    }

    /**
     * Scope untuk mengambil antrean aktif (menunggu atau sedang dilayani) hari ini
     */
    public function scopeTodayActiveQueues($query)
    {
        return $query->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->whereDate('created_at', Carbon::today());
    }

    /**
     * Scope untuk mengambil antrean berdasarkan nama pelanggan hari ini
     */
    public function scopeByCustomerName($query, $nama)
    {
        return $query->where('nama_pelanggan', $nama)
            ->whereDate('created_at', Carbon::today());
    }

    // ============ QUERY METHODS ============


    public static function getTodayWaitingQueues()
    {
        return static::todayWaitingQueues()->get();
    }

    /**
     * Ambil antrean yang sedang dilayani hari ini
     */
    public static function getQueueBeingServed()
    {
        return static::where('status', 'sedang dilayani')
            ->whereDate('created_at', Carbon::today())
            ->first();
    }

    /**
     * Cek apakah pelanggan sudah punya antrean aktif hari ini
     */
    public static function customerHasActiveQueue(string $namaCustomer): bool
    {
        return static::byCustomerName($namaCustomer)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->exists();
    }

    /**
     * Ambil antrean aktif pelanggan hari ini
     */
    public static function getCustomerActiveQueue(string $namaCustomer)
    {
        return static::byCustomerName($namaCustomer)
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

        if (!$lastAntrean || !$lastAntrean->nomor_antrean) {
            return 0;
        }

        // Ekstrak angka dari nomor_antrean (bisa format '01', '02', atau pure number)
        $nomorStr = (string)$lastAntrean->nomor_antrean;
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

        return static::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
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
}
