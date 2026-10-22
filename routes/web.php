<?php
use App\Http\Controllers\{ProfileController, AttendanceController};
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/dashboard', fn() => redirect()->route('attendance.index'))->name('dashboard');
    Route::post('/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockIn');
    Route::post('/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clockOut');
    Route::get('/report', [AttendanceController::class, 'report'])->name('attendance.report');
    Route::get('/admin', [AttendanceController::class, 'admin'])->name('attendance.admin');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
