<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Antrean;
use App\Models\Galeri;
use App\Models\Layanan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'firebase_uid',
        'no_whatsapp',
        'barbershop_id',
        'is_blocked',
        'blocked_reason',
        'blocked_at',
        'reset_risk_at',
    ];

    public function barbershop()
    {
        return $this->belongsTo(Barbershop::class, 'barbershop_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kelolaLayanan()
    {
        return Layanan::all();
    }

    public function kelolaGaleri()
    {
        return Galeri::all();
    }

    public function pantauAntrean()
    {
        return Antrean::all();
    }
    public function antreans()
    {
        return $this->hasMany(Antrean::class);
    }

    public function blockHistories()
    {
        return $this->hasMany(BlockHistory::class, 'user_id');
    }

    /**
     * Get user's active antreans/bookings query, optionally starting from reset_risk_at.
     */
    public function scopedAntreans()
    {
        $query = $this->antreans();
        if ($this->reset_risk_at) {
            $query->where('created_at', '>', $this->reset_risk_at);
        }
        return $query;
    }

    public function totalBookings()
    {
        return $this->scopedAntreans()->where('is_booking', true)->count();
    }

    public function customerCancellationsCount()
    {
        return $this->scopedAntreans()->where('status', 'batal')->where('batal_oleh', 'pelanggan')->count();
    }

    public function noShowsCount()
    {
        return $this->scopedAntreans()->where('status', 'batal')->where('batal_oleh', 'no_show')->count();
    }

    public function cancellationPercentage()
    {
        $total = $this->totalBookings();
        if ($total === 0) {
            return 0.0;
        }
        $violatingCancellations = $this->customerCancellationsCount() + $this->noShowsCount();
        return round(($violatingCancellations / $total) * 100, 1);
    }

    public function lastActivity()
    {
        $latestAntrean = $this->antreans()->latest('created_at')->first();
        return $latestAntrean ? $latestAntrean->created_at : $this->updated_at;
    }

    public function riskLevel()
    {
        $total = $this->totalBookings();
        $violations = $this->customerCancellationsCount() + $this->noShowsCount();
        $percentage = $this->cancellationPercentage();

        if ($violations >= 3 || ($percentage >= 50 && $total >= 3)) {
            return 'high'; // Merah
        }
        
        if ($violations == 2 || ($percentage >= 20 && $percentage < 50 && $total >= 2)) {
            return 'medium'; // Kuning
        }

        return 'low'; // Hijau
    }

    public function layanans()
    {
        return $this->hasMany(Layanan::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function galeris()
    {
        return $this->hasMany(Galeri::class);
    }
}
