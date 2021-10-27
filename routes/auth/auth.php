<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware("auth:sanctum");
Route::post('/recover-password', [AuthController::class, 'recoverPassword'])->name('auth.recoverPassword');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.resetPassword')->middleware("auth:sanctum");
