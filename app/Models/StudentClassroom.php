<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class StudentClassroom extends Model
{
    protected $fillable = [
        'student_id',
        'classroom_id',
        'academic_year_id',
        'wali_id'
    ];
    
    protected $table = 'student_classrooms';

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function wali()
    {
        return $this->belongsTo(Guru::class, 'wali_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function ekstrakurikuler()
    {
        return $this->belongsToMany(ExtraKurikuler::class, 'student_extracurriculars')
                    ->withPivot('deskripsi', 'urutan')
                    ->withTimestamps();
    }

    public function studentExtracurriculars()
    {
        return $this->hasMany(StudentExtracurriculars::class);
    }

    public function getLabelAttribute()
    {
        return $this->student->nama . ' - ' . $this->classroom->name . ' (' . $this->academicYear->label . ')';
    }


}
