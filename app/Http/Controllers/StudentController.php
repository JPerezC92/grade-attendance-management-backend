<?php

namespace App\Http\Controllers;

use App\Models\AttendanceCheck;
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

            $attendances =  DB::table('attendance')
                ->where('attendance.courseRecordId', $student->courseRecordId)
                ->get()
                ->toArray();

            $attendancesCheckData = [];

            foreach ($attendances as $key => $value) {
                array_push($attendancesCheckData, [
                    "studentId" => $student->id,
                    "attendanceId" => $attendances[$key]->id
                ]);
            }

            AttendanceCheck::insert($attendancesCheckData);

            return response()->json([
                "success" => true,
                "payload" => $student
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }




    public function createFromCSVFile(Request $request)
    {
        try {
            $courseRecordId = $request->query("courseRecordId");

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);

            $studentsCsvFile = $request->file("studentsCsvFile");
            $spreadsheet = $reader->load($studentsCsvFile);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            unset($rows[0]);

            $studentsToSave = [];

            foreach ((array)$rows as $index => $data) {
                array_push($studentsToSave, [
                    "studentCode" => $rows[$index][0],
                    "lastname" => $rows[$index][1],
                    "firstname" => $rows[$index][2],
                    "courseRecordId" => $courseRecordId,
                ]);
            }

            $students =  Student::upsert($studentsToSave, ["id", "courseRecordId"], ["studentCode"]);

            return response()->json([
                "success" => true,
                "payload" => "Estudiantes creados satisfactoriamente"
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
