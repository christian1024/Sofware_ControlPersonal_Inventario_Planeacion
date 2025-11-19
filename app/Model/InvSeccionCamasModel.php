<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvSeccionCamasModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "inv_seccionCamas";
    protected $fillable = [
        'id',
        'id_Cama',
        'N_Seccion',
        'Flag_Activo',
    ];
}
