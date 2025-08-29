<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDescriptionDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_description_id',
        'title',
        'description',
    ];

    public function header(): BelongsTo
    {
        return $this->belongsTo(ProjectDescription::class, 'project_description_id');
    }

    public function projectDescription()
    {
        return $this->belongsTo(ProjectDescription::class, 'project_description_id');
    }
}
