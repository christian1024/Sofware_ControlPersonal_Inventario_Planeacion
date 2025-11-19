<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UrcLecturaSalidaReneallProduccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCLecturaSalidaPropagacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador')->index();
            $table->integer('PlotID');
            $table->integer('CantPlantas');
            $table->integer('SemanaLectura');
            $table->integer('Flag_Activo');
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
        Schema::dropIfExists('URCLecturaSalidaPropagacion');
    }
}
