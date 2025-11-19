<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class URCLecturaEntregaParcialPropagacionModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URClecturaEntregaParcialPropagacions";
    protected $fillable = [
        'CodigoBarras',
        'IdCausalParcial',
        'PlantasEntregar',
        'Flag_Activo'
    ];
}
