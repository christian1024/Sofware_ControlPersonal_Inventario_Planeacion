<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RRHH_CajasCompensacion extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_CajasCompensacion";
    protected $fillable = [

        'id',
        'NombreCompensacion',
        'CodigoCompensacion'
    ];
}
