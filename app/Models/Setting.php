<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tenancy\Traits\BelongsToTenant;

class Setting extends Model
{
    use BelongsToTenant;
    protected $table = 'settings';
    protected $fillable = ['key', 'value', 'barbershop_id'];

    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, $value): void
    {
        $tenantId = app('currentTenantId') ?? null;
        static::updateOrCreate(
            ['key' => $key, 'barbershop_id' => $tenantId],
            ['value' => $value]
        );
    }
}
