<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LabInfotecicaTiposFrascos extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "lab_infotecica_tipos_frascos";
    protected $fillable = [
        'id',
        'id_Variedad',
        'id_fase',
        'id_tipofrasco',
        'Cantidad',
        'IdUser',
        'Flag_Activo',
    ];
}
