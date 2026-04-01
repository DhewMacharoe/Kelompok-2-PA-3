<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrian';
    protected $primaryKey = 'id_antrian';
    public $timestamps = false;

    protected $guarded = [];
}
