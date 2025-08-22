<?php


namespace App\Http\Controllers;

use App\Models\ProjectDetail;
use App\Models\ProjectScore;
use App\Models\ProjectScoreDetail;
use App\Models\SchoolProfile;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\View;

// NOTE PDF KALAU GAGAL RUNNING LIB NYA
//composer require barryvdh/laravel-dompdf

class PrintProjectScoreController extends Controller
{
    // public function studentOne($project_score_id, $student_id)
    // {
    //     $score = ProjectScore::with([
    //         'project.detail.header.classroom',
    //     ])->findOrFail($project_score_id);

    //     $student = Student::with('classroom', 'wali')->findOrFail($student_id);
        

    //     // Ambil detail penilaian lengkap per sub capaian
    //     $scoreDetails = ProjectScoreDetail::with([
    //         'projectDetail.project',
    //         'projectDetail',
    //         'capaianFase.subElement.element.dimension',
    //         'parameterPenilaian',
    //     ])
    //         ->where('project_score_id', $project_score_id)
    //         ->where('student_id', $student_id)
    //         ->get();

    //     // Dikelompokkan berdasarkan nama proyek
    //     $groupedDetails = $scoreDetails->groupBy(function ($detail) {
    //         return $detail->projectDetail->project->title_project ?? 'Tanpa Judul';
    //     });

    //     return Pdf::loadView('print.project-score-per-student', [
    //         'score' => $score,
    //         'student' => $student,
    //         'groupedDetails' => $groupedDetails,
    //     ])->setPaper('A4', 'portrait')->stream("rapor-{$student->nama}.pdf");
    // }



    // public function student(Student $student)
    // {
    //     // Ambil semua detail skor projek milik siswa ini, lengkap dengan relasi
    //     $scoreDetails = ProjectScoreDetail::with([
    //         'projectDetail.project.detail.header.classroom',
    //         'capaianFase.subElement.element.dimension',
    //         'parameterPenilaian',
    //     ])
    //         ->where('student_id', $student->id)
    //         ->get();


    //     // Validasi jika tidak ada data
    //     if ($scoreDetails->isEmpty()) {
    //         abort(404, 'Data nilai projek tidak ditemukan untuk siswa ini.');
    //     }

    //     $details = ProjectScoreDetail::with([
    //         'projectDetail.project.detail.header.classroom',
    //         'capaianFase.subElement.element.dimension',
    //         'parameterPenilaian',
    //     ])
    //         ->whereHas('projectScore', fn($q) => $q->where('student_id', $student->id))
    //         ->get();

    //     $groupedDetails = $details->groupBy('project_score_id');

    //     // Kirim data ke view PDF
    //     $pdf = Pdf::loadView('print.project-score-student', [
    //         'student' => $student,
    //         'groupedDetails' => $groupedDetails,
    //     ])->setPaper('A4', 'portrait');

    //     return $pdf->stream("rapor-{$student->nama}.pdf");
    // }


    public function studentOne($project_score_id, $student_id)
    {
        $score = ProjectScore::with([
            'project.detail.header.classroom',
        ])->findOrFail($project_score_id);
    
        $student = Student::findOrFail($student_id);
    
        // Ambil header projek
        $header = $score->project?->detail?->header;
    
        // Ambil StudentClassroom berdasarkan student_id dan classroom_id dari header
        $studentClassroom = \App\Models\StudentClassroom::with(['wali', 'academicYear'])
            ->where('student_id', $student_id)
            ->where('classroom_id', $header?->classroom->id)
            ->first();
    
        $wali = $studentClassroom?->wali;
        $academicYear = $studentClassroom?->academicYear?->tahun_ajaran;
        // dd($wali);
    
        // Ambil detail penilaian lengkap per sub capaian
        $scoreDetails = ProjectScoreDetail::with([
            'projectDetail.project',
            'projectDetail',
            'capaianFase.subElement.element.dimension',
            'parameterPenilaian',
        ])
            ->where('project_score_id', $project_score_id)
            ->where('student_id', $student_id)
            ->get();
    
        // Dikelompokkan berdasarkan nama proyek
        $groupedDetails = $scoreDetails->groupBy(function ($detail) {
            return $detail->projectDetail->project->title_project ?? 'Tanpa Judul';
        });


        $schoolProfile = SchoolProfile::first();
    
        return Pdf::loadView('print.project-score-per-student', [
            'score' => $score,
            'student' => $student,
            'groupedDetails' => $groupedDetails,
            'wali' => $wali,
            'academicYear' => $academicYear,
            'header' => $header,
            'schoolProfile' => $schoolProfile,
        ])->setPaper('A4', 'portrait')->stream("rapor-{$student->nama}.pdf");
    }
    


    public function student(Student $student)
    {
        // Ambil semua detail skor projek milik siswa ini, lengkap dengan relasi
        $details = ProjectScoreDetail::with([
            'projectDetail.project.detail.header.classroom',
            'capaianFase.subElement.element.dimension',
            'parameterPenilaian',
            'projectScore',
        ])
        ->whereHas('projectScore', fn($q) => $q->where('student_id', $student->id))
        ->get();

        // Validasi jika tidak ada data
        if ($details->isEmpty()) {
            abort(404, 'Data nilai projek tidak ditemukan untuk siswa ini.');
        }

        // Ambil salah satu project detail yang punya info kelas
        $firstDetail = $details->first();
        $classroom = $firstDetail?->projectDetail?->project?->detail?->header?->classroom;

        // Ambil student_classroom berdasarkan kelas tersebut
        $studentClassroom = $student->studentClassrooms()
            ->with('wali', 'academicYear')
            ->where('classroom_id', $classroom?->id)
            ->latest('id')
            ->first();

        $wali = $studentClassroom?->wali;
        $academicYear = $studentClassroom?->academicYear?->tahun_ajaran ?? '-';

        // Grouping data berdasarkan project_score_id (per projek)
        $groupedDetails = $details->groupBy('project_score_id');

        $schoolProfile = SchoolProfile::first();

        // Kirim data ke view PDF
        $pdf = Pdf::loadView('print.project-score-student', [
            'student' => $student,
            'groupedDetails' => $groupedDetails,
            'wali' => $wali,
            'academicYear' => $academicYear,
            'schoolProfile' => $schoolProfile,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream("rapor-{$student->nama}.pdf");
    }

}
