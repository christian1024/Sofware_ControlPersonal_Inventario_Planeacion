<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateCausalesFitosanidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCCausalesFitosanidad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Causal',50);
            $table->string('ColorBandera',250)->nullable();
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
        Schema::dropIfExists('URCCausalesFitosanidad');
    }
}
