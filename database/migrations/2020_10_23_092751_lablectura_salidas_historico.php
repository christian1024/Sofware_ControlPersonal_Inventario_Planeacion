<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LablecturaSalidasHistorico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabLecturaSalidasHistorico', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador');
            $table->integer('id_TipoSalida');
            $table->integer('id_TipoCancelado')->nullable();
            $table->string('CodigoBarras');
            $table->integer('Flag_Activo');
            $table->integer('SemanaLectura');
            $table->integer('FlagActivo_CambioFase')->nullable();
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
        Schema::dropIfExists('LabLecturaSalidasHistorico');
    }
}
