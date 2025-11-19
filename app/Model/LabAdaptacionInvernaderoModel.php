<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LabAdaptacionInvernaderoModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Labadaptacioninvernadero";
    protected $fillable = [
        'id',
        'Cantidad',
        'IdVariedad',
        'IdCliente',
        'IdContenedor',
        'SemanaEntrada',
        'SemanaDespacho',
        'Identificador',
        'IdTipoFase',
        'IdUser',
        'CodAdaptacion',
        'CodigoInterno',
        'Flag_Activo',
    ];

    public static function AdaptacionesActivas()
    {
        $Consulta = DB::table('Labadaptacioninvernadero')
            ->join('clientesYBreeder_labs as clien', 'clien.id', '=', 'Labadaptacioninvernadero.IdCliente')
            /*->join('URC_Variedades as varr', 'varr.id', '=', 'Labadaptacioninvernadero.IdVariedad')*/
            ->select(
                'clien.Nombre',
                'Labadaptacioninvernadero.CodAdaptacion'
            )
            ->where('Labadaptacioninvernadero.Flag_Activo', '=', 1)
            ->groupBy(['clien.Nombre',
                'Labadaptacioninvernadero.CodAdaptacion'])
            ->get();

        return $Consulta;

    }
}
