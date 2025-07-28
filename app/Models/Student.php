<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    //
    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan_sebelumnya',
        'alamat',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'jalan',
        'kelurahan',
        'kapanewon',
        'kota',
        'provinsi',
        'status'
    ];

    // public function classroom()
    // {
    //     return $this->belongsTo(Classroom::class);
    // }

    public function projectScores(): HasMany
    {
        return $this->hasMany(ProjectScore::class);
    }

    public function projectScoreDetails()
    {
        return $this->hasMany(ProjectScoreDetail::class);
    }

    public function penilaianFormatifDetails()
    {
        return $this->hasMany(PenilaianFormatifDetail::class);
    }

    public function penilaianSumatif()
    {
        return $this->hasOne(PenilaianSumatif::class);
    }

    public function penilaianSumatifDetails()
    {
        return $this->hasMany(PenilaianSumatifDetail::class);
    }

        // App\Models\Student
    public function studentClassroom()
    {
        return $this->belongsTo(StudentClassroom::class);
    }


    // App\Models\Student.php

    public function studentClassrooms()
    {
        return $this->hasMany(\App\Models\StudentClassroom::class);
    }

    

}
