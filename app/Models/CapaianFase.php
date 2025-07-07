<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CapaianFase extends Model
{
    protected $fillable = ['sub_element_id', 'fase', 'description'];

    public function subElement(): BelongsTo
    {
        return $this->belongsTo(SubElements::class, 'sub_element_id');
    }

    public function projectDetail()
    {
        return $this->belongsTo(ProjectDetail::class);
    }

    public function element()
    {
        return $this->belongsTo(Elements::class, 'elemen_id');
    }

}
