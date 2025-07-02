<?php

use App\Http\Controllers\Guru\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard-guru', [DashboardController::class, 'index'])->name('dashboard.guru');
});


Route::get('/login', function () {
    return redirect('/admin/login'); // atau redirect ke panel login sesuai kebutuhanmu
})->name('login');