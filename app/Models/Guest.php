<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guest extends Model
{
    protected $fillable = ['token', 'last_seen_at'];

    protected function casts():array
    {
        return ['lasts_seen_at' => 'datetime'];
    }

}
