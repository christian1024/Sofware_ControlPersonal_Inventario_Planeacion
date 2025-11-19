<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class ProdInformacionTecnicaVariedades extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "prod_informacion_tecnica_variedades";
    protected $fillable = [
        'id',
        'Codigo_Integracion',
        'Porcentaje_Enraizamiento',
        'TablaVPD',
        'MEDIO_Enraizamiento',
        'tipo_de_bandeja',
        'Condiciones_crecimiento_Enraizamiento',
        'Hormonas_enraizamiento',
        'Horas_luz_enraizamiento',
        'Semanas_Enraizamiento',
        'Horas_luz_producción',
        'Sombra',
        'Búnker',
        'Bloque_siembra_Producción',
        'Medio_producción',
        'Hormona',
        'Tratamientos_adicionales',
        'Plantas_X_Canastilla',
        'Conductividad',
        'Primer_Pinch_Nudos',
        'Segundo_Pinch_Nudos',
        'Factor_Prod',
        'Tipo_esqueje',
        'Herramienta',
        'TamanoMinCm',
        'TamanoMaxCm',
        'Delicado',
        'Hojas_Maduras_Min',
        'Hojas_Maduras_Max',
        'Long_Base_Min_Pata',
        'Long_Base_Max_Pata',
        'Diam_Base_Min',
        'Diam_Base_Max',
        'Nudos_Min',
        'Nudos_Max',
        'Observaciones_Cosecha',
        'Buffer_Produccion',
        'Vida_Util',
        'Sem_adulta',
        'Semanas_en_producción',
        'Juvenil_1',
        'Juvenil_2',
        'Juvenil_3',
        'Factor_Juvenil_1',
        'Factor_Juvenil_2',
        'Factor_Juvenil_3',
        'Cant_Esquejes_Bolsillo',
        'Tamano_Esqueje',
        'Volumen',
        'Tamano_Esqueje_Renewal',
        'VolumenRenewal',
        'Cod_Autostix_Per1',
        'Cant_Esquejes_Bolsillo_Per1',
        'Cant_Esquejes_Regleta_Per1',
        'Volumen_Empaque_Per1',
        'Cod_Autostix_Per2',
        'Cant_Esquejes_Bolsillo_Per2',
        'Cant_Esquejes_Regleta_Per2',
        'Volumen_Empaque_Per2',
        'Flag_Activo',
    ];
}
