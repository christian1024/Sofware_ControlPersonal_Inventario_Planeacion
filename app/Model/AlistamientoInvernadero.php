<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AlistamientoInvernadero extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "AlistamientoInvernadero";
    protected $fillable = [
        'id_Patinador',
        'Operario',
        'CantPlantas',
        'CodigoBarras',
        'SemanaLectura'
    ];
}
