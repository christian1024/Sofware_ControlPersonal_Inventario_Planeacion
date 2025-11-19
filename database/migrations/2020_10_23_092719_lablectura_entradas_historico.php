<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LablecturaEntradasHistorico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabLecturaEntradasHistorico', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador')->index();
            $table->integer('id_Cuarto');
            $table->integer('id_estante');
            $table->integer('id_piso');
            $table->integer('Plantas')->nullable();
            $table->string('CodigoBarras');
            $table->string('ubicacioninven');
            $table->integer('idGetEtiquetas');
            $table->integer('CodOperario');
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
        Schema::dropIfExists('LabLecturaEntradasHistorico');
    }
}
