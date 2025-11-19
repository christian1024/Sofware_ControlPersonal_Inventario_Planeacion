<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaneacionSemanalPorPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planeacionsemanalXpedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('IdItemDetallePedido')->unsigned();
            $table->foreign('IdItemDetallePedido')->references('id')->on('labDetallesPedidosPlaneacion');
            $table->string('SemanaMovimiento',10);
            $table->string('CantidadPlantas',10);
            $table->string('fase',10);
            $table->integer('flag_Activo');
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
        Schema::dropIfExists('planeacionsemanalXpedidos');
    }
}
