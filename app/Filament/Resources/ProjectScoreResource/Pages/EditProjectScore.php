<?php

namespace App\Filament\Resources\ProjectScoreResource\Pages;

use App\Filament\Resources\ProjectScoreResource;
use App\Models\ProjectDetail;
use App\Models\ProjectScoreDetail;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class EditProjectScore extends EditRecord
{
    protected static string $resource = ProjectScoreResource::class;

    protected function afterSave(): void
    {
        $this->record->refresh();



        // Notification::make()
        //     ->title('Data berhasil disimpan')
        //     ->success()
        //     ->send();
    }

    // protected function handleRecordUpdate(Model $record, array $data): Model
    // {
    //     $record->update([
    //         'project_id' => $data['project_id'],
    //     ]);

    //     $projectId = $data['project_id'];

    //     // Ambil detail project lengkap dengan capaian fase
    //     $projectDetails = ProjectDetail::where('project_id', $projectId)->with('capaianFase')->get();
    //     $capaianFases = $projectDetails->pluck('capaianFase')->filter()->unique('id');

    //     $classroom = $record->project->detail?->header?->classroom;

    //     // Ambil siswa dari studentClassrooms → student
    //     $students = $classroom?->studentClassrooms
    //         ->map(fn($sc) => $sc->student)
    //         ->filter();

    //     // Optional: hapus existing detail dulu
    //     // ProjectScoreDetail::where('project_score_id', $record->id)->delete();

    //     // foreach ($students as $student) {
    //     //     foreach ($capaianFases as $capaian) {
    //     //         $nilaiKey = "nilai_{$student->id}_{$capaian->id}";
    //     //         $noteKey = "noteInputs.{$student->id}_{$capaian->id}";

    //     //         $nilai = $data[$nilaiKey] ?? null;
    //     //         $note = data_get($data, $noteKey);

    //     //         if ($nilai !== null) {
    //     //             // Cari ID dari project_details yang sesuai capaian_fase
    //     //             $projectDetailId = $projectDetails
    //     //                 ->firstWhere('capaian_fase_id', $capaian->id)?->id;

    //     //             ProjectScoreDetail::create([
    //     //                 'project_score_id' => $record->id,
    //     //                 'student_id' => $student->id,
    //     //                 'capaian_fase_id' => $capaian->id,
    //     //                 'parameter_penilaian_id' => $nilai,
    //     //                 'note_project' => $note,
    //     //                 'project_detail_id' => $projectDetailId, // ✅ sekarang disimpan
    //     //             ]);
    //     //         }
    //     //     }
    //     foreach ($students as $student) {
    //         foreach ($capaianFases as $capaian) {
    //             $nilaiKey = "nilai_{$student->id}_{$capaian->id}";
    //             $noteKey = "noteInputs.{$student->id}_{$capaian->id}";

    //             $nilai = $data[$nilaiKey] ?? null;
    //             $note = data_get($data, $noteKey);

    //             $projectDetailId = $projectDetails
    //                 ->firstWhere('capaian_fase_id', $capaian->id)?->id;

    //             if ($nilai !== null || $note !== null) {
    //                 ProjectScoreDetail::updateOrCreate(
    //                     [
    //                         'project_score_id' => $record->id,
    //                         'student_id' => $student->id,
    //                         'capaian_fase_id' => $capaian->id,
    //                     ],
    //                     [
    //                         'parameter_penilaian_id' => $nilai,
    //                         'note_project' => $note,
    //                         'project_detail_id' => $projectDetailId,
    //                     ]
    //                 );
    //             } else {
    //                 // Jika tidak ada nilai dan tidak ada catatan, hapus data
    //                 ProjectScoreDetail::where([
    //                     'project_score_id' => $record->id,
    //                     'student_id' => $student->id,
    //                     'capaian_fase_id' => $capaian->id,
    //                 ])->delete();
    //             }
    //         }
    //     }
    //     return $record;
    // }


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update([
            'project_id' => $data['project_id'],
        ]);

        $projectId = $data['project_id'];

        // Ambil project detail + capaian
        $projectDetails = ProjectDetail::where('project_id', $projectId)
            ->with('capaianFase')
            ->get(['id', 'project_id', 'capaian_fase_id']);
        $capaianFases = $projectDetails->pluck('capaianFase')->filter()->unique('id');

        // Ambil siswa di kelas
        $classroom = $record->project->detail?->header?->classroom;
        $students = $classroom?->studentClassrooms
            ->map(fn($sc) => $sc->student)
            ->filter();

        foreach ($students as $student) {
            foreach ($capaianFases as $capaian) {
                $nilaiKey = "nilai_{$student->id}_{$capaian->id}";
                $noteKey  = "noteInputs.{$student->id}_{$capaian->id}";

                $nilai = $data[$nilaiKey] ?? null;
                $note  = data_get($data, $noteKey);

                $projectDetailId = $projectDetails
                    ->firstWhere('capaian_fase_id', $capaian->id)?->id;

                if ($nilai || $note) {
                    ProjectScoreDetail::updateOrCreate(
                        [
                            'project_score_id' => $record->id,
                            'student_id'       => $student->id,
                            'capaian_fase_id'  => $capaian->id,
                        ],
                        [
                            'parameter_penilaian_id' => $nilai,
                            'note_project'           => $note,
                            'project_detail_id'      => $projectDetailId,
                        ]
                    );
                } else {
                    ProjectScoreDetail::where([
                        'project_score_id' => $record->id,
                        'student_id'       => $student->id,
                        'capaian_fase_id'  => $capaian->id,
                    ])->delete();
                }
            }
        }

        return $record;
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
