<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class urcLecturaArqueoPropagacion extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCLecturaArqueoPropagacions";
    protected $fillable = [
        'id_Patinador',
        'idUbicacion',
        'Plantas',
        'PlotId',
        'Semana',
    ];
}

