<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\InstallerController;
use Illuminate\Support\Facades\Route;

Route::get('/install', [InstallerController::class, 'index'])->name('install');
Route::post('/install', [InstallerController::class, 'install'])->name('install.run');

Route::middleware('auth')->group(function () {
    Route::get('/attendance/status', [AttendanceController::class, 'status'])->name('attendance.status');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');
});
