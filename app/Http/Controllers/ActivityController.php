<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ActivityController extends Controller
{

    public function create(Request $request)
    {
        try {
            $activity =  Activity::create([
                "name" => $request->name,
                "value" => $request->value,
                "courseRecordId" => $request->courseRecordId,
            ]);

            $activity->fresh();

            for ($i = 0; $i < $request->scoresQuantity; $i++) {
                Score::create([
                    "name" => "n" . ($i + 1),
                    "activityId" => $activity->id
                ]);
            }

            $activity->scores;

            foreach ($activity->scores as $index => $scoreValue) {
                $scoreValue->scoresAssigned;
            }

            return response()->json([
                "success" => true,
                "payload" => $activity
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
