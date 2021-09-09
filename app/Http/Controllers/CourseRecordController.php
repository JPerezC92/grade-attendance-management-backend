<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CourseRecord;
use App\Models\ScoreAssigned;
use Illuminate\Http\Request;
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
            $courseRecord = CourseRecord::find($courseRecordId);
            $courseRecord->period;
            $courseRecord->students;
            $courseRecord->activities;
            $courseRecord->attendances;

            $activities = Activity::all();
            $scoresCalculation = [];
            $finalScore = 0;
            // Calculate scores
            foreach ($courseRecord->students as $index => $studentValue) {
                $promedio = [];

                $activityData = [];
                foreach ($activities as $index => $activityValue) {

                    $notas = ScoreAssigned::where([['studentId', "=", $studentValue->id], ['activityId', "=", $activityValue->id]])->get();
                    $average = 0;
                    foreach ($notas as $index => $notaValue) {
                        $average += $notaValue->value;
                    }

                    if (count($notas) > 1) {
                        $average = $average / count($notas);
                    }

                    $finalScore += $average * $activityValue->value / 100;
                    $finalScore = round($finalScore, 2);

                    array_push($activityData, [
                        "average" => $average,
                        "activityId" => $activityValue->id,
                        "value" => $activityValue->value
                    ]);
                }

                $promedio = [
                    "studentId" => $studentValue->id,
                    "activities" => $activityData,
                    "finalScore" => $finalScore,
                    "finalScoreRounded" => round($finalScore, 0, PHP_ROUND_HALF_UP)
                ];

                $finalScore = 0;

                array_push(
                    $scoresCalculation,
                    $promedio
                );
            }

            $courseRecord["scoresCalculation"] = $scoresCalculation;

            // Activity details
            foreach ($courseRecord->activities as $index => $activitiesValue) {
                $activitiesValue->scores;

                foreach ($activitiesValue->scores as $index => $scoresValue) {
                    $scoresValue->scoresAssigned;
                }
            }

            foreach ($courseRecord->attendances as $index => $value) {
                $value->attendanceChecks;
            }

            return response()->json([
                "success" => true,
                "payload" => $courseRecord
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
