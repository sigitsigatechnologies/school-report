<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDetail extends Model
{
    protected $fillable = ['project_id', 'dimension_id', 'element_id', 'sub_element_id', 'capaian_fase_id'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class);
    }

    public function element(): BelongsTo
    {
        return $this->belongsTo(Elements::class);
    }

    public function subElement(): BelongsTo
    {
        return $this->belongsTo(SubElements::class);
    }

    public function capaianFase(): BelongsTo
    {
        return $this->belongsTo(CapaianFase::class);
    }

    public function header()
    {
        return $this->belongsTo(Projects::class);
    }

    public function studentClassroom()
    {
        return $this->belongsTo(StudentClassroom::class);
    }
}
