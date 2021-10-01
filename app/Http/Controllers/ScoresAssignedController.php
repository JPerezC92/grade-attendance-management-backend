<?php

namespace App\Http\Controllers;

use App\Models\ScoreAssigned;
use Illuminate\Http\Request;
use Throwable;

class ScoresAssignedController extends Controller
{
    public function updateMany(Request $request)
    {
        try {



            foreach ($request->all() as $key => $scoreAssigned) {
                ScoreAssigned::where('id', $scoreAssigned["id"])->update(["value" => $scoreAssigned["value"]]);
            }

            // $activityId = $request->activityId;

            // $scoreCount = Score::where("score.activityId", $activityId)->count();

            // $score = Score::create([
            //     "name" => "N" . $scoreCount,
            //     "activityId" => $activityId
            // ]);

            // $score->fresh();

            // $scoreAssignedArr = [];

            // foreach ($students as $key => $student) {
            //     array_push($scoreAssignedArr, [
            //         "value" => 0,
            //         "scoreId" => $score->id,
            //         "activityId" => $activityId,
            //         "studentId" => $student->id
            //     ]);
            // }

            // DB::table("scoreAssigned")->insert($scoreAssignedArr);

            return response()->json([
                "success" => true,
                "payload" => "Actualizado correctamente",
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
