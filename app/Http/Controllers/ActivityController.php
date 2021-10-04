<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Score;
use App\Models\ScoreAssigned;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ActivityController extends Controller
{

    public function create(Request $request)
    {
        try {
            $courseRecordId = $request->courseRecordId;

            $activity =  Activity::create([
                "name" => $request->name,
                "value" => $request->value,
                "courseRecordId" => $courseRecordId,
            ]);

            $activity->fresh();

            $score = Score::create([
                "name" => "N1",
                "activityId" => $activity->id
            ]);

            $score->fresh();

            $students = Student::where("courseRecordId", $courseRecordId)->get()->toArray();

            $scoreAssignedData = [];

            foreach ($students as $key => $value) {
                array_push($scoreAssignedData, [
                    "value" => 0,
                    "scoreId" => $score->id,
                    "studentId" => $students[$key]["id"],
                    "activityId" => $activity->id,
                ]);
            }

            ScoreAssigned::upsert($scoreAssignedData, [
                "id",
                "scoreId",
                "studentId",
                "activityId"
            ], ["value"]);

            return response()->json([
                "success" => true,
                "payload" => $activity
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function update(Request $request, $activityId)
    {
        try {
            $activity =  Activity::find($activityId);

            $updatedData = $request->only($activity->getFillable());


            $activity->fill($updatedData)->save();
            $activity->fresh();

            return response()->json([
                "success" => true,
                "payload" => $activity
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }


    public function delete($activityId)
    {
        try {
            DB::table('scoreAssigned')->where('activityId', '=', $activityId)->delete();
            DB::table('score')->where('activityId', '=', $activityId)->delete();

            Activity::destroy($activityId);

            return response()->json([
                "success" => true,
                "payload" => "Elimininado con exito"
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
