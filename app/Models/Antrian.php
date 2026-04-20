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
        'layanan_id',
        'status',
        'waktu_masuk',
        'waktu_selesai',
    ];

    public static function generateNomorAntrian(): string
    {
        return 'A' . now()->format('YmdHis') . rand(10, 99);
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
            ->addMinutes($this->layanan?->estimasi_waktu ?? 30)
            ->toDateTimeString();
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
