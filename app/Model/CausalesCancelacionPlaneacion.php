<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CausalesCancelacionPlaneacion extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "CausalesCancelacionPlaneacion";
    protected $fillable = [
        'causalCancelacion',
        'Flag_Activo'
    ];
}
