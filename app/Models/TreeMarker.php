<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreeMarker extends Model
{
    protected $fillable = ['client_uuid', 'category', 'name', 'species', 'notes', 'latitude', 'longitude', 'accuracy', 'marked_at'];

    protected function casts(): array
    {
        return ['latitude' => 'float', 'longitude' => 'float', 'marked_at' => 'datetime'];
    }
}
