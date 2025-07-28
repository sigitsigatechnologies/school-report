<?php

namespace App\Filament\Resources\ProjectScoreResource\Pages;

use App\Filament\Resources\ProjectScoreResource;
use App\Models\ProjectDetail;
use App\Models\ProjectScoreDetail;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateProjectScore extends CreateRecord
{
    protected static string $resource = ProjectScoreResource::class;

    // protected function afterCreate(): void
    // {
    //     $projectScore = $this->record;
    //     $data = $this->form->getState();

    //     $projectId = $data['project_id'];
    //     $projectDetails = ProjectDetail::where('project_id', $projectId)->with('capaianFase')->get();
    //     $capaianFases = $projectDetails->pluck('capaianFase')->filter()->unique('id');
    //     $classroomId = $projectScore->project->detail?->header?->classroom_id;
    //     $students = Student::where('classroom_id', $classroomId)->get();

    //     foreach ($students as $student) {
    //         foreach ($capaianFases as $capaian) {
    //             $fieldKey = "nilai_{$student->id}_{$capaian->id}";
    //             $parameterId = $data[$fieldKey] ?? null;
    //             if ($parameterId) {
    //                 ProjectScoreDetail::create([
    //                     'project_score_id' => $projectScore->id,
    //                     'student_id' => $student->id,
    //                     'capaian_fase_id' => $capaian->id,
    //                     'parameter_penilaian_id' => $parameterId,
    //                 ]);
    //             }
    //         }
    //     }
    // }

    protected function afterCreate(): void
{
    $projectScore = $this->record;
    $data = $this->form->getState();

    $projectId = $data['project_id'];

    // Ambil detail + capaian
    $projectDetails = ProjectDetail::with('capaianFase')
        ->where('project_id', $projectId)
        ->get();

    // Mapping capaian_fase_id → project_detail_id
    $detailMap = $projectDetails->mapWithKeys(function ($detail) {
        return [$detail->capaian_fase_id => $detail->id];
    });

    // Ambil siswa dari kelas
    $classroom = $projectScore->project->detail?->header?->classroom;
    $students = $classroom?->studentClassrooms
        ->map(fn ($sc) => $sc->student)
        ->filter();

    Log::info('Detail Map:', $detailMap->toArray());

    foreach ($students as $student) {
        foreach ($detailMap as $capaianFaseId => $projectDetailId) {
            $fieldKey = "nilai_{$student->id}_{$capaianFaseId}";
            $parameterId = $data[$fieldKey] ?? null;

            if ($parameterId) {
                $projectDetailId = $detailMap[$capaianFaseId] ?? null;

                Log::info("Saving score", [
                    'student_id' => $student->id,
                    'capaian_fase_id' => $capaianFaseId,
                    'parameter_penilaian_id' => $parameterId,
                    'project_detail_id' => $projectDetailId,
                ]);
                ProjectScoreDetail::create([
                    'project_score_id' => $projectScore->id,
                    'project_detail_id' => $projectDetailId, // ✅ diisi dengan benar
                    'student_id' => $student->id,
                    'capaian_fase_id' => $capaianFaseId,
                    'parameter_penilaian_id' => $parameterId,
                ]);
            }
        }
    }
}

}
