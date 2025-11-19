<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RRHH_ciudades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Codigo_Ciudad');
            $table->string('ciudad','50');
            $table->integer('id_departamento')->unsigned();
            $table->foreign('id_departamento')->references('id')->on('RRHH_departamentos');
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
        Schema::dropIfExists('RRHH_ciudades');
    }
}
