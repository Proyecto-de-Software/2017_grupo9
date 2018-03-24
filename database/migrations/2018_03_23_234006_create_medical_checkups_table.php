<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalCheckupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_checkups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('age');
            $table->date('date');
            $table->float('weight');
            $table->float('height');
            $table->boolean('complete_vaccines');
            $table->string('complete_vaccines_observation');
            $table->boolean('correct_maturation');
            $table->string('correct_maturation_observation');
            $table->boolean('normal_physical_examination');
            $table->string('normal_physical_examination_observation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_checkups');
    }
}
