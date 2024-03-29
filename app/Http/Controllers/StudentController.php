<?php

namespace App\Http\Controllers;

use App\Models\AttendanceCheck;
use App\Models\ScoreAssigned;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


            $scores =  DB::table('activity')
                ->where('activity.courseRecordId', $student->courseRecordId)
                ->join("score", "score.activityId", "=", "activity.id")
                ->select('score.*')
                ->get()
                ->toArray();

            $scoresCheckData = [];

            foreach ($scores as $key => $value) {
                array_push($scoresCheckData, [
                    "value" => 0,
                    "scoreId" => $scores[$key]->id,
                    "studentId" => $student->id,
                    "activityId" => $scores[$key]->activityId
                ]);
            }

            ScoreAssigned::insert($scoresCheckData);

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

            // $students =  Student::upsert($studentsToSave, ["id", "courseRecordId"], ["studentCode"]);

            $studentIdArr = [];

            foreach ($studentsToSave as $key => $student) {
                $id = DB::table('student')->insertGetId($student);
                array_push($studentIdArr, $id);
            }

            $attendances =  DB::table('attendance')
                ->where('attendance.courseRecordId', $courseRecordId)
                ->get()
                ->toArray();

            $attendancesCheckData = [];

            foreach ($attendances as $attendanceKey => $value) {
                foreach ($studentIdArr as $key => $id) {
                    array_push($attendancesCheckData, [
                        "studentId" => $id,
                        "attendanceId" => $attendances[$attendanceKey]->id
                    ]);
                }
            }

            AttendanceCheck::insert($attendancesCheckData);


            $scores =  DB::table('activity')
                ->where('activity.courseRecordId', $courseRecordId)
                ->join("score", "score.activityId", "=", "activity.id")
                ->select('score.*')
                ->get()
                ->toArray();

            $scoresCheckData = [];

            foreach ($scores as $scoresKey => $value) {
                foreach ($studentIdArr as $key => $id) {
                    array_push($scoresCheckData, [
                        "value" => 0,
                        "scoreId" => $scores[$scoresKey]->id,
                        "studentId" => $id,
                        "activityId" => $scores[$scoresKey]->activityId
                    ]);
                }
            }

            ScoreAssigned::insert($scoresCheckData);

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
