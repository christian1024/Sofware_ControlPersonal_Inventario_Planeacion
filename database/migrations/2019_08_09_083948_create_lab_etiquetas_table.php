<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabEtiquetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labEtiquetas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('IdProcedencia');
            $table->string('Procedencia');
            $table->string('CodigoBarras')->unique();
            $table->integer('IdUser');
            $table->string('SemanaGenerada');
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
        Schema::dropIfExists('labEtiquetas');
    }
}
