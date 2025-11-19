<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTickestModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TickestSistemas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idusuario');
            $table->string('Descripcion');
            $table->string('TipoSolicitud');
            $table->string('Jusificacion');
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
        Schema::dropIfExists('TickestSistema');
    }
}
