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
            "instructorId" => 1,
            "courseId" => 1,
            "periodId" => 1
        ]);
    }
}
