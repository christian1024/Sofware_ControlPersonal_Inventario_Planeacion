<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdInfotecAutostixPer2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_infotec_autostix_per2s', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('Codigo_Integracion');
            $table->integer('Codigo_Integracion_Autostix');
            $table->integer('Cant_Esquejes_Bolsillo');
            $table->integer('Cant_Esquejes_Regleta');
            $table->string('Tamano_Esqueje','20');
            $table->integer('Volumen');
            $table->String('TipoPer','10');
            $table->string('Observaciones','50')->nullable();
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
        Schema::dropIfExists('prod_infotec_autostix_per2s');
    }
}
