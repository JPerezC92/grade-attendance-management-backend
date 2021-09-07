<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courseRecord')->insert([
            "career" => "Ingenieria de software",
            "turn" => "mañana",
            "group" => "A",
            "semester" => "6",
            "instructorId" => 1,
            "courseId" => 1,
            "periodId" => 1
        ]);
        DB::table('courseRecord')->insert([
            "career" => "Ingenieria de software",
            "turn" => "mañana",
            "group" => "B",
            "semester" => "6",
            "instructorId" => 1,
            "courseId" => 1,
            "periodId" => 1
        ]);
        DB::table('courseRecord')->insert([
            "career" => "Ingenieria de software",
            "turn" => "mañana",
            "group" => "C",
            "semester" => "6",
            "instructorId" => 1,
            "courseId" => 1,
            "periodId" => 1
        ]);
        DB::table('courseRecord')->insert([
            "career" => "Ingenieria de software",
            "turn" => "mañana",
            "group" => "D",
            "semester" => "6",
            "instructorId" => 1,
            "courseId" => 1,
            "periodId" => 1
        ]);
    }
}
