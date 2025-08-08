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
        'academic_year_id',
        'kategori_materi_id',
        'status',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function masterUnitMateris()
    {
        return $this->hasMany(MasterUnitMateri::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriMateris::class, 'kategori_materi_id');
    }
}
