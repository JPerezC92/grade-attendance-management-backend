<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            "courseRecord",
            function (Blueprint $table) {
                $table->bigIncrements("id");
                $table->string('career');
                $table->string('turn');
                $table->string('group');
                $table->string('semester');
                $table->timestamps();
                $table->unsignedBigInteger('instructorId');
                $table->foreign('instructorId')->references('id')->on('users');
                $table->unsignedBigInteger('courseId');
                $table->foreign('courseId')->references('id')->on('course');
                $table->unsignedBigInteger('periodId');
                $table->foreign('periodId')->references('id')->on('period');
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
        Schema::dropIfExists('courseRecord');
    }
}
