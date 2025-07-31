<?php

namespace App\Http\Controllers;

use App\Models\ProjectScore;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function projectScore($id)
    {
        $score = ProjectScore::with(['project.detail.header.classroom', 'details.student', 'details.capaianFase', 'details.parameterPenilaian'])
            ->findOrFail($id);

        return view('print.project-score', compact('score'));
    }

    // public function studentScore($id, $student_id)
    // {
    //     $score = ProjectScore::with([
    //         'project.parameterPenilaian',
    //         'project.detail.header.classroom',
    //         'details' => fn($q) => $q->where('student_id', $student_id)->with(['capaianFase', 'parameterPenilaian']),
    //     ])->findOrFail($id);

    //      $student = $score->details->first()?->student()->with('classroom.gurus')->first();

    //     // $groupedDetails = $score->details->groupBy(fn ($item) => $item->projectDetail->project->title_project ?? 'Tanpa Judul');

    //     $gurus = $student?->classroom?->gurus ?? collect();

    //     return view('print.project-score-student', compact('project','score', 'student','groupedDetails', 'gurus'));
    // }

    public function studentScore($id, $student_id)
    {
        $score = ProjectScore::with([
            'project.parameterPenilaian',
            'project.detail.header.classroom',
            'details' => fn($q) => $q->where('student_id', $student_id)->with(['capaianFase', 'parameterPenilaian', 'projectDetail.project']),
        ])->findOrFail($id);

        $student = $score->details->first()?->student;
        $student?->loadMissing('classroom.gurus');

        $groupedDetails = $score->details->groupBy(fn($item) => $item->projectDetail->project->title_project ?? 'Tanpa Judul');
        $gurus = $student?->classroom?->gurus ?? collect();
        $project = $score->project;

        return view('print.project-score-student', compact('project', 'score', 'student', 'groupedDetails', 'gurus'));
    }
}
