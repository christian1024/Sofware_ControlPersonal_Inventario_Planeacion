<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sisben extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_Sisbens";
    protected $fillable = [

        'Nivel_Sisben',
        'Flag_Activo'
    ];
}
