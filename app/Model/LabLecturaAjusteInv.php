<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LabLecturaAjusteInv extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabLecturaAjusteInvs";
    protected $fillable = [
        'id',
        'id_Patinador',
        'id_TipoSalida',
        'id_Cuarto',
        'id_estante',
        'id_piso',
        'CodigoBarras',
        'Flag_Activo',
        'SemanaLectura'
    ];
}
