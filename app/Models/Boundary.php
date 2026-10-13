<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boundary extends Model
{
    protected $fillable = ['client_uuid', 'name', 'notes', 'capture_mode', 'points', 'recorded_at'];

    protected function casts(): array
    {
        return ['points' => 'array', 'recorded_at' => 'datetime'];
    }
}
