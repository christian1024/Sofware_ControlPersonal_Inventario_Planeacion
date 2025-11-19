<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImportProgramasSemanales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ImportProgramasSemanales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('CodigoVariedad');
            $table->string('cliente');
           /* $table->string('Identificador','16');*/
            $table->integer('SemanaDespacho');
            $table->integer('FaseEntrada');
            $table->string('CantidadSolicitada');
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
        //
    }
}
