<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloqueAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RRHH_bloque_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bloque_area','25');
            $table->integer('Id_Sub_Area')->unsigned();
            $table->foreign('Id_Sub_Area')->references('id')->on('RRHH_sub_areas');
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
        Schema::dropIfExists('RRHH_bloque_areas');
    }
}
