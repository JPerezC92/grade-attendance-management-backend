<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/{attendanceId}', [AttendanceController::class, "getById"])->name("attendance.getById");
Route::post('/', [AttendanceController::class, "create"])->name("attendance.create");
Route::put('/{id}', [AttendanceController::class, "update"])->name("attendance.update");
Route::delete('/{id}', [AttendanceController::class, "delete"])->name("attendance.delete");
