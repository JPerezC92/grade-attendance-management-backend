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
            "name" => "Cloud computing",
            "instructorId" => 1,
        ]);
        DB::table('course')->insert([
            "name" => "Diseño y desarrollo de aplicaciones moviles II",
            "instructorId" => 1,
        ]);
        DB::table('course')->insert([
            "name" => "Formacion practica remota s6",
            "instructorId" => 1,
        ]);
        DB::table('course')->insert([
            "name" => "Inteligencia de negocios y dataware",
            "instructorId" => 1,
        ]);
        DB::table('course')->insert([
            "name" => "Mejora de metodos",
            "instructorId" => 1,
        ]);
        DB::table('course')->insert([
            "name" => "Prototipado de aplicaciones de interligencia artificial",
            "instructorId" => 1,
        ]);
        DB::table('course')->insert([
            "name" => "Redes neuronales",
            "instructorId" => 1,
        ]);
    }
}
