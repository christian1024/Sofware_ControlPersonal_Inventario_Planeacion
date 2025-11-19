<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProdLecturaSalidaProduccionCF extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "prod_lectura_salida_produccion_CF";
    protected $fillable = [
        'id',
        'CodigoBarras',
        'idGetEtiquetas',
        'ID_TipoSalida',
        'ID_Usuario',
        'Flag_Activo'
    ];
}
