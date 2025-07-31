<?php

namespace App\Http\Controllers;

use App\Models\NilaiMateriRapor;
use App\Models\StudentExtracurriculars;
use App\Models\StudentHealthAbsenceReport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\NilaiMateriExport;
use App\Models\SchoolProfile;
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
        // $waliKelas = $rapor->studentClassroom->wali?->user;
        $waliKelas = $rapor->studentClassroom->wali ?? '-';

        // dd($waliKelas);

        // Ambil student_classroom_id
        $studentClassroomId = $rapor->student_classroom_id;

        // Ekstrakurikuler & lainnya
        $ekstrakurikuler = StudentExtracurriculars::with('extracurricular')
            ->where('student_classroom_id', $studentClassroomId)
            ->orderBy('urutan')
            ->get();

        $kesehatanAbsensi = StudentHealthAbsenceReport::where('student_classroom_id', $studentClassroomId)->first();
        // dd($rapor->studentClassroom->student);

        // ambil dari school profile 
        $schoolProfile = SchoolProfile::first();
        // Kirim ke view
        $pdf = Pdf::loadView('print.print-nilai-materi', compact(
            'rapor',
            'ekstrakurikuler',
            'kesehatanAbsensi',
            'waliKelas',
            'schoolProfile'
        ))->setPaper('A4', 'potrait');

        return $pdf->stream("nilai-materi-rapor-{$rapor->studentClassroom->student->nama}.pdf");
    }
}
