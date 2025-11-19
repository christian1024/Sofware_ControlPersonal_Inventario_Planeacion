<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GetEtiquetaslabHistorico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GetEtiquetasLabInventarioHistorico', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->integer('ID_Variedad');
            $table->integer('CodigoVariedad');
            $table->string('BarCode',10);
            $table->integer('CanInventario');
            $table->integer('CantContenedor');
            $table->string('TipoContenedor');
            $table->integer('CantEtiquetas');
            $table->integer('ID_Inventario');
            $table->string('SemanUltimoMovimiento');
            $table->string('SemanaIngreso');
            $table->string('SemanaDespacho')->nullable();
            $table->string('Indentificador');
            $table->string('Procedencia');
            $table->string('cliente');
            $table->string('ID_FaseActual');
            $table->integer('Radicado')->nullable();
            $table->integer('id_Cuarto')->nullable();
            $table->integer('id_Estante')->nullable();
            $table->integer('id_Nivel')->nullable();
            $table->integer('Impresa')->nullable();
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
        Schema::dropIfExists('GetEtiquetasLabInventarioHistorico');
    }
}
