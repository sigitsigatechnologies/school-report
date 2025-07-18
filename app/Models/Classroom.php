<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'title'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function studentProjects()
    {
        return $this->hasMany(ProjectDescription::class);
    }

    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'classroom_guru');
    }

    public function masterMateris()
    {
        return $this->hasMany(MasterMateri::class);
    }


}
