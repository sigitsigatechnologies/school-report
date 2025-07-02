<?php

namespace App\Filament\Guru\Resources\ProjectScoreResource\Pages;

use App\Filament\Guru\Resources\ProjectScoreResource;
use App\Models\ProjectDetail;
use App\Models\ProjectScoreDetail;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectScore extends CreateRecord
{
    protected static string $resource = ProjectScoreResource::class;

    protected function afterCreate(): void
    {
        $projectScore = $this->record;
        $data = $this->form->getState();

        $projectId = $data['project_id'];
        $projectDetails = ProjectDetail::where('project_id', $projectId)->with('capaianFase')->get();
        $capaianFases = $projectDetails->pluck('capaianFase')->filter()->unique('id');
        $classroomId = $projectScore->project->detail?->header?->classroom_id;
        $students = Student::where('classroom_id', $classroomId)->get();

        foreach ($students as $student) {
            foreach ($capaianFases as $capaian) {
                $fieldKey = "nilai_{$student->id}_{$capaian->id}";
                $parameterId = $data[$fieldKey] ?? null;

                if ($parameterId) {
                    ProjectScoreDetail::create([
                        'project_score_id' => $projectScore->id,
                        'student_id' => $student->id,
                        'capaian_fase_id' => $capaian->id,
                        'parameter_penilaian_id' => $parameterId,
                    ]);
                }
            }
        }
    }
}
