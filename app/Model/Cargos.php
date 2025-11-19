<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cargos extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_cargos";
    protected $fillable = [
        'id',
        'Cargo',
        'Flag_Activo'
    ];
}
