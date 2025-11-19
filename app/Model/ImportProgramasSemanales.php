<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImportProgramasSemanales extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "ImportProgramasSemanales";
    protected $fillable = [
        'CodigoVariedad',
        'cliente',
        'SemanaDespacho',
        'FaseEntrada',
        'CantidadSolicitada'
    ];
}
