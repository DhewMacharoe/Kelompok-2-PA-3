<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Galeri extends Model
{
    protected $table = 'galeris';

    protected $fillable = [
        'nama',
        'bentuk_wajah',
        'deskripsi',
        'foto',
        'is_active',
    ];

    public function uploadGambar(UploadedFile|string $file): bool
    {
        if ($file instanceof UploadedFile) {
            $this->foto = $file->store('galeri', 'public');
            return $this->save();
        }

        return false;
    }

    public function analisisBentukWajah(): string
    {
        return "Rekomendasi model untuk bentuk wajah {$this->bentuk_wajah}.";
    }

    public function getRekomendasiModel(): array
    {
        return [
            "Model 1 untuk {$this->bentuk_wajah}",
            "Model 2 untuk {$this->bentuk_wajah}",
        ];
    }
}
