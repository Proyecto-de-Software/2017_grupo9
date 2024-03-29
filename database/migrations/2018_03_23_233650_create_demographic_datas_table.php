<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemographicDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demographic_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('electricity');
            $table->boolean('pet');
            $table->boolean('refrigerator');
            $table->integer('patient_id')->unsigned();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');;
            $table->integer('typeHeating_id')->unsigned();
            $table->integer('typeLivingPlace_id')->unsigned();
            $table->integer('typeWater_id')->unsigned();
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
        Schema::dropIfExists('demographic_datas');
    }
}
