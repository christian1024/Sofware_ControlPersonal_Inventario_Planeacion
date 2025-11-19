<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabDetallesProcedenciaPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labDetallesProcedenciaPedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_DetallesPedido')->unsigned();
            $table->foreign('id_DetallesPedido')->references('id')->on('labDetallesPedidos');
            $table->integer('CantidadInicial');
            $table->string('SemanaEntrega');
            $table->integer('CantidadModificada');
            $table->string('SemanaModificada')->nullable();
            $table->integer('Flag_Act');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labDetallesProcedenciaPedidos');
    }
}
