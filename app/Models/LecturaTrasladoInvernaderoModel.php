<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LecturaTrasladoInvernaderoModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabLecturaTrasladoInvernadero";
    protected $fillable = [
        'id',
        'id_CamaInicial',
        'id_SeccionCamaInicial',
        'CodigoBarras'
    ];
}
