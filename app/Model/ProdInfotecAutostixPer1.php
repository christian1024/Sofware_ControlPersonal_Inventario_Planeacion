<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class ProdInfotecAutostixPer1 extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "prod_infotec_autostix_per1s";
    protected $fillable = [
        'id',
        'Codigo_Integracion',
        'Codigo_Integracion_Autostix',
        'Cant_Esquejes_Bolsillo',
        'Cant_Esquejes_Regleta',
        'Tamano_Esqueje',
        'Volumen',
        'TipoPer',
        'Observaciones',
        'Flag_Activo',
    ];
}
