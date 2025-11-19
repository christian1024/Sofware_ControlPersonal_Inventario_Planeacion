<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelConfirmacionesCargueUrc extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCConfirmacionesCargueUrc";
    protected $fillable = [
        'PlotID',
        'Codigo',
        'Genero',
        'Variedad',
        'Especie',
        'PlantasSembrar',
        'CantidadCanastillas',
        'SemanaSiembra',
        'Procedencia',
        'DensidadSiembra',
        'HoraLuz',
        'BloqueSiembra',
        'TipoBandeja',
        'SemanaCargue',
    ];
}
