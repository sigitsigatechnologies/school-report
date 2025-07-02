<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubElements extends Model
{
    protected $fillable = ['element_id', 'name'];

    public function element(): BelongsTo
    {
        return $this->belongsTo(Elements::class);
    }

    public function capaianFases(): HasMany
    {
        return $this->hasMany(CapaianFase::class, 'sub_element_id');
    }



}
