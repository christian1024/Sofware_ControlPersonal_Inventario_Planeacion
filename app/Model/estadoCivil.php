<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class estadoCivil extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_estado_civils";
    protected $fillable = [

        'id',
        'Estado_Civil',
        'Flag_Activo'
    ];
}
