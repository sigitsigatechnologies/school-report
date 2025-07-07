<?php

use App\Http\Controllers\Guru\DashboardController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\PrintProjectScoreController;
use App\Http\Controllers\ProjectNoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth', 'role:guru'])->group(function () {
//     Route::get('/dashboard-guru', [DashboardController::class, 'index'])->name('dashboard.guru');
// });


Route::get('/login', function () {
    return redirect('/admin/login'); // atau redirect ke panel login sesuai kebutuhanmu
})->name('login');

Route::get('/project-scores/{id}/print', [PrintController::class, 'projectScore'])->name('print.project-score');
Route::get('/project-scores/{id}/print/{student_id}', [\App\Http\Controllers\PrintController::class, 'studentScore'])
    ->name('print.project-score.student');

Route::get('/print/project-score/{project_score_id}/student/{student_id}', [PrintProjectScoreController::class, 'student'])
    ->name('print.project-score.student');

Route::get('/print/project-score/{student}', [PrintProjectScoreController::class, 'student'])
    ->name('print.project.score.student');



