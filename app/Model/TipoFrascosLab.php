<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoFrascosLab extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "tipo_Contenedores_labs";
    protected $fillable = [
        'id',
        'TipoContenedor',
        'Cantidad',
        'Flag_Activo',
    ];

    public static function ContenedoresActivos()
    {
        $contenedoresActivos = TipoFrascosLab::query()
            ->select('id','TipoContenedor','Cantidad')
            ->where('Flag_Activo','=',1)
            ->get();

        return $contenedoresActivos;
    }
}
