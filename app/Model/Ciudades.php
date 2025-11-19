<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_ciudades";
    protected $fillable = [
        'id',
        'Codigo_Ciudad',
        'ciudad',
        'id_departamento',
        'Flag_Activo'
    ];
}
