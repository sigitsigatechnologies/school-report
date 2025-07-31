<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'nss',
        'alamat',
        'kode_pos',
        'kalurahan',
        'kapanewon',
        'kabupaten',
        'provinsi',
        'website',
        'email',
        'kepala_sekolah',
        'nip_kepala_sekolah',
        'wali_kelas',
        'nip_wali_kelas',
        'kelas',
        'fase',
        'semester',
        'tahun_ajaran',
        'tempat_tanggal_rapor',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
