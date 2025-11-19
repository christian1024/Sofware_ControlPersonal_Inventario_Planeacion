<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PlaneacionSemanalPorPedido extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "planeacionsemanalXpedidos";
    protected $fillable = [
        'IdItemDetallePedido',
        'SemanaMovimiento',
        'CantidadPlantas',
        'fase',
        'flag_Activo'
    ];


    public static function DetallesPlaneacionSemanaAsemana($id)
    {
        $detallesplaneacionSemanas= PlaneacionSemanalPorPedido::query()
            ->select(['planeacionsemanalXpedidos.*','fa.NombreFase'])
            ->join('tipo_fases_labs as fa','fa.id','=','fase')
            ->where('IdItemDetallePedido',decrypt($id))
            ->where('planeacionsemanalXpedidos.flag_Activo',1)
            ->orderBy('SemanaMovimiento')
            ->get();

        return $detallesplaneacionSemanas;
    }
}
