<?php


namespace App\Http\Controllers;

use App\Models\ProjectDetail;
use App\Models\ProjectScore;
use App\Models\ProjectScoreDetail;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\View;

// NOTE PDF KALAU GAGAL RUNNING LIB NYA
//composer require barryvdh/laravel-dompdf

class PrintProjectScoreController extends Controller
{
    // public function student($project_score_id, $student_id)
    // {
    //     $score = ProjectScore::with([
    //         'project.detail.header.classroom',
    //     ])->findOrFail($project_score_id);

    //     $student = Student::with('classroom','wali')->findOrFail($student_id);

    //     // Ambil detail penilaian lengkap per sub capaian
    //     $scoreDetails = ProjectScoreDetail::with([
    //             'projectDetail.project',
    //             'projectDetail',
    //             'capaianFase.subElement.element.dimension',
    //             'parameterPenilaian',
    //         ])
    //         ->where('project_score_id', $project_score_id)
    //         ->where('student_id', $student_id)
    //         ->get();

    //     // Dikelompokkan berdasarkan nama proyek
    //     $groupedDetails = $scoreDetails->groupBy(function ($detail) {
    //         return $detail->projectDetail->project->title_project ?? 'Tanpa Judul';
    //     });

    //     return Pdf::loadView('print.project-score-student', [
    //         'score' => $score,
    //         'student' => $student,
    //         'groupedDetails' => $groupedDetails,
    //     ])->setPaper('A4', 'portrait')->stream("rapor-{$student->nama}.pdf");
    // }


    public function student(Student $student)
{
    // Ambil semua detail skor projek milik siswa ini, lengkap dengan relasi
    $scoreDetails = ProjectScoreDetail::with([
        'projectDetail.project.detail.header.classroom',
        'capaianFase.subElement.element.dimension',
        'parameterPenilaian',
    ])
    ->where('student_id', $student->id)
    ->get();
    

    // Validasi jika tidak ada data
    if ($scoreDetails->isEmpty()) {
        abort(404, 'Data nilai projek tidak ditemukan untuk siswa ini.');
    }

    $details = ProjectScoreDetail::with([
        'projectDetail.project.detail.header.classroom',
        'capaianFase.subElement.element.dimension',
        'parameterPenilaian',
    ])
    ->whereHas('projectScore', fn($q) => $q->where('student_id', $student->id))
    ->get();
    
    $groupedDetails = $details->groupBy('project_score_id');

    // Kirim data ke view PDF
    $pdf = Pdf::loadView('print.project-score-student', [
        'student' => $student,
        'groupedDetails' => $groupedDetails,
    ])->setPaper('A4', 'portrait');

    return $pdf->stream("rapor-{$student->nama}.pdf");
}

}
