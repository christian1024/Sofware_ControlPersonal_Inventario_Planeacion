<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class tickestModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "TickestSistemas";
    protected $fillable = [
        'idusuario',
        'Descripcion',
        'TipoSolicitud',
        'Jusificacion',
        'AtendidoPor',
        'Flag_Activo',
        'created_at',
        'updated_at'
    ];
}
