<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Variedades extends Model
{
    //const created_at = null;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URC_Variedades";
    protected $fillable = [
        'id',
        'Codigo',
        'Nombre_Variedad',
        'ID_Especie',
        'Flag_Activo'
    ];

    public static function listTableVariety()
    {
        $VariedadesActivas = DB::table('URC_Variedades')
            ->join('URC_Especies', 'URC_Variedades.ID_Especie', '=', 'URC_Especies.id')
            ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
            ->select([
                'URC_Variedades.id',
                'URC_Variedades.Flag_Activo',
                'URC_Especies.id as idEspecie',
                'URC_Generos.id as idGenero',
                'URC_Variedades.Codigo',
                'URC_Variedades.Nombre_Variedad',
                'URC_Especies.NombreEspecie',
                'URC_Generos.NombreGenero'
            ])
            ->get();

        return $VariedadesActivas;
    }

        public static function CabDeInfoVariedad($id)
    {
        $DetCabVariedad = DB::table('lab_infotecnica_variedades')
            ->join('URC_Variedades', 'lab_infotecnica_variedades.id_Variedad', '=', 'URC_Variedades.id')
            ->select(
                'URC_Variedades.Codigo',
                'URC_Variedades.Nombre_Variedad'
            )
            ->where('lab_infotecnica_variedades.id_Variedad', '=', base64_decode($id))->first();

        return $DetCabVariedad;
    }

    public static function CargaDetallesTableInfoVari($dato)
    {
        $Infotecnica = DB::table('lab_infotecnica_variedades')
            ->join('URC_Variedades', 'lab_infotecnica_variedades.id_Variedad', '=', 'URC_Variedades.id')
            ->join('URC_Especies', 'URC_Variedades.ID_Especie', '=', 'URC_Especies.id')
            ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
            ->join('tipo_fases_labs', 'tipo_fases_labs.id', '=', 'lab_infotecnica_variedades.id_fase')
            ->select(
                'URC_Variedades.id',
                'URC_Variedades.Codigo',
                'URC_Variedades.Nombre_Variedad',
                'URC_Especies.NombreEspecie',
                'URC_Generos.NombreGenero',
                'tipo_fases_labs.NombreFase',
                'lab_infotecnica_variedades.id_fase',
                'lab_infotecnica_variedades.CoeficienteMultiplicacion',
                'lab_infotecnica_variedades.PorcentajePerdida',
                'lab_infotecnica_variedades.PorcentajePerdidaFase',
                'lab_infotecnica_variedades.SemanasXFase'
            )
            ->where('lab_infotecnica_variedades.id_Variedad', '=', $dato)
            ->get();

        return $Infotecnica;

    }

    public static function CargueDetallesTableInfoTecFrascos($dato)
    {
        $InfotecFrascos = DB::table('lab_infotecica_tipos_frascos')
            ->join('URC_Variedades', 'lab_infotecica_tipos_frascos.id_Variedad', '=', 'URC_Variedades.id')
            ->join('URC_Especies', 'URC_Variedades.ID_Especie', '=', 'URC_Especies.id')
            ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
            ->join('tipo_fases_labs', 'tipo_fases_labs.id', '=', 'lab_infotecica_tipos_frascos.id_fase')
            ->join('tipo_Contenedores_labs', 'tipo_Contenedores_labs.id', '=', 'lab_infotecica_tipos_frascos.id_tipofrasco')
            ->select(
                'URC_Variedades.id',
                'URC_Variedades.Codigo',
                'URC_Variedades.Nombre_Variedad',
                'URC_Especies.NombreEspecie',
                'URC_Generos.NombreGenero',
                'lab_infotecica_tipos_frascos.id_fase',
                'tipo_fases_labs.NombreFase',
                'tipo_Contenedores_labs.TipoContenedor',
                'lab_infotecica_tipos_frascos.Cantidad'
            )
            ->where('lab_infotecica_tipos_frascos.id_Variedad', '=', $dato)
            ->get();

        return $InfotecFrascos;
    }

    public static function VariedadesExistenteslab()
    {
        $VariedadesActivas = DB::table('URC_Variedades')
            ->join('URC_Especies', 'URC_Variedades.ID_Especie', '=', 'URC_Especies.id')
            ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
            ->join('GetEtiquetasLabInventario as gt', 'gt.ID_Variedad', '=', 'URC_Variedades.id')
            ->select([
                'URC_Variedades.id',
                'URC_Generos.id as idGenero',
                'URC_Variedades.Codigo',
                'URC_Variedades.Nombre_Variedad',
                'URC_Generos.NombreGenero'
            ])
            ->where('URC_Variedades.Flag_Activo',1)
            ->groupBy([
                'URC_Variedades.id',
                'URC_Generos.id',
                'URC_Variedades.Codigo',
                'URC_Variedades.Nombre_Variedad',
                'URC_Generos.NombreGenero',
                'gt.ID_Variedad'
            ])
            ->get();
        return $VariedadesActivas;
    }

    /*Edwin*/

    public static function CargaNombreVariedadInfoTecProd($dato)
    {
        $NombreVariedad = DB::table('URC_Variedades')
            ->join('URC_Especies', 'URC_Variedades.ID_Especie', '=', 'URC_Especies.id')
            ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
            ->select(
                'URC_Variedades.Nombre_Variedad',
                'URC_Generos.NombreGenero'
            )
            ->where('URC_Variedades.Codigo', '=', $dato)
            ->get();

        return $NombreVariedad;

    }
}
