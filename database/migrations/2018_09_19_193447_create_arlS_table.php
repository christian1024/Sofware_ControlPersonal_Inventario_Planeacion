<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateARlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RRHH_arlS', function (Blueprint $table) {
            $table->increments('id');
            $table->string('arl','30');
            $table->string('Codigo_Arl','30')->unique();
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
        Schema::dropIfExists('RRHH_arlS');
    }
}

