<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelInfotecnicaGeneroPruebas extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabInformacionTecnicaGenerosPruebas";
    protected $fillable = [
        'id',
        'IdGenero',
        'Index',
        'AgroRhodo',
        'Screen',
        'Flag_Activo'
    ];
}
