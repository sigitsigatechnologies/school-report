<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraKurikuler extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Scope untuk ambil yang aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
