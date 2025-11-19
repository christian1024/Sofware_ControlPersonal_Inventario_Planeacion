<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelEntradaSalidaPersonalMonitoreo extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "EntradaSalidaPersonalMonitoreo";
    protected $fillable = [
        'CodigoEmpleado',
        'IDPatinadorEntrada',
        'Flag_ActivoEntrada',
        'IDPatinadorSalida'

    ];


}
