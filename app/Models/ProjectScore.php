<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectScore extends Model
{
    protected $fillable = ['project_id'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function details()
    {
        return $this->hasMany(ProjectScoreDetail::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function studentClassroom()
    {
        return $this->belongsTo(StudentClassroom::class);
    }



}
