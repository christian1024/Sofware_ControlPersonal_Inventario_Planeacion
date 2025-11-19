<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ARl extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_arlS";
    protected $fillable = [

        'id',
        'ARL',
        'Codigo_Arl',
        'Flag_Activo'
    ];
}
