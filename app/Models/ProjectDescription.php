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
        'classroom_id',
        'header_name_project',
        'fase',
        'tahun_ajaran',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(ProjectDescriptionDetails::class);
    }
}
