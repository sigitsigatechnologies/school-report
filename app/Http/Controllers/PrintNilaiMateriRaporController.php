<?php

namespace App\Http\Controllers;

use App\Models\NilaiMateriRapor;
use App\Models\StudentExtracurriculars;
use App\Models\StudentHealthAbsenceReport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\NilaiMateriExport;
use Maatwebsite\Excel\Facades\Excel;

class PrintNilaiMateriRaporController extends Controller
{
    public function show($id)
{
    $rapor = NilaiMateriRapor::with([
        'studentClassroom.student',
        'studentClassroom.classroom',
        'studentClassroom.wali.user', // Ambil wali via studentClassroom → guru → user
        'details.masterMateri'
    ])->findOrFail($id);

    // Ambil wali kelas dari studentClassroom
    $waliKelas = $rapor->studentClassroom->wali?->user;

    // Ambil student_classroom_id
    $studentClassroomId = $rapor->student_classroom_id;

    // Ekstrakurikuler & lainnya
    $ekstrakurikuler = StudentExtracurriculars::with('extracurricular')
        ->where('student_classroom_id', $studentClassroomId)
        ->orderBy('urutan')
        ->get();

    $kesehatanAbsensi = StudentHealthAbsenceReport::where('student_classroom_id', $studentClassroomId)->first();

    // Kirim ke view
    $pdf = Pdf::loadView('print.print-nilai-materi', compact(
        'rapor', 'ekstrakurikuler', 'kesehatanAbsensi', 'waliKelas'
    ));

    return $pdf->stream('nilai-materi-rapor.pdf');
}



    // public function exportExcel($id)
    // {
    //     $rapor = NilaiMateriRapor::with([
    //         'studentClassroom.student',
    //         'studentClassroom.classroom',
    //         'details.masterMateri'
    //     ])->findOrFail($id);

    //     $studentClassroomId = $rapor->student_classroom_id;
    //     $rapor = NilaiMateriRapor::with(['details', 'studentClassroom.student'])->findOrFail($id);
    //     $ekstrakurikuler = StudentExtracurriculars::with('extracurricular')
    //     ->where('student_classroom_id', $studentClassroomId)
    //     ->orderBy('urutan')
    //     ->get();

    //     $kesehatanAbsensi = StudentHealthAbsenceReport::where('student_classroom_id', $studentClassroomId)->first();

    //     return Excel::download(
    //         new NilaiMateriExport($rapor, $ekstrakurikuler, $kesehatanAbsensi),
    //         'rapor-nilai-materi.xlsx'
    //     );
    // }
}
