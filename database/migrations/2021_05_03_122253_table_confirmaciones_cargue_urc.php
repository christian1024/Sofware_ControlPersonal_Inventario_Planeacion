<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableConfirmacionesCargueUrc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCConfirmacionesCargueUrc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('PlotID');
            $table->string('Codigo');
            $table->string('Genero');
            $table->string('Variedad');
            $table->string('Especie');
            $table->string('PlantasSembrar')->nullable();
            $table->string('CantidadCanastillas')->nullable();
            $table->string('SemanaSiembra')->nullable();
            $table->string('Procedencia')->nullable();
            $table->string('DensidadSiembra')->nullable();
            $table->string('HoraLuz')->nullable();
            $table->string('BloqueSiembra')->nullable();
            $table->string('TipoBandeja')->nullable();
            $table->integer('SemanaCargue');
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
        Schema::dropIfExists('URCConfirmacionesCargueUrc');
    }
}
