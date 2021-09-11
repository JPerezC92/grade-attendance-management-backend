<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ScoreAssigned;
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
                "courseRecordId" => $request->courseRecordId,
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

    public function createFromCSVFile(Request $request)
    {
        try {

            $studentsCsvFile = $request->file("studentsCsvFile");
            $studentsCsvText = file_get_contents($studentsCsvFile);
            $studentsCsvTextWithoutLineBreak = preg_replace('/(\r\n|\n|\r)/', '-', $studentsCsvText);
            $studentsCsvArray = explode("-", $studentsCsvTextWithoutLineBreak);
            $studentsToSave = [];
            for ($i = 0; $i < (count($studentsCsvArray) - 1); $i++) {
                $student =  explode(";", $studentsCsvArray[$i]);
                array_push($studentsToSave, [
                    "studentCode" => preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($student[0])),
                    "firstname" => preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($student[1])),
                    "lastname" => preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($student[2]))
                ]);
            }
            $students = [];

            foreach ((array)$studentsToSave as $index => $data) {
                $student =  Student::create([
                    "firstname" => $data["firstname"],
                    "lastname" => $data["lastname"],
                    "studentCode" => $data["studentCode"],
                    "courseRecordId" => 1,
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
                "payload" => $student
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function delete(Request $request, $studentId)
    {
        try {
            DB::table('scoreAssigned')->where('studentId', '=', $studentId)->delete();
            DB::table('attendanceCheck')->where('studentId', '=', $studentId)->delete();
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
