<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentHealthAbsenceReport extends Model
{
    protected $fillable = [
        'student_classroom_id',
        'semester',
        'sakit',
        'ijin',
        'tanpa_keterangan',
        'tinggi_badan',
        'berat_badan',
        'saran',
    ];

    public function studentClassroom()
    {
        return $this->belongsTo(StudentClassroom::class);
    }

    public function student()
    {
        return $this->hasOneThrough(
            Student::class,
            StudentClassroom::class,
            'id', // foreign key di StudentClassroom
            'id', // foreign key di Student
            'student_classroom_id',
            'student_id'
        );
    }
}
