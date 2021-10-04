<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceCheck;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class AttendanceController extends Controller
{
    public function getById(Request $request, $attendanceId)
    {
        try {

            $attendanceStates = DB::table('attendanceStatus')->orderBy("id")->get();
            $attendanceCheck = DB::table('attendance')
                ->where("attendance.id", $attendanceId)
                ->join("student", "student.courseRecordId", "=", "attendance.courseRecordId")
                ->join("attendanceCheck", function ($join) {
                    $join->on("student.id", "=", "attendanceCheck.studentId");
                    $join->on("attendanceCheck.attendanceId", "=", "attendance.id");
                })
                // ->join("attendanceStatus", "attendanceStatus.id", "=", "attendanceCheck.attendanceStatusId")
                ->select(
                    "attendance.*",
                    "student.firstname",
                    "student.lastname",
                    "student.id as studentId",
                    "attendanceCheck.*",
                    // "attendanceStatus.value as attendanceStatusValue"
                )
                ->get();

            return response()->json([
                "success" => true,
                "payload" =>  [
                    "attendancesCheck" => $attendanceCheck,
                    "attendanceStates" => $attendanceStates
                ]
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function create(Request $request)
    {
        try {
            $courseRecordId = $request->courseRecordId;
            $attendanceCheckData = [];
            $students = Student::where('student.courseRecordId', $courseRecordId)->get();

            $attendance = Attendance::create([
                'date' => $request->date,
                'courseRecordId' => $request->courseRecordId,
            ]);
            $attendance->fresh();

            foreach ($students as $key => $studentValue) {
                array_push($attendanceCheckData, [
                    "studentId" => $studentValue["id"],
                    "attendanceId" => $attendance["id"],
                ]);
            }

            AttendanceCheck::insert($attendanceCheckData);

            $attendance->attendanceChecks;

            return response()->json([
                "success" => true,
                "payload" =>  $attendance
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function update(Request $request, $attendanceId)
    {
        try {
            $attendance = Attendance::find($attendanceId);
            $updatedData = $request->only($attendance->getFillable);

            $attendance->fill($updatedData)->save();

            $attendance->fresh();
            $attendance->attendanceChecks;

            return response()->json([
                "success" => true,
                "payload" => $attendance
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function delete(Request $request, $attendanceId)
    {
        try {
            DB::table('attendanceCheck')->where('attendanceId', '=', $attendanceId)->delete();

            $student =  Attendance::destroy($attendanceId);

            return response()->json([
                "success" => true,
                "payload" => "Elimininado con exito"
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
