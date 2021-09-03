<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('instructor')->insert([
            "firstname" => "test istructor",
            "lastname" => "test istructor",
            "email" => "test@gmail.com",
            "password" => "123456",
            "status" => "active"
        ]);
    }
}
