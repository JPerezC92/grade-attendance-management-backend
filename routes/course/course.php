<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::post('/', [CourseController::class, 'create'])->name('course.create');
Route::get('/', [CourseController::class, 'geltAll'])->name('course.geltAll');
Route::get('/{courseId}', [CourseController::class, 'getById'])->name('course.getById');
Route::put('/{courseId}', [CourseController::class, 'update'])->name('course.update');
Route::delete('/{courseId}', [CourseController::class, 'delete'])->name('course.delete');
