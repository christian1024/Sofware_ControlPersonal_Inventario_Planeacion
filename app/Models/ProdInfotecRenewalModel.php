<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdInfotecRenewalModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "prod_infotec_renewal";
    protected $fillable = [
        'id',
        'CodigoVariedad',
        'TamañoEsqueje',
        'EsquejesXBolsillo',
        'Flag_Activo',
    ];
}
