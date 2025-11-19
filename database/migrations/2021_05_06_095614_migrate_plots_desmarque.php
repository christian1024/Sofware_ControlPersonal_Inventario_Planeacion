<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigratePlotsDesmarque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCPropagacionPlotDesmarque', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('PlotID');
            $table->integer('CausalDesmarte');
            $table->integer('CantidadPlantas');
            $table->integer('SemanaCreacion');
            $table->integer('IdUsuario');
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
        Schema::dropIfExists('URCPropagacionPlotDesmarque');
    }
}
