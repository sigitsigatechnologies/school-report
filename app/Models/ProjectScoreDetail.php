<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectScoreDetail extends Model
{
    protected $fillable = ['project_score_id', 'student_id', 'capaian_fase_id', 'parameter_penilaian_id'];

    public function projectScore(): BelongsTo
    {
        return $this->belongsTo(ProjectScore::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function capaianFase(): BelongsTo
    {
        return $this->belongsTo(CapaianFase::class);
    }

    public function parameterPenilaian(): BelongsTo
    {
        return $this->belongsTo(ParameterPenilaian::class);
    }
}
