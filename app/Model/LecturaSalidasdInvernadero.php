<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LecturaSalidasdInvernadero extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabLecturaSalidasInvernadero";
    protected $fillable = [
        'id',
        'id_Patinador',
        'id_TipoSalida',
        'id_TipoCancelado',
        'CodigoBarras',
        'Flag_Activo',
        'SemanaLectura'
    ];
}
