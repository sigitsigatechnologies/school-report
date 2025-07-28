<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMateriRaporDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'nilai_materi_rapor_id',
        'master_materi_id',
        'nilai',
        'capaian_kompetensi'
    ];

    public function rapor()
    {
        return $this->belongsTo(NilaiMateriRapor::class, 'nilai_materi_rapor_id');
    }

    public function masterMateri()
    {
        return $this->belongsTo(MasterMateri::class);
    }
}
