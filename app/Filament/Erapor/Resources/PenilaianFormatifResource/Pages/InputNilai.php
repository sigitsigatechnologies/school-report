<?php

namespace App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages;

use App\Filament\Erapor\Resources\PenilaianFormatifResource;
use App\Models\MasterTp;
use App\Models\PenilaianFormatif;
use App\Models\PenilaianFormatifDetail;
use App\Models\Student;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;


class InputNilai extends Page
{
    protected static string $resource = PenilaianFormatifResource::class;

    protected static string $view = 'filament.erapor.resources.penilaian-formatif-resource.pages.input-nilai';

    public $record;
    public $students;
    public $tps = [];
    public $nilai = [];
    public $search = '';

    public function mount($record): void
    {
        $this->record = PenilaianFormatif::findOrFail($record);
        $classroomId = $this->record->masterMateri->classroom_id;

        $this->students = Student::whereHas('studentClassrooms', function ($query) use ($classroomId) {
            $query->where('classroom_id', $classroomId);
        })->get();
        
        $this->tps = MasterTp::whereHas('masterUnitMateri.masterMateri', function ($q) {
            $q->where('id', $this->record->master_materi_id);
        })->get();

        // Load existing nilai
        foreach ($this->students as $student) {
            foreach ($this->tps as $tp) {
                $existing = PenilaianFormatifDetail::where('penilaian_formatif_id', $this->record->id)
                    ->where('student_id', $student->id)
                    ->where('master_tp_id', $tp->id)
                    ->first();

                $this->nilai[$student->id][$tp->id] = $existing?->nilai;
            }
        }
    }

    public function save()
    {
        DB::beginTransaction();

        foreach ($this->nilai as $studentId => $tpNilai) {
            foreach ($tpNilai as $tpId => $nilai) {
                if ($nilai === null || $nilai === '') {
                    continue; // Skip kosong
                }

                PenilaianFormatifDetail::updateOrCreate([
                    'penilaian_formatif_id' => $this->record->id,
                    'student_id' => $studentId,
                    'master_tp_id' => $tpId,
                ], [
                    'nilai' => $nilai,
                ]);
            }
        }


        DB::commit();

        Notification::make()
            ->title('Berhasil')
            ->body('Nilai berhasil disimpan.')
            ->success()
            ->send();
    }
}
