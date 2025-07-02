<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dimension extends Model
{
    protected $fillable = ['name'];

    public function elements(): HasMany
    {
        return $this->hasMany(Elements::class);
    }

}
