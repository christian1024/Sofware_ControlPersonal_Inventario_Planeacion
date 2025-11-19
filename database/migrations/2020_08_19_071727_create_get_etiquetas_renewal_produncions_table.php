<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGetEtiquetasRenewalProduncionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GetEtiquetasRenewalProduncion', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('SemanaActual');
            $table->date('Fecha');
            $table->integer('PlotIDNuevo');
            $table->string('PlotIDOrigen','20');
            $table->string('SubPlotID','20')->nullable();
            $table->integer('CodigoIntegracion');
            $table->integer('Cantidad');
            $table->integer('VolumenVariedad');
            $table->integer('CantidadBolsillos');
            $table->string('CodigoBarras','10');
            $table->integer('Caja')->nullable();
            $table->string('CodigoBarrasCaja','10')->nullable();
            $table->integer('Bloque');
            $table->integer('Nave');
            $table->integer('Cama');
            $table->string('ProcedenciaInv','20');
            $table->integer('SemanaCosecha');
            $table->integer('ID_User');
            $table->string('Procedencia','10');
            $table->integer('Flag_Activo');
            $table->integer('Radicado');
            $table->integer('EsquejesXBolsillo');
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
        Schema::dropIfExists('GetEtiquetasRenewalProduncion');
    }
}
