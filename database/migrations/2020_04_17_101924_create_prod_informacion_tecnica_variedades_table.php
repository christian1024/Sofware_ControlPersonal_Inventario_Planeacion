<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdInformacionTecnicaVariedadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_informacion_tecnica_variedades', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('Codigo_Integracion');
            $table->decimal('Porcentaje_Enraizamiento','5','2')->nullable();
            $table->string('TablaVPD','5')->nullable();
            $table->string('MEDIO_Enraizamiento','100')->nullable();
            $table->integer('tipo_de_bandeja')->nullable();
            $table->string('Condiciones_crecimiento_Enraizamiento','100')->nullable();
            $table->string('Hormonas_enraizamiento','20')->nullable();
            $table->integer('Horas_luz_enraizamiento');
            $table->integer('Semanas_Enraizamiento');
            $table->string('Horas_luz_producción','10')->nullable();
            $table->string('Sombra','50')->nullable();
            $table->string('Búnker','50')->nullable();
            $table->integer('Bloque_siembra_Producción')->nullable();
            $table->string('Medio_producción','100')->nullable();
            $table->string('Hormona','250')->nullable();
            $table->string('Tratamientos_adicionales','250')->nullable();
            $table->integer('Plantas_X_Canastilla')->nullable();
            $table->string('Conductividad','20')->nullable();
            $table->string('Primer_Pinch_Nudos','20')->nullable();
            $table->string('Segundo_Pinch_Nudos','20')->nullable();
            $table->decimal('Factor_Prod','10','3')->nullable();
            $table->string('Tipo_esqueje','20')->nullable();
            $table->string('Herramienta','20')->nullable();
            $table->decimal('TamanoMinCm','10','3')->nullable();
            $table->decimal('TamanoMaxCm','10','3')->nullable();
            $table->string('Delicado','10')->nullable();
            $table->decimal('Hojas_Maduras_Min','10','3')->nullable();
            $table->decimal('Hojas_Maduras_Max','10','3')->nullable();
            $table->string('Long_Base_Min_Pata','15')->nullable();
            $table->string('Long_Base_Max_Pata','15')->nullable();
            $table->string('Diam_Base_Min','15')->nullable();
            $table->string('Diam_Base_Max','15')->nullable();
            $table->string('Nudos_Min','15')->nullable();
            $table->string('Nudos_Max','15')->nullable();
            $table->string('Observaciones_Cosecha','max');
            $table->string('Buffer_Produccion','50')->nullable();
            $table->integer('Vida_Util')->nullable();
            $table->integer('Sem_adulta')->nullable();
            $table->integer('Semanas_en_producción')->nullable();
            $table->string('Juvenil_1','50')->nullable();
            $table->string('Juvenil_2','50')->nullable();
            $table->string('Juvenil_3','50')->nullable();
            $table->string('Factor_Juvenil_1','50')->nullable();
            $table->string('Factor_Juvenil_2','50')->nullable();
            $table->string('Factor_Juvenil_3','50')->nullable();
            $table->integer('Cant_Esquejes_Bolsillo')->nullable();
            $table->string('Tamano_Esqueje','20')->nullable();
            $table->string('Volumen','50')->nullable();
            $table->string('Tamano_Esqueje_Renewal','20')->nullable();
            $table->string('VolumenRenewal','50')->nullable();
            $table->integer('Cod_Autostix_Per1')->nullable();
            $table->integer('Cant_Esquejes_Bolsillo_Per1')->nullable();
            $table->integer('Cant_Esquejes_Regleta_Per1')->nullable();
            $table->integer('Volumen_Empaque_Per1')->nullable();
            $table->integer('Cod_Autostix_Per2')->nullable();
            $table->integer('Cant_Esquejes_Bolsillo_Per2')->nullable();
            $table->integer('Cant_Esquejes_Regleta_Per2')->nullable();
            $table->integer('Volumen_Empaque_Per2')->nullable();
            $table->integer('Cod_Autostix_Media')->nullable();
            $table->integer('Cant_Esquejes_Media')->nullable();
            $table->integer('Volumen_Empaque_Media')->nullable();
            $table->integer('Cod_Callused')->nullable();
            $table->integer('Cant_Esquejes_Callused')->nullable();
            $table->integer('Volumen_Empaque_Callused')->nullable();
            $table->string('Flag_Activo','50');
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
        Schema::dropIfExists('prod_informacion_tecnica_variedades');
    }
}
