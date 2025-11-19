<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UrcLecturaDescarteRenewallProduccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCLecturaDescartePropagacion', function (Blueprint $table) {
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
        Schema::dropIfExists('URCLecturaDescartePropagacion');
    }
}
