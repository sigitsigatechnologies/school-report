<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterTp extends Model
{
    
    protected $fillable = [
        'tp_name',
        'master_unit_materi_id',
    ];

    public function masterUnitMateri()
    {
        return $this->belongsTo(MasterUnitMateri::class);
    }
}
