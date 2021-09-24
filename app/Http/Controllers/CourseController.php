<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
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
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function geltAll(Request $request)
    {
        try {
            $instructorId = $request->query("instructorId");

            $courses =  User::find($instructorId)->courses;

            return response()->json([
                "success" => true,
                "payload" => $courses
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function getById(Request $request, $courseId)
    {
        try {

            $course =  Course::find($courseId);
            $course->courseRecords;
            $course->instructor;

            foreach ($course->courseRecords as $index => $value) {
                $value->period;
                if ($value->period->status === "inactive") {
                    unset($course->courseRecords[$index]);
                }
            }

            return response()->json([
                "success" => true,
                "payload" => $course
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
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
            return response(content: $e->getMessage(), status: "500",);
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
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
