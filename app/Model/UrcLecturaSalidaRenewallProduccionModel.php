<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UrcLecturaSalidaRenewallProduccionModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCLecturaSalidaPropagacion";
    protected $fillable = [
        'id',
        'id_Patinador',
        'PlotID',
        'CantPlantas',
        'SemanaLectura',
        'Flag_Activo',
    ];
}
