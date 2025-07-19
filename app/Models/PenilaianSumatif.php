<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianSumatif extends Model
{
    protected $fillable = [
        'master_materi_id',
        'semester',
    ];

    public function details()
    {
        return $this->hasMany(PenilaianSumatifDetail::class);
    }

    public function masterMateri()
    {
        return $this->belongsTo(MasterMateri::class, 'master_materi_id');
    }

}
