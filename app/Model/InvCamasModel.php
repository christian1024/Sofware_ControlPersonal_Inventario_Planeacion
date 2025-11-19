<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvCamasModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "inv_camas";
    protected $fillable = [
        'id',
        'N_Cama',
        'Flag_Activo',
        'Descripcion'
    ];
}
