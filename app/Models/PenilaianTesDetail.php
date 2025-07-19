<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianTesDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'penilaian_sumatif_detail_id',
        'nilai_tes',
        'nilai_non_tes',
    ];

    public function detail()
    {
        return $this->belongsTo(PenilaianSumatifDetail::class, 'penilaian_sumatif_detail_id');
    }
}
