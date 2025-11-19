<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Especies extends Model
{
    //const created_at = null;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URC_Especies";
    protected $fillable = [
        'id',
        'NombreEspecie',
        'CodigoIntegracionEspecie',
        'Id_Genero',
        'Flag_Activo'
    ];

    public static function CargaTablaEspeciesActivas()
    {
        $EspeciesActivas = DB::table('URC_Especies')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.id_Genero')
            ->select([
                'URC_Especies.id',
                'URC_Especies.NombreEspecie',
                'URC_Generos.NombreGenero',
                'URC_Especies.CodigoIntegracionEspecie',
            ])
            ->where('URC_Especies.Flag_Activo', '=', 1)
            ->orderBy('URC_Especies.NombreEspecie', 'ASC')
            ->get();

        /*dd($EspeciesActivas);*/
        return $EspeciesActivas;
    }

    public static function CargaTablaEspeciesTotal()
    {
        $EspeciesActivas = DB::table('URC_Especies')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.id_Genero')
            ->select([
                'URC_Especies.id',
                'URC_Especies.NombreEspecie',
                'URC_Generos.NombreGenero',
                'URC_Especies.CodigoIntegracionEspecie',
                'URC_Especies.Flag_Activo',
            ])
            ->orderBy('URC_Especies.NombreEspecie', 'ASC')
            ->get();

        /*dd($EspeciesActivas);*/
        return $EspeciesActivas;
    }

}
