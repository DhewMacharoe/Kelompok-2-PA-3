<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
}
