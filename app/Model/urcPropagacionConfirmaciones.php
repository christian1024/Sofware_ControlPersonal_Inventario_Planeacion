<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class urcPropagacionConfirmaciones extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "urcPropagacionConfirmaciones";
    protected $fillable = [
        'PlotId',
        'PlantasdisponiblesInicales',
        'plantasconfirmadas',
        'semanaConfirmacion',
        'semanaConfirmacionModificada',
        'CausalMovimiento',
        'CausalDescarte',
        'SemanaCreado',
        'Descargado',
        'Flag_Activo',
    ];
}
