<?php

namespace App\Filament\Guru\Resources\ProjectScoreResource\Pages;

use App\Filament\Guru\Resources\ProjectScoreResource;
use App\Models\ProjectDetail;
use App\Models\ProjectScoreDetail;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectScore extends EditRecord
{
    protected static string $resource = ProjectScoreResource::class;

    protected function afterSave(): void
    {
        $projectScore = $this->record;
        $data = $this->form->getState();

        // Hapus nilai lama
        ProjectScoreDetail::where('project_score_id', $projectScore->id)->delete();

        $projectId = $data['project_id'];
        $projectDetails = ProjectDetail::where('project_id', $projectId)->with('capaianFase')->get();
        $capaianFases = $projectDetails->pluck('capaianFase')->filter()->unique('id');
        $classroomId = $projectScore->project->detail?->header?->classroom_id;
        $students = Student::where('classroom_id', $classroomId)->get();

        foreach ($students as $student) {
            foreach ($capaianFases as $capaian) {
                $key = "nilai_{$student->id}_{$capaian->id}";
                if (!isset($data[$key])) continue;

                ProjectScoreDetail::create([
                    'project_score_id' => $projectScore->id,
                    'student_id' => $student->id,
                    'capaian_fase_id' => $capaian->id,
                    'parameter_penilaian_id' => $data[$key],
                ]);
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
