<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientesYBreeder_labs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Indicativo');
            $table->string('Nombre');
            $table->string('Nit')->nullable();
            $table->string('Tipo');
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
        Schema::dropIfExists('clientesYBreeder_labs');
    }
}
