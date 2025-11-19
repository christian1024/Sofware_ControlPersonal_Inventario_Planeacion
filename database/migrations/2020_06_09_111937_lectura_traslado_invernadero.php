<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LecturaTrasladoInvernadero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabLecturaTrasladoInvernadero', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_CamaInicial');
            $table->integer('id_SeccionCamaInicial');
            $table->string('CodigoBarras')->unique();
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
        Schema::dropIfExists('LabLecturaTrasladoInvernadero');
    }
}
