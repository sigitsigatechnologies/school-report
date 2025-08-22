<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projects extends Model
{
    protected $fillable = [
        'title_project',
        'project_description_detail_id',
        'student_classroom_id',
        'academic_year_id'
    ];

    public function projectDescription(): BelongsTo
    {
        return $this->belongsTo(ProjectDescription::class);
    }

    public function detail(): BelongsTo
    {
        return $this->belongsTo(ProjectDescriptionDetails::class, 'project_description_detail_id');
    }

    public function projectDetails(): HasMany
    {
        return $this->hasMany(ProjectDetail::class, 'project_id');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(ProjectScore::class);
    }

    public function parameterPenilaian()
    {
        return $this->hasMany(ParameterPenilaian::class);
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
