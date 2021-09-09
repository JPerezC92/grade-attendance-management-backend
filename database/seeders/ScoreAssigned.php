<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreAssigned extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Student 1
        DB::table('scoreAssigned')->insert(
            [
                'value' => 13,
                'scoreId' => 1,
                'studentId' => 1,
                'activityId' => 1,
            ]
        );
        DB::table('scoreAssigned')->insert(
            [
                'value' => 14,
                'scoreId' => 2,
                'studentId' => 1,
                'activityId' => 1,
            ]
        );
        DB::table('scoreAssigned')->insert(
            [
                'value' => 15,
                'scoreId' => 3,
                'studentId' => 1,
                'activityId' => 2,
            ]
        );
        DB::table('scoreAssigned')->insert(
            [
                'value' => 16,
                'scoreId' => 4,
                'studentId' => 1,
                'activityId' => 3,
            ]
        );
        DB::table('scoreAssigned')->insert(
            [
                'value' => 17,
                'scoreId' => 5,
                'studentId' => 1,
                'activityId' => 4,
            ]
        );

        // Student 2
        DB::table('scoreAssigned')->insert(
            [
                'value' => 5,
                'scoreId' => 1,
                'studentId' => 2,
                'activityId' => 1,
            ]
        );
        DB::table('scoreAssigned')->insert(
            [
                'value' => 6,
                'scoreId' => 2,
                'studentId' => 2,
                'activityId' => 1,
            ]
        );
        DB::table('scoreAssigned')->insert(
            [
                'value' => 7,
                'scoreId' => 3,
                'studentId' => 2,
                'activityId' => 2,
            ]
        );
        DB::table('scoreAssigned')->insert(
            [
                'value' => 8,
                'scoreId' => 4,
                'studentId' => 2,
                'activityId' => 3,
            ]
        );
        DB::table('scoreAssigned')->insert(
            [
                'value' => 9,
                'scoreId' => 5,
                'studentId' => 2,
                'activityId' => 4,
            ]
        );
    }
}
