<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UrcLecturaHormonaPropagacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCLecturaHormonal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idPatinador');
            $table->integer('CodOperario');
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
        Schema::dropIfExists('URCLecturaHormonal');
    }
}
