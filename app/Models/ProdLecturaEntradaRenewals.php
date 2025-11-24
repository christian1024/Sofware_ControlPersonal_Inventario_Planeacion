<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdLecturaEntradaRenewals extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "prod_lectura_entrada_renewals";
    protected $fillable = [
        'id',
        'CodigoBarras',
        'idGetEtiquetas',
        'ID_Usuario',
        'Flag_Activo'
    ];
}
