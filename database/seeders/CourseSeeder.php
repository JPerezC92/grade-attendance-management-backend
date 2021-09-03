<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course')->insert([
            "name" => "Prototipado",
            "campus" => "Chimbote",
            "career" => "Software",
            "instructorId" => 1,
        ]);
    }
}
