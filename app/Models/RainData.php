<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RainData extends Model
{
    protected $fillable = [
        'device_id',
        'amount'
    ];
}
