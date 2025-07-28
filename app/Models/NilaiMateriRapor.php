<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMateriRapor extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_classroom_id',
        'naik_kelas'
    ];

    public function studentClassroom()
    {
        return $this->belongsTo(StudentClassroom::class);
    }

    public function details()
    {
        return $this->hasMany(NilaiMateriRaporDetail::class);
    }

    // Di app/Models/NilaiMateriRapor.php
    public function getSemesterAttribute()
    {
        $semester = (int) optional($this->studentClassroom?->academicYear)->semester;

        return match ($semester) {
            1 => 'Ganjil',
            2 => 'Genap',
            default => '-',
        };
    }
}
