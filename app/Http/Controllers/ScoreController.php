<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ScoreController extends Controller
{
    public function create(Request $request)
    {
        try {
            $students = Student::all();

            $activityId = $request->activityId;

            // $scoreCount = Score::where("score.activityId", $activityId)->count();
            // $scoreCount = DB::raw("SELECT COUNT(id) FROM score WHERE score.activityId = $activityId");
            $scoreCount = DB::table('score')
                ->select(DB::raw('count(score.activityId) as count'))
                ->where('score.activityId', '=', $activityId)->first();

            $score = Score::create([
                "name" => "N" . $scoreCount->count + 1,
                "activityId" => $activityId
            ]);

            $score->fresh();

            $scoreAssignedArr = [];

            foreach ($students as $key => $student) {
                array_push($scoreAssignedArr, [
                    "value" => 0,
                    "scoreId" => $score->id,
                    "activityId" => $activityId,
                    "studentId" => $student->id
                ]);
            }

            DB::table("scoreAssigned")->insert($scoreAssignedArr);

            return response()->json([
                "success" => true,
                "payload" => $score
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function getById(Request $request, $scoreId)
    {
        try {
            $score = DB::table("score")
                ->where("score.id", $scoreId)
                ->join('scoreAssigned', 'scoreAssigned.scoreId', '=', 'score.id')
                ->leftJoin('student', 'student.id', '=', 'scoreAssigned.studentId')
                ->select("student.firstname", "student.lastname", "scoreAssigned.*")
                ->get();

            return response()->json([
                "success" => true,
                "payload" => $score
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function delete(Request $request, $scoreId)
    {
        try {
            DB::table("scoreAssigned")
                ->where("scoreId", $scoreId)
                ->delete();
            DB::table("score")
                ->where("score.id", $scoreId)
                ->delete();

            return response()->json([
                "success" => true,
                "payload" => "Calificación eliminada con exito"
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
