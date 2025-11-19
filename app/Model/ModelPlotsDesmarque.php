<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelPlotsDesmarque extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCPropagacionPlotDesmarque";
    protected $fillable = [
        'PlotID',
        'CausalDesmarte',
        'CantidadPlantas',
        'SemanaCreacion',
        'IdUsuario'
    ];
}
