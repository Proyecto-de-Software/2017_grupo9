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
            $table->date('date');
            $table->float('weight');
            $table->boolean('complete_vaccines');
            $table->string('complete_vaccines_observation');
            $table->boolean('correct_maturation');
            $table->string('correct_maturation_observation');
            $table->boolean('normal_physical_examination');
            $table->string('normal_physical_examination_observation');
            $table->float('pc')->nullable();
            $table->float('ppc')->nullable();
            $table->float('height')->nullable();
            $table->string('food_description')->nullable();
            $table->string('general_observation')->nullable();
            $table->integer('patient_id')->unsigned();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
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
