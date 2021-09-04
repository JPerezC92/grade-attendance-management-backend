<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::post('/', [StudentController::class, 'create'])->name('student.create');
Route::post('/file', [StudentController::class, 'createFromCSV'])->name('student.createFromCSV');
Route::get('/', [StudentController::class, 'getAll'])->name('student.getAll');
Route::get('/{studentId}', [StudentController::class, 'getById'])->name('student.getById');
Route::put('/{studentId}', [StudentController::class, 'update'])->name('student.update');
Route::delete('/{studentId}', [StudentController::class, 'delete'])->name('student.delete');
