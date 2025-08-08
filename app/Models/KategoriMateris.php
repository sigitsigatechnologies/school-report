<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMateris extends Model
{
    //

    use HasFactory;

    protected $table = 'kategori_materis';

    protected $fillable = [
        'nama',
    ];

    public function masterMateris()
    {
        return $this->hasMany(MasterMateri::class, 'kategori_materi_id');
    }
}
