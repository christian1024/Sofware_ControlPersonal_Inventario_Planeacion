<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class arqueoInventarioModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabArqueoInventario";
    protected $fillable = [
        'id',
        'id_Cuarto',
        'id_estante',
        'id_piso',
        'CodigoBarras',
    ];
}
