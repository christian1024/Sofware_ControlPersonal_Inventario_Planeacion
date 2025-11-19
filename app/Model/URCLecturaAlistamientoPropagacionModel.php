<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class URCLecturaAlistamientoPropagacionModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "urcLecturaAlistamientoPropagacion";
    protected $fillable = [
        'id_Patinador',
        'CodOperario',
        'CodigoBarras',
        'CantPlantas',
    ];
}
