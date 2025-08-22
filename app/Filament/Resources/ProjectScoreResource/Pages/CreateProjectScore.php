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
        $data = $this->form->getState(); // <--- ambil semua input form

        $project = $this->record->project()->with([
            'academicYear',
            'projectDetails.capaianFase',
            'detail.header.classroom.studentClassrooms.student',
            'detail.header.classroom.studentClassrooms.academicYear',
        ])->first();

        if (!$project) return;

        $classroom = $project->detail?->header?->classroom;

        // filter student sesuai tahun ajaran & semester
        $students = $classroom?->studentClassrooms
            ->where('academic_year_id', $project->academic_year_id)
            ->filter(fn($sc) => $sc->academicYear?->semester == $project->academicYear?->semester)
            ->map(fn($sc) => $sc->student)
            ->unique('id');

        // $capaianFases = ProjectDetail::where('project_id', $project->id)
        //     ->with('capaianFase')
        //     ->get()
        //     ->pluck('capaianFase')
        //     ->filter()
        //     ->unique('id');

        $projectDetails = ProjectDetail::where('project_id', $project->id)
            ->with('capaianFase')
            ->get();


        // generate detail
        foreach ($students as $student) {
            foreach ($projectDetails as $detail) {
                $capaian = $detail->capaianFase;
                if (!$capaian) continue;
        
                $fieldKey = "nilai_{$student->id}_{$capaian->id}";
                $parameterId = $data[$fieldKey] ?? null;
        
                ProjectScoreDetail::create([
                    'project_score_id'       => $this->record->id,
                    'student_id'             => $student->id,
                    'capaian_fase_id'        => $capaian->id,
                    'parameter_penilaian_id' => $parameterId,
                    'project_detail_id'      => $detail->id, // ← sudah langsung ada
                ]);
            }
        }
        
    }
}
