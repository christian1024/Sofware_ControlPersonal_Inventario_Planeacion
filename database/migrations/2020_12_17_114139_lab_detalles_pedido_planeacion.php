<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LabDetallesPedidoPlaneacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labDetallesPedidosPlaneacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Variedad')->unsigned();
            $table->foreign('id_Variedad')->references('id')->on('URC_Variedades');
            $table->integer('id_CabezaPedido')->unsigned();
            $table->foreign('id_CabezaPedido')->references('id')->on('labCabezaPedidos');
            $table->string('TipoEntrega',25);
            $table->integer('CantidadInicial');
            $table->string('SemanaEntrega',6);
            $table->string('TipoEntregaModificada',25);
            $table->integer('CantidadInicialModificada');
            $table->string('SemanaEntregaModificada',6);
            $table->string('SemanaModificacion',6)->nullable();
            $table->string('SemanaRealizoPlaneacion',6)->nullable();
            $table->integer('CantidadStock')->nullable();
            $table->integer('CantidadGermo')->nullable();
            $table->string('FactorInformacionTecnica',5)->nullable();
            $table->string('FactorPlaneacion',5)->nullable();
            $table->string('SemanaPlaneacion',6)->nullable();
            $table->integer('CantidadPlaneacion')->nullable();
            $table->string('SemanaPlaneacionCicloantes',6)->nullable();
            $table->integer('CantidadPlaneacionCicloantes')->nullable();
            $table->string('SemanaPlaneacionCicloFinal',6)->nullable();
            $table->integer('CantidadPlaneacionCicloFinal')->nullable();
            $table->string('SemanaPlaneacionEnraizamiento',6)->nullable();
            $table->integer('CantidadPlaneacionEnraizamiento')->nullable();
            $table->string('SemanaPlaneacionAdaptado',6)->nullable();
            $table->integer('CantidadPlaneacionAdaptado')->nullable();
            $table->string('SemanaPlaneacionDespacho',6)->nullable();
            $table->string('ObservacionCancelacion',50)->nullable();
            $table->string('ObservacionnuevoItem',50)->nullable();
            $table->integer('Flag_Activo');
            $table->string('FechaCancelacion',20)->nullable();
            $table->string('FechaModificacion',20)->nullable();
            $table->string('SemanasXFaseMultiplicacion',20)->nullable();
            $table->string('SemanasXFaseEnra',20)->nullable();
            $table->string('PorcentajePerdidaFaseEnra',20)->nullable();
            $table->string('SemanasXFaseAdap',20)->nullable();
            $table->string('PorcentajePerdidaFaseAdap',20)->nullable();
            $table->integer('Flag_ActivoPlaneacion')->nullable();
            $table->integer('FlagActivo_EstadoPreConfirmacion')->nullable();
            $table->integer('FlagActivo_CancelacionPreConfirmado')->nullable();
            $table->dateTime('FechaPreConfirmacionCliente')->nullable();
            $table->integer('CausalCancelacionEjecucion')->nullable();
            $table->integer('CancelacionEjecucion')->nullable();
            $table->integer('RadicadoCancelacion')->nullable();
            $table->integer('IdDetalleInicial')->nullable();
            $table->integer('Flag_ActivoReplanteado')->nullable();
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
        Schema::dropIfExists('labDetallesPedidosPlaneacion');
    }
}
