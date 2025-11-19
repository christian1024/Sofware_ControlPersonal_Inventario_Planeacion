<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LabIngresoIntroduccion extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabIngresoIntroduccions";
    protected $fillable = [
        'id',
        'Cantidad',
        'IdVariedad',
        'IdCliente',
        'IdContenedor',
        'FechaEntrada',
        'Identificador',
        'IdTipoFase',
        'CodIntroducion',
        'IdUser',
        'Flag_Activo',
        'Comentario'
    ];

    public static function IntroduccionesAcivas()
    {

        $Consulta = DB::table('LabIngresoIntroduccions')
            ->join('clientesYBreeder_labs as clien', 'clien.id', '=', 'LabIngresoIntroduccions.IdCliente')
            ->select(
                'clien.Nombre',
                'LabIngresoIntroduccions.CodIntroducion'
            )
            ->where('LabIngresoIntroduccions.Flag_Activo', '=', 1)
            ->groupBy(['LabIngresoIntroduccions.CodIntroducion',
                'clien.Nombre'])
            ->get();

        return $Consulta;

    }
}
