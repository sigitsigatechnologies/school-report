<?php

use App\Http\Controllers\PrintController;
use App\Http\Controllers\PrintNilaiMateriRaporController;
use App\Http\Controllers\PrintNilaiSumatifController;
use App\Http\Controllers\PrintProjectScoreController;
use App\Http\Controllers\ProjectNoteController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('lending.index');
});

Route::get('/login', function () {
    return redirect('/p5/login'); // atau redirect ke panel login sesuai kebutuhanmu
})->name('login');

Route::get('/project-scores/{id}/print', [PrintController::class, 'projectScore'])->name('print.project-score');
Route::get('/project-scores/{id}/print/{student_id}', [\App\Http\Controllers\PrintController::class, 'studentScore'])
    ->name('print.project-score.student');

Route::get('/print/project-score/{project_score_id}/student/{student_id}', [PrintProjectScoreController::class, 'studentOne'])
    ->name('print.project-score.studentOne');

Route::get('/print/project-score/{student}', [PrintProjectScoreController::class, 'student'])
    ->name('print.project.score.student');

Route::get('/erapor/print/nilai-materi/{id}', [PrintNilaiMateriRaporController::class, 'show'])->name('print.nilai-materi-rapor.show');

// Route::get('/erapor/export-excel/nilai-materi/{id}', [PrintNilaiMateriRaporController::class, 'exportExcel'])
//     ->name('print.nilai-materi-rapor.excel');
// Route::get('/erapor/print/nilai-materi', [PrintNilaiMateriRaporController::class, 'index'])->name('print.nilai-materi-rapor');