<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposMediosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_medios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Codigo');
            $table->string('NombreMedio');
            $table->integer('IdArea')->unsigned();
            $table->foreign('IdArea')->references('id')->on('AreasMediosLabs');
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
        Schema::dropIfExists('tipos_medios');
    }
}
