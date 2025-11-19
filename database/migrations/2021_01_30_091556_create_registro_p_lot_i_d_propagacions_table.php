<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroPLotIDPropagacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urcPropagacionsRegistroPlotID', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('PlotId');
            $table->integer('CantidaInicialPlantasProgramadas');
            $table->integer('CantidaPlantasPropagacionInicial')->nullable();
            $table->integer('CantidaPlantasPropagacionInventario')->nullable();
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
        Schema::dropIfExists('urcPropagacionsRegistroPlotID');
    }
}
