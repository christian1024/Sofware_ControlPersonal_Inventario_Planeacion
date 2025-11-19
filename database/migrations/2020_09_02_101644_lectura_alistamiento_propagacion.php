<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LecturaAlistamientoPropagacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urcLecturaAlistamientoPropagacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador');
            $table->integer('CodOperario');
            $table->string('CodigoBarras');
            $table->integer('CantPlantas');
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
        Schema::dropIfExists('urcLecturaAlistamientoPropagacion');
    }
}
