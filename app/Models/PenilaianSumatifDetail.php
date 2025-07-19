<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PenilaianSumatifDetail extends Model
{
    protected $fillable = [
        'penilaian_sumatif_id',
        'master_unit_materi_id',
        'student_id',
        'nilai'
    ];

    public function penilaianSumatif()
    {
        return $this->belongsTo(PenilaianSumatif::class);
    }

    public function masterUnitMateri()
    {
        return $this->belongsTo(MasterUnitMateri::class, 'master_unit_materi_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    protected static function booted(): void
    {
        static::saving(function ($model) {
            if (! $model->penilaian_sumatif_id) {
                throw new \Exception("Penilaian Sumatif ID tidak ditemukan.");
            }

            $penilaian = PenilaianSumatif::with('masterMateri')->find($model->penilaian_sumatif_id);

            if (! $penilaian || ! $penilaian->masterMateri) {
                throw new \Exception("Penilaian tidak valid: Master Materi tidak ditemukan.");
            }

            $classroomId = $penilaian->masterMateri->classroom_id;

            $student = \App\Models\Student::find($model->student_id);

            if (! $student || $student->classroom_id != $classroomId) {
                throw new \Exception("Siswa bukan dari kelas yang sesuai dengan Master Materi.");
            }
        });
    }

    public function tesDetails()
    {
        return $this->hasMany(PenilaianTesDetail::class, 'penilaian_sumatif_detail_id');
    }

}
