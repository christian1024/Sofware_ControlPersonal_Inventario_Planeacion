<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LecturaDescarteInvernadero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabLecturaDescarteInvernadero', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idPatinador');
            $table->string('CodigoBarras');
            $table->string('CausalDescarte');
            $table->string('PlantasDescartadas');
            $table->integer('SemanaLectura');

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
        Schema::dropIfExists('LabLecturaDescarteInvernadero');
    }
}
