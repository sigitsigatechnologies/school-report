<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraKurikuler extends Model
{
    protected $fillable = [
        'name',
        'academic_year_id',
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

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function studentClassrooms()
    {
        return $this->belongsToMany(StudentClassroom::class, 'student_extracurriculars')
                    ->withPivot('deskripsi', 'urutan')
                    ->withTimestamps();
    }

}
