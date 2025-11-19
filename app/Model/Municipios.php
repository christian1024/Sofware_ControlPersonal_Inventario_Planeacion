<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Notifications\Notifiable;

class Municipios extends Model
{

    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_municipios";
    protected $fillable = [
        'id',
        'Municipios',
        'Flag_Activo'
    ];
}
