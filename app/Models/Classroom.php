<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'academic_year_id'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function studentProjects()
    {
        return $this->hasMany(ProjectDescription::class);
    }

    // public function gurus()
    // {
    //     return $this->belongsToMany(Guru::class, 'classroom_guru');
    // }

    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'classroom_guru')
                    ->withPivot('mapel', 'tahun_ajaran', 'role');
    }

    public function masterMateris()
    {
        return $this->hasMany(MasterMateri::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function studentClassrooms()
    {
        return $this->hasMany(StudentClassroom::class);
    }


    // App\Models\Classroom.php
    public function getClassAbjadAttribute()
    {
        $map = [
            1 => '1 (Satu)',
            2 => '2 (Dua)',
            3 => '3 (Tiga)',
            4 => '4 (Empat)',
            5 => '5 (Lima)',
            6 => '6 (Enam)',
        ];

        $number = (int) filter_var($this->name, FILTER_SANITIZE_NUMBER_INT);
        return $map[$number] ?? $this->name;
    }

    public function waliKelas()
    {
        return $this->belongsToMany(Guru::class, 'classroom_guru')
                    ->withPivot('role')
                    ->wherePivot('role', 'wali');
    }
    



}
