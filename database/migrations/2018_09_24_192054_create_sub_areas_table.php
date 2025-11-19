<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RRHH_sub_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Sub_Area','25')->unique();
            $table->integer('CodigoSubArea')->unique();
            $table->integer('Id_Area')->unsigned();
            $table->foreign('Id_Area')->references('id')->on('RRHH_areas');
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
        Schema::dropIfExists('RRHH_sub_areas');
    }
}
