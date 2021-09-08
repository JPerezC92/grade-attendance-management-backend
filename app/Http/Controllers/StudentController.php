<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Throwable;

class StudentController extends Controller
{
    public function create(Request $request)
    {
        try {
            $student =  Student::create([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "studentCode" => $request->studentCode,
            ]);

            $student->fresh();

            return response()->json([
                "success" => true,
                "payload" => $student
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }


    public function createFromCSV(Request $request)
    {
        try {

            $studentArr = json_decode($request->getContent());

            $students = [];

            foreach ((array)$studentArr as $index => $data) {
                $student =  Student::create([
                    "firstname" => $data->firstname,
                    "lastname" => $data->lastname,
                    "studentCode" => $data->studentCode,
                ]);
                $student->fresh();
                array_push($students, $student);
            }

            return response()->json([
                "success" => true,
                "payload" => $students
            ]);
        } catch (Throwable $e) {

            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $students =  Student::get();

            return response()->json([
                "success" => true,
                "payload" => $students
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }



    public function getById(Request $request, $studentId)
    {
        try {
            $student =  Student::find($studentId);

            return response()->json([
                "success" => true,
                "payload" => $student
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function update(Request $request, $studentId)
    {
        try {
            $student =  Student::find($studentId);
            $updatedData = $request->only($student->getFillable());

            $student->fill($updatedData)->save();
            $student->fresh();

            return response()->json([
                "success" => true,
                "message" => $student
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function delete(Request $request, $studentId)
    {
        try {
            $student =  Student::destroy($studentId);

            return response()->json([
                "success" => true,
                "payload" => "Elimininado con exito"
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
