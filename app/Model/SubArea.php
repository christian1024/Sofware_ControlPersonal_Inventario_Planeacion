<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubArea extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_sub_areas";
    protected $fillable = [
        'id',
        'sub_area',
        'Id_Area',
        'Flag_Activo'
    ];
}
