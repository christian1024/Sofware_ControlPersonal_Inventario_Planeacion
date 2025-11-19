<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateIntroduccionesFuturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabIntroduciconesFuturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('SemanaIntroduccion');
            $table->integer('IdCliente');
            $table->integer('IdVariedad')->nullable();
            $table->integer('IdGenero')->nullable();
            $table->string('TipoIntroduccion')->nullable();
            $table->integer('Cantidad')->nullable();
            $table->integer('SemanaCreacion');
            $table->integer('idusers');
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
        Schema::dropIfExists('LabIntroduciconesFuturas');
    }
}
