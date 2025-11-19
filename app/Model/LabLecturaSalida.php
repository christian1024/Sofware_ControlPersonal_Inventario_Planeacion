<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LabLecturaSalida extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabLecturaSalidas";
    protected $fillable = [
        'id',
        'id_Patinador',
        'id_TipoSalida',
        'id_TipoCancelado',
        'CodigoBarras',
        'Flag_Activo',
        'FlagActivo_CambioFase',
        'SemanaLectura',
        'updated_at'
    ];
}
