<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Period extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('value');
            $table->enum('status', ["active", "inactivo"])->default('active');
            $table->timestamps();
            $table->unsignedBigInteger('instructorId');
            $table->foreign('instructorId')->references('id')->on('instructor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('period');
    }
}
