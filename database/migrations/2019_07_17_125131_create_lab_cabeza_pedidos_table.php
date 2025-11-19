<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabCabezaPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labCabezaPedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Cliente')->unsigned();
            $table->foreign('id_Cliente')->references('id')->on('clientesYBreeder_labs');
            $table->string('SemanaEntrega')->nullable();
            $table->string('SemanaCreacion');
            $table->integer('NumeroPedido')->unique();
            $table->integer('id_UserCreacion')->unsigned();
            $table->foreign('id_UserCreacion')->references('id')->on('users');
            $table->string('EmailPlaneacion');
            $table->string('EstadoDocumento');
            $table->string('TipoPrograma');
            $table->string('Observaciones')->nullable();
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
        Schema::dropIfExists('labCabezaPedidos');
    }
}
