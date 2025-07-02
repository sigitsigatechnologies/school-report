<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{

    protected $table = 'guru'; 
    protected $fillable = [
        'name',
        'nip',
        'user_id',
        'job_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(JobPosition::class);
    }

    public function role()
    {
        return $this->user?->roles()?->first();
    }

}
