<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockHistory extends Model
{
    protected $table = 'block_histories';

    protected $fillable = [
        'user_id',
        'admin_id',
        'action', // 'block', 'unblock', 'reset_risk'
        'reason',
    ];

    /**
     * Get the customer that was moderated.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin that performed the action.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
