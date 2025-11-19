<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoFasesLab extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "tipo_fases_labs";
    protected $fillable = [
        'id',
        'Codigo',
        'NombreFase',
        'CantSemanas',
        'Flag_Activo'
    ];
}
