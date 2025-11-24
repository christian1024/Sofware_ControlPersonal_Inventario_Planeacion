<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargueEtiquetasPro extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "CargueEtiquetasPros";
    protected $fillable = [
        'CodigoVariedad',
        'CodigoBarras',
        'CodigoCaja',
        'CodigoBarrasCaja',
        'diadespacho',
    ];
}
