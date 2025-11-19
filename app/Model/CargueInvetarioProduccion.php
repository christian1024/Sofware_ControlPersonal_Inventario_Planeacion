<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CargueInvetarioProduccion extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "cargue_invetario_produccions";
    protected $fillable = [
        'id',
        'PlotID',
        'Subdivision_PlotID',
        'CodigoIntegracion',
        'Bloque',
        'Nave',
        'Cama',
        'Cant_Plantas',
        'Fecha_Siembra',
        'Procedencia',
        'Estado_Comercial',
        'Breeder',
        'Area',
        'Semana_Labor',
        'Factor_Hoy',
        'Factor',
        'Estatus_Fito',
        'Sem_Descarte',
        'Observaciones',
        'Semana_Actual',
        'Cant_Esquejes',
        'Porcentaje_Participacion',
        'Cant_Bolsillos',
        'Cant_Bolsillos_Autostix1',
        'Cant_Bolsillos_Autostix2',
        'Cant_Bolsillos_Callused',
        'Cant_Bolsillos_AutostixM',
        'Cant_Bolsillos_Inicial',
        'Flag_Activo',
    ];
}
