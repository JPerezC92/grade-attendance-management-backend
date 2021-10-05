

<?php

use App\Http\Controllers\CourseRecordController;
use Illuminate\Support\Facades\Route;

Route::post('/', [CourseRecordController::class, 'create'])->name('courseRecord.create');
Route::put('/{courseRecordId}', [CourseRecordController::class, 'update'])->name('courseRecord.update');
Route::delete('/{courseRecordId}', [CourseRecordController::class, 'delete'])->name('courseRecord.delete');
Route::get('/{courseRecordId}', [CourseRecordController::class, 'getById'])->name('courseRecord.getById');
