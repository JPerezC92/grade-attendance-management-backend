<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Throwable;

class CourseController extends Controller
{
    public function create(Request $request)
    {
        try {
            $course =  Course::create([
                "name" => $request->name,
                "campus" => $request->campus,
                "career" => $request->career,
                "instructorId" => $request->instructorId,
            ]);

            $course->fresh();

            return response()->json([
                "success" => true,
                "payload" => $course
            ]);
        } catch (Throwable $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function geltAll(Request $request)
    {
        try {
            $instructorId = $request->instructorId;

            $courses =  Instructor::find($instructorId)->courses;

            return response()->json([
                "success" => true,
                "payload" => $courses
            ]);
        } catch (Throwable $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function getById(Request $request, $courseId)
    {
        try {

            $course =  Course::find($courseId);
            $courseRecords =  Course::find($courseId)->courseRecords;
            $course->courseRecords = $courseRecords;

            return response()->json([
                "success" => true,
                "payload" => $course
            ]);
        } catch (Throwable $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }


    public function update(Request $request, $courseId)
    {
        try {
            $course =  Course::find($courseId);

            $updatedData = $request->only($course->getFillable);
            $course->fill($updatedData)->save();
            $course->fresh();

            return response()->json([
                "success" => true,
                "payload" => $course
            ]);
        } catch (Throwable $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }


    public function delete(Request $request, $courseId)
    {
        try {
            Course::destroy($courseId);

            return response()->json([
                "success" => true,
                "payload" => "Curso eliminado con exito"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
