<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroPLotIDPropagacion extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "urcPropagacionsRegistroPlotID";
    protected $fillable = [
        'id',
        'PlotId',
        'CantidaInicialPlantasProgramadas',
        'CantidaPlantasPropagacionInicial',
        'CantidaPlantasPropagacionInventario',
        'Flag_Activo',
    ];
}
