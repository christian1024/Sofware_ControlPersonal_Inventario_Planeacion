<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MedioTransporte extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_medio_transportes";
    protected $fillable = [

        'Tipo_Trasporte',
        'Flag_Activo'
    ];
}
