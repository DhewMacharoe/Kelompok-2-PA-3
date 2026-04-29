<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Antrian extends Model
{
    protected $table = 'antrians';

    protected $fillable = [
        'nomor_antrian',
        'nama_pelanggan',
        'layanan_id1',
        'layanan_id2',
        'status',
        'waktu_masuk',
        'waktu_selesai',
    ];

    public static function generateNomorAntrian(): string
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
        return $this->belongsToMany(Layanan::class, 'antrian_layanan', 'antrian_id', 'layanan_id')
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
     * Scope untuk mengambil antrian menunggu hari ini yang sudah diurutkan
     */
    public function scopeTodayWaitingQueues($query)
    {
        return $query->where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc');
    }

    /**
     * Scope untuk mengambil antrian aktif (menunggu atau sedang dilayani) hari ini
     */
    public function scopeTodayActiveQueues($query)
    {
        return $query->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->whereDate('created_at', Carbon::today());
    }

    /**
     * Scope untuk mengambil antrian berdasarkan nama pelanggan hari ini
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
     * Ambil antrian yang sedang dilayani hari ini
     */
    public static function getQueueBeingServed()
    {
        return static::where('status', 'sedang dilayani')
            ->whereDate('created_at', Carbon::today())
            ->first();
    }

    /**
     * Cek apakah pelanggan sudah punya antrian aktif hari ini
     */
    public static function customerHasActiveQueue(string $namaCustomer): bool
    {
        return static::byCustomerName($namaCustomer)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->exists();
    }

    /**
     * Ambil antrian aktif pelanggan hari ini
     */
    public static function getCustomerActiveQueue(string $namaCustomer)
    {
        return static::byCustomerName($namaCustomer)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->orderBy('waktu_masuk', 'asc')
            ->first();
    }

    /**
     * Dapatkan nomor antrian terakhir hari ini
     */
    public static function getLastQueueNumberToday(): int
    {
        $lastAntrian = static::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastAntrian) {
            return 0;
        }

        return (int)$lastAntrian->nomor_antrian;
    }

    /**
     * Hitung posisi antrian pelanggan dalam daftar menunggu
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
     * Batalkan antrian dan set waktu selesai
     */
    public function cancelQueue(): bool
    {
        return $this->update([
            'status' => 'batal',
            'waktu_selesai' => now(),
        ]);
    }

    /**
     * Set antrian menjadi sedang dilayani
     */
    public function markAsServing(): bool
    {
        return $this->update(['status' => 'sedang dilayani']);
    }

    /**
     * Set antrian menjadi selesai
     */
    public function markAsComplete(): bool
    {
        return $this->update([
            'status' => 'selesai',
            'waktu_selesai' => now(),
        ]);
    }
}
