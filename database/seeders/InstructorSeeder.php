<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "firstname" => "test isntructor",
            "lastname" => "test isntructor",
            "email" => "test@gmail.com",
            "password" => Hash::make("123456aA"),
        ]);
    }
}
