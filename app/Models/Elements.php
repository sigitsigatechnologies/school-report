<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Elements extends Model
{
    protected $fillable = ['dimension_id', 'name'];

    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class);
    }

    public function subElements(): HasMany
    {
        return $this->hasMany(SubElements::class, 'element_id');
    }

}
