<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LabInfotecnicaVariedades extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "lab_infotecnica_variedades";
    protected $fillable = [
        'id',
        'id_Variedad',
        'CoeficienteMultiplicacion',
        'PorcentajePerdida',
        'id_fase',
        'PorcentajePerdidaFase',
        'SemanasXFase',
        'IdUser',
        'Flag_Activo',
    ];

    static function DeleteForVariedad ($id_Variedad)
    {
        $delete = DB::table('lab_infotecnica_variedades')
            ->where('id_Variedad', $id_Variedad)
            ->delete();
        return $delete;
    }

}
