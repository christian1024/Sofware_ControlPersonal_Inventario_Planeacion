<?php

namespace App\Models;

use App\Models\ClientesLab;
use App\Models\TipoFasesLab;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LabCambioFases extends Model
{
    //protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "CambioFasesCh";
    protected $fillable = [
        'ID',
        'ID_Variedad',
        'Indentificador',
        'CantSalidas',
        'CantPlantas',
        'CantAdicional',
        'TipoContenedor',
        'FaseActual',
        'FaseNueva',
        'Flag_Activo',
        'FechaUltimoMovimiento',
        'FechaEntrada',
        'FechaDespacho',
        'Radicado',
        'Cliente',
    ];


}
