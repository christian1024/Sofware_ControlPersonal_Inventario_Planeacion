<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LabEtiquetasMigradas extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabEtiquetasMigradas";
    protected $fillable = [
        'id',
        'CodigoBarras',
        'SemanaDespacho',
        'FaseActual',
        'Identificador',
        'cliente',
        'NewSemanaDespacho',
        'NewFaseActual',
        'NewCliente',
        'Impresa',
        'CodigoRadicado'
    ];
}
