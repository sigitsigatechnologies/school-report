<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExtracurriculars extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_classroom_id',
        'extracurricular_id',
        'urutan',
        'deskripsi',
    ];

    public function studentClassroom()
    {
        return $this->belongsTo(StudentClassroom::class);
    }

    public function extracurricular()
    {
        return $this->belongsTo(ExtraKurikuler::class,  'extracurricular_id');
    }
}
