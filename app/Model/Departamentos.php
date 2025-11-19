<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Notifications\Notifiable;

class Departamentos extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_departamentos";
    protected $fillable = [
        'id',
        'Codigo_Departamento',
        'Departamento',
        'Flag_Activo'
        //este es el modelo mustre la tablas
        //el modelo de ciudades?
    ];
}
