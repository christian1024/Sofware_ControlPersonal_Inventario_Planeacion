<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LabdetallesPedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labDetallesPedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Variedad')->unsigned();
            $table->foreign('id_Variedad')->references('id')->on('URC_Variedades');
            $table->string('TipoEntrega');
            $table->integer('CantidadInicial');

            $table->integer('cantidadFinal')->nullable();

            $table->integer('CantidadModificada')->nullable();

            $table->string('SemanaEntrega');

            $table->string('SemanaConfirmada')->nullable();

            $table->string('SemanaModificada')->nullable();
            $table->integer('id_CabezaPedido')->unsigned();
            $table->foreign('id_CabezaPedido')->references('id')->on('labCabezaPedidos');
            $table->integer('Flag_Activo');
            $table->string('Programas');
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
        Schema::dropIfExists('labDetallesPedidos');
    }
}
