<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientesLab extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "clientesYBreeder_labs";
    protected $fillable = [
        'id',
        'Indicativo',
        'Nombre',
        'Nit',
        'Tipo',
        'Flag_Activo',
    ];

    public static function clientesActivos()
    {
        $activos = ClientesLab::select('id','Nombre','Nit','Tipo','Indicativo')
            ->where('Flag_Activo', '=', '1')
            //->where('Tipo','=','Cliente')
            ->orderBy('Nombre','ASC')
            ->get();
        return $activos;
    }
}
