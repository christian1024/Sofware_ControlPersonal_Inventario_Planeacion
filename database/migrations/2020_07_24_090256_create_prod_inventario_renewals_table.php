<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdInventarioRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_inventario_renewals', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('Semana');
            $table->date('Fecha');
            $table->integer('PlotIDNuevo');
            $table->string('PlotIDOrigen','20');
            $table->string('SubPlotID','20')->nullable();
            $table->integer('CodigoIntegracion');
            $table->integer('Cantidad');
            $table->integer('CantidadBolsillos')->nullable();
            $table->integer('Bloque');
            $table->integer('Nave');
            $table->integer('Cama');
            $table->string('Procedencia','20');
            $table->integer('SemanaCosecha');
            $table->integer('ID_User');
            $table->integer('Flag_Activo');
            $table->integer('legalizar');
            $table->string('source');
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
        Schema::dropIfExists('prod_inventario_renewals');
    }
}
