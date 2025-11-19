<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArqueoInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabArqueoInventario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_Cuarto');
            $table->integer('id_estante');
            $table->integer('id_piso');
            $table->string('CodigoBarras',9);
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
        Schema::dropIfExists('LabArqueoInventario');
    }
}
