<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LecturaEntradaCF extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "lecturaEntradaCuartoFrios";
    protected $fillable = [
        'CodigoBarras',
        'Idpatinador',
        'Flag_Activo'
    ];

}
