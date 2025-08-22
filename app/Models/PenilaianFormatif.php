<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianFormatif extends Model
{
    protected $fillable = [
        'master_materi_id',
        'academic_year_id',
        'semester',
    ];

    public function masterMateri()
    {
        return $this->belongsTo(MasterMateri::class, 'master_materi_id');
    }

    public function classroom()
    {
        return $this->masterMateri?->classroom();
    }

    public function penilaianFormatifDetails()
    {
        return $this->hasMany(PenilaianFormatifDetail::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    
    public function details()
    {
        return $this->hasMany(PenilaianFormatifDetail::class);
    }

    // App\Models\AcademicYear.php
    public function getLabelAttribute(): string
    {
        return "{$this->tahun} - Semester {$this->semester}";
    }

}
