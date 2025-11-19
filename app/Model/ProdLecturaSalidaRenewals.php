<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProdLecturaSalidaRenewals extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "prod_lectura_salida_renewals";
    protected $fillable = [
        'id',
        'CodigoBarras',
        'idGetEtiquetas',
        'ID_TipoSalida',
        'ID_Usuario',
        'Flag_Activo'
    ];
}
