<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class URCPropagacionModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URC_Propagacion";
    protected $fillable = [
        'id',
        'Ubicacion',
        'CapacidadBandejas',
        'CapacidadEsquejes',
        'Flag_Activo'
    ];
}
