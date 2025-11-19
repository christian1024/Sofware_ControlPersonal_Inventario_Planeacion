<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabIngresoIntroduccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabIngresoIntroduccions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Cantidad');
            $table->integer('IdVariedad')->unsigned();
            $table->foreign('IdVariedad')->references('id')->on('URC_Variedades');
            $table->integer('IdCliente')->unsigned();
            $table->foreign('IdCliente')->references('id')->on('clientesYBreeder_labs');
            $table->integer('IdContenedor')->unsigned();
            $table->foreign('IdContenedor')->references('id')->on('tipo_Contenedores_labs');
            $table->string('FechaEntrada');
            $table->string('Identificador');
            $table->integer('IdTipoFase')->unsigned();
            $table->foreign('IdTipoFase')->references('id')->on('tipo_fases_labs');
            $table->integer('IdUser')->unsigned();
            $table->foreign('IdUser')->references('id')->on('users');
            $table->integer('CodIntroducion');
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
        Schema::dropIfExists('LabIngresoIntroduccions');
    }
}
