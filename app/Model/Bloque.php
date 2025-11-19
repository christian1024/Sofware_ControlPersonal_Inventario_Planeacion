<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_bloque_areas";
    protected $fillable = [
        'id',
        'bloque_area',
        'Id_Sub_Area',
        'Flag_Activo'
    ];
}
