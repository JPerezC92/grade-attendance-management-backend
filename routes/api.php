<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(__DIR__ . '/auth/auth.php');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('student')->group(__DIR__ . '/student/student.php');
    Route::prefix('instructor')->group(__DIR__ . '/instructor/instructor.php');
    Route::prefix('course')->group(__DIR__ . '/course/course.php');
    Route::prefix('period')->group(__DIR__ . '/period/period.php');
    Route::prefix('course-record')->group(__DIR__ . '/courseRecord/courseRecord.php');
    Route::prefix('attendance')->group(__DIR__ . '/attendance/attendance.php');
    Route::prefix('attendance-check')->group(__DIR__ . '/attendanceCheck/attendanceCheck.php');
    Route::prefix('activity')->group(__DIR__ . '/activity/activity.php');
    Route::prefix('scores')->group(__DIR__ . '/scores/scores.php');
    Route::prefix('scores-assigned')->group(__DIR__ . '/scoresAssigned/scoresAssigned.php');
});
