<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tenancy\Traits\BelongsToTenant;

class Layanan extends Model
{
    use BelongsToTenant;
    protected $table = 'layanans';

    protected static function booted()
    {
        static::saved(function ($model) {
            $tenantId = $model->barbershop_id ?? app('currentTenantId') ?? 1;
            \Illuminate\Support\Facades\Cache::forget("active_layanans_tenant_{$tenantId}");
        });

        static::deleted(function ($model) {
            $tenantId = $model->barbershop_id ?? app('currentTenantId') ?? 1;
            \Illuminate\Support\Facades\Cache::forget("active_layanans_tenant_{$tenantId}");
        });
    }

    protected $fillable = [
        'nama',
        'harga',
        'estimasi_waktu',
        'deskripsi',
        'ikon',
        'is_active',
        'user_id',
        'barbershop_id',
    ];

    public function tambahLayanan(array $data): bool
    {
        return $this->fill($data)->save();
    }

    public function updateLayanan(array $data): bool
    {
        return $this->update($data);
    }

    public function getDetailLayanan(): self
    {
        return $this;
    }

    public function antreans()
    {
        return $this->belongsToMany(Antrean::class, 'antrean_layanan', 'layanan_id', 'antrean_id')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
