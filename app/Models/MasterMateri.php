<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterMateri extends Model
{
    protected $fillable = [
        'mata_pelajaran',
        'classroom_id',
        'status',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function masterUnitMateris()
    {
        return $this->hasMany(MasterUnitMateri::class);
    }

}
