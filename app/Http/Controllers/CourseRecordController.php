<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\AttendanceCheck;
use App\Models\CourseRecord;
use App\Models\ScoreAssigned;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CourseRecordController extends Controller
{


    public function create(Request $request)
    {
        try {
            $courseRecord = CourseRecord::create([
                'career' => $request->career,
                'turn' => $request->turn,
                'group' => $request->group,
                'semester' => $request->semester,
                'instructorId' => $request->instructorId,
                'courseId' => $request->courseId,
                'periodId' => $request->periodId,
            ]);

            $courseRecord->fresh();
            $courseRecord->period;

            return response()->json([
                "success" => true,
                "payload" => $courseRecord
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }


    public function getById(Request $request, $courseRecordId)
    {
        try {
            // $courseRecord = CourseRecord::with('students')->find($courseRecordId);
            // $courseRecord->period;
            // $courseRecord->students;
            // $courseRecord->activities;
            // $courseRecord->attendances;

            // $activities = Activity::all();
            // $scoresCalculation = [];
            // $finalScore = 0;
            // // Calculate scores
            // foreach ($courseRecord->students as $index => $studentValue) {
            //     $promedio = [];

            //     $activityData = [];
            //     foreach ($activities as $index => $activityValue) {

            //         $notas = ScoreAssigned::where([['studentId', "=", $studentValue->id], ['activityId', "=", $activityValue->id]])->get();
            //         $average = 0;
            //         foreach ($notas as $index => $notaValue) {
            //             $average += $notaValue->value;
            //         }

            //         if (count($notas) > 1) {
            //             $average = $average / count($notas);
            //         }

            //         $finalScore += $average * $activityValue->value / 100;
            //         $finalScore = round($finalScore, 2);

            //         array_push($activityData, [
            //             "average" =>  round($average, 2),
            //             "activityId" => $activityValue->id,
            //             "value" => $activityValue->value
            //         ]);
            //     }

            //     $promedio = [
            //         "studentId" => $studentValue->id,
            //         "activities" => $activityData,
            //         "finalScore" => $finalScore,
            //         "finalScoreRounded" => round($finalScore, 0, PHP_ROUND_HALF_UP)
            //     ];

            //     $finalScore = 0;

            //     array_push(
            //         $scoresCalculation,
            //         $promedio
            //     );
            // }

            // $courseRecord["scoresCalculation"] = $scoresCalculation;

            // // Activity details
            // foreach ($courseRecord->activities as $index => $activitiesValue) {
            //     $activitiesValue->scores;
            //     $activitiesValue["scoresQuantity"] = count($activitiesValue->scores);

            //     foreach ($activitiesValue->scores as $index => $scoresValue) {
            //         $scoresValue->scoresAssigned;
            //     }
            // }

            // foreach ($courseRecord->attendances as $index => $value) {
            //     $value->attendanceChecks;
            // }


            // ***********************************************************************************************************************************

            $courseRecordEntity = CourseRecord::with("activities", "attendances", "activities.scores")->find($courseRecordId);
            $courseRecordOject = ["courseRecord" => $courseRecordEntity->attributesToArray()];
            $activitiesArray = $courseRecordEntity->activities->toArray();
            $attendances = $courseRecordEntity->attendances->toArray();
            $activitiesArray2  = (array)clone (object)$activitiesArray;

            foreach ($activitiesArray2 as $key => $activityValue) {
                $activitiesArray2[$key]["scoresAssigned"] = [];
                $activitiesArray2[$key]["scoresQuantity"] = count($activitiesArray2[$key]["scores"]);
                unset($activitiesArray2[$key]["scores"]);
            }

            $courseRecordOject["activities"] = $activitiesArray;
            $courseRecordOject["attendances"] = $attendances;

            $studentsEntitiesArr = DB::table("student")
                ->where("student.courseRecordId", $courseRecordId)
                ->select(
                    "student.*",
                    DB::raw("(SELECT COUNT(CASE attendanceCheck.attendanceStatusId WHEN 1 THEN 1 ELSE	NULL END) FROM attendanceCheck WHERE attendanceCheck.studentId = student.id) as attended"),
                    DB::raw("(SELECT COUNT(CASE attendanceCheck.attendanceStatusId WHEN 2 THEN 1 ELSE	NULL END) FROM attendanceCheck WHERE attendanceCheck.studentId = student.id) as late"),
                    DB::raw("(SELECT COUNT(CASE attendanceCheck.attendanceStatusId WHEN 3 THEN 1 ELSE	NULL END) FROM attendanceCheck WHERE attendanceCheck.studentId = student.id) as skip"),
                    DB::raw("(SELECT COUNT(attendance.id) FROM attendance WHERE attendance.courseRecordId = student.courseRecordId) as attendancesQuantity")
                )
                ->get();

            $studentsArr = $studentsEntitiesArr->toArray();

            $studentsIds = [];
            foreach ($studentsArr as $key => $studentValue) {
                $studentValue->attendances = [
                    "attendancesCheck" => [],
                    "attended" => $studentValue->attended,
                    "late" => $studentValue->late,
                    "skip" => $studentValue->skip,
                    "attendedAverage" => ((($studentValue->attended + $studentValue->late) / $studentValue->attendancesQuantity) * 100)
                ];

                $studentsArr[$key]->activities = (array)clone (object)$activitiesArray2;

                unset($studentValue->attended);
                unset($studentValue->late);
                unset($studentValue->skip);
                unset($studentValue->attendancesQuantity);

                array_push($studentsIds, $studentValue->id);
            }

            $attendancesCheck = AttendanceCheck::whereIn("attendanceCheck.studentId", $studentsIds)
                ->select(
                    "attendanceCheck.*",
                    DB::raw("(SELECT attendanceStatus.value FROM attendanceStatus WHERE attendanceStatus.id = attendanceCheck.attendanceStatusId) as attendanceStatusValue")
                )
                ->get();
            // $attendancesCheck = AttendanceCheck::with("attendanceStatus")->whereIn("attendanceCheck.studentId", $studentsIds)
            //     ->select("attendanceCheck.*")
            //     ->get();


            $scoresAssigned = ScoreAssigned::whereIn("scoreAssigned.studentId", $studentsIds)
                ->select("scoreAssigned.*")
                ->get();


            foreach ($attendancesCheck as $key => $attendanceCheckValue) {
                foreach ($studentsArr as $key => $studentValue) {
                    if ($attendanceCheckValue["studentId"] === $studentValue->id) {
                        array_push($studentValue->attendances["attendancesCheck"], $attendanceCheckValue);
                    }
                }
            }

            foreach ($studentsArr as $studentsArrKey => $studentValue) {
                $finalScore = 0;
                foreach ($studentValue->activities as $activitiesKey => $activityValues) {
                    $average = 0;
                    $scoresQuantity = $studentValue->activities[$activitiesKey]["scoresQuantity"];
                    foreach ($scoresAssigned as $scoreAssignedKey => $scoreAssignedValue) {
                        if (
                            $studentValue->id === $scoreAssignedValue->studentId
                            && $activityValues["id"] === $scoreAssignedValue->activityId
                        ) {
                            $average += $scoreAssignedValue->value;
                            array_push($studentValue->activities[$activitiesKey]["scoresAssigned"], $scoreAssignedValue);
                        }
                    }
                    $average = $average / $scoresQuantity;
                    $studentValue->activities[$activitiesKey]["average"] = round($average, 2);

                    // print_r($average * $activityValues["value"] / 100);
                    // print_r("*");
                    $finalScore += $average * $activityValues["value"] / 100;
                }
                $studentsArr[$studentsArrKey]->finalScore = $finalScore;
                $studentsArr[$studentsArrKey]->finalScoreRounded = round($finalScore, 0, PHP_ROUND_HALF_UP);
                // print_r("******************");
            }

            $courseRecordOject["students"] = $studentsArr;

            return response()->json([
                "success" => true,
                // "payload" => $courseRecord
                "payload" => $courseRecordOject
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
