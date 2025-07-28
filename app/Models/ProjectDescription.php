<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_classroom_id',
        'header_name_project',
        'fase',
    ];

    
// Akses classroom
    public function classroom()
    {
        return $this->hasOneThrough(
            Classroom::class,
            StudentClassroom::class,
            'id', // foreign key di student_classrooms
            'id', // primary key di classrooms
            'student_classroom_id', // foreign key di project_descriptions
            'classroom_id' // foreign key di student_classrooms
        );
    }


    public function details(): HasMany
    {
        return $this->hasMany(ProjectDescriptionDetails::class);
    }

    public function studentClassroom()
    {
        return $this->belongsTo(StudentClassroom::class);
    }

}
