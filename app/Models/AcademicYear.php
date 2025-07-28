<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = ['tahun_ajaran', 'semester', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function studentClassrooms()
    {
        return $this->hasMany(StudentClassroom::class);
    }

    // App\Models\AcademicYear.php

    public function getLabelAttribute()
    {
        $semesterLabel = $this->semester === '1' || strtolower($this->semester) === 'ganjil' ? 'Ganjil' : 'Genap';
        return "{$this->tahun_ajaran} - {$semesterLabel}";
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            $semesterLabel = $model->semester === '1' || strtolower($model->semester) === 'ganjil'
                ? 'Ganjil'
                : 'Genap';
        });
    }
}
