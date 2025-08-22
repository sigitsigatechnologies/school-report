<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{

    protected $table = 'guru'; 
    protected $fillable = [
        'name',
        'nip',
        'user_id',
        'job_id',
        'alamat_wali',
        'pekerjaan_wali',
        'status_wali',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(JobPosition::class, 'job_id');
    }

    public function role()
    {
        return $this->user?->roles()?->first();
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_guru');
    }

    public function siswaDiwalikan()
    {
        return $this->hasMany(Student::class, 'wali_id');
    }

    // App\Models\Guru.php
    public function studentClassrooms()
    {
        return $this->hasMany(StudentClassroom::class, 'wali_id');
    }

}
