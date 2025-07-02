<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    //
    protected $fillable = [
        'nis', 'nisn', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama',
        'pendidikan_sebelumnya', 'alamat', 'nama_ayah', 'pekerjaan_ayah',
        'nama_ibu', 'pekerjaan_ibu', 'jalan', 'kelurahan', 'kapanewon', 'kota', 'provinsi',
        'nama_wali', 'pekerjaan_wali', 'alamat_wali', 'classroom_id',
        'status'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function projectScores(): HasMany
    {
        return $this->hasMany(ProjectScore::class);
    }
}
