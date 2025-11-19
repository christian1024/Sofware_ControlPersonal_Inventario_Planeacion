<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tipo_contrato extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_tipo_contratos";
    protected $fillable = [
        'id',
        'Tipo_Contrato',
        'Flag_Activo'
    ];
}
