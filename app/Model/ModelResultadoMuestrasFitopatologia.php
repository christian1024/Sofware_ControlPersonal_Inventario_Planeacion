<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelResultadoMuestrasFitopatologia extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabMuestrasFitopatologia";
    protected $fillable = [
        'id',
        'Identificador',
        'CodigoBarras',
        'SemanaActual',
        'ResultadoIndex',
        'MuestrasScreen',
        'PositivosMuestrasScreen',
        'PositivosMuestrasScreenRestringidas',
        'AgroRhodoPruebaUno',
        'AgroRhodoPruebaDos',
        'AgroRhodoPruebaTres',
        'AgroRhodoPruebaCuatro'
    ];
}
