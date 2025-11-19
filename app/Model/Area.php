<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_areas";
    protected $fillable = [
        'Area',
        'Codigo',
        'Flag_Activo'
    ];
}
