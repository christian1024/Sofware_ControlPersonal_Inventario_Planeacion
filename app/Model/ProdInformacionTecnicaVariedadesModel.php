<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProdInformacionTecnicaVariedadesModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "prod_informacion_tecnica_variedades";
    protected $fillable = [
        'id',
        'Codigo_Integracion',
        'Cant_Esquejes_Bolsillo',
        'Tamano_Esqueje',
        'Volumen',
        'Observaciones',
        'Flag_Activo',
    ];
}
