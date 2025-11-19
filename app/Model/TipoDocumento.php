<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Notifications\Notifiable;

class TipoDocumento extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_tipo_documentos";
    protected $fillable = [
        'id_Doc',
        'Tipo_Documento',
        'Iniciales',
        'Flag_Activo'
    ];
}
