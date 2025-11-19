<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UrcLecturaEntradaPropagacionModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCLecturaEntradaPropagacion";
    protected $fillable = [
        'id_Patinador',
        'idUbicacion',
        'Plantas',
        'CodigoBarras',
        'CodOperario',
        'SemanaLectura',
        'PlotId',
        'Flag_Activo',
    ];
}
