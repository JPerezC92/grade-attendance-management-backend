<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Student extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            "student",
            function (Blueprint $table) {
                $table->bigIncrements("id");
                $table->string("firstname", 50);
                $table->string("lastname", 50);
                $table->string("studentCode", 50);
                $table->timestamps();
                $table->unsignedBigInteger('gradeId')->unique();
                $table->foreign('gradeId')->references('id')->on('grade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
