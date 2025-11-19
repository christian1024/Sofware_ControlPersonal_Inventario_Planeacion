<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabCambioFasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_cambio_fases', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('ID_Variedad','20');
            $table->string('Indentificador','20');
            $table->integer('CantSalidas');
            $table->integer('CantPlantas');
            $table->integer('CantAdicional');
            $table->string('TipoContenedor','20');
            $table->string('FaseActual','50');
            $table->string('FaseNueva','50');
            $table->integer('Flag_Activo');
            $table->string('FechaUltimoMovimiento','10');
            $table->string('FechaEntrada','10');
            $table->string('FechaDespacho','10');
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
        Schema::dropIfExists('lab_cambio_fases');
    }
}
