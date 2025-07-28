<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianFormatifDetail extends Model
{
    protected $fillable = [
        'penilaian_formatif_id',
        'master_tp_id',
        'student_id',
        'nilai',
    ];

    public function penilaianFormatif()
    {
        return $this->belongsTo(PenilaianFormatif::class,'penilaian_formatif_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function masterTp()
    {
        return $this->belongsTo(MasterTp::class, 'master_tp_id');
    }

}
