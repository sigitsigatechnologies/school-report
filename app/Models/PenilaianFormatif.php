<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianFormatif extends Model
{
    protected $fillable = [
        'master_materi_id',
        'semester',
    ];

    public function masterMateri()
    {
        return $this->belongsTo(MasterMateri::class);
    }

    public function classroom()
    {
        return $this->masterMateri?->classroom();
    }

    public function penilaianFormatifDetails()
    {
        return $this->hasMany(PenilaianFormatifDetail::class);
    }
    
}
