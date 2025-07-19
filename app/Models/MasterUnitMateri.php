<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterUnitMateri extends Model
{
    protected $fillable = ['unit_materi','master_materi_id', 'judul'];

    public function masterMateri()
    {
        return $this->belongsTo(MasterMateri::class);
    }

    public function masterTps()
    {
        return $this->hasMany(MasterTp::class);
    }

    public function penilaianSumatifDetails()
{
    return $this->belongsTo(PenilaianSumatifDetail::class, 'master_unit_materi_id');
}


}
