<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CargueInventario extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "cargue_inventario";
    protected $fillable = [
        'CodigoVariedad',
        'Identificador',
        'Breeder',
        'FaseActual',
        'SemanaUltimoMovimiento',
        'SemanaIngreso',
        'Cantidad',
        'id_Cuarto',
        'id_Estante',
        'id_Nivel',
        'id_Frasco',
        'SemanaDespacho',
        'NumeroRadicado',
        'cliente',
        'created_at'
    ];

    public static function inventario()
    {
        $inventario = DB::table('cargue_inventario as inv')
            ->select(
                'var.Codigo',
                'gen.NombreGenero',
                'var.Nombre_Variedad',
                'inv.Identificador',
                'bre.NombreBreeder',
                'fas.NombreFase',
                'inv.SemanaUltimoMovimiento',
                'inv.SemanaIngreso',
                'inv.Cantidad',
                'lc.N_Cuarto',
                'est.N_Estante',
                'ln.N_Nivel'
            )
            ->leftJoin('urc_variedades as var', 'inv.CodigoVariedad', '=', 'var.Codigo')
            ->leftJoin('URC_Especies as esp', 'esp.id', '=', 'var.ID_Especie')
            ->leftJoin('URC_Generos as gen', 'gen.id', '=', 'esp.Id_Genero')
            ->leftJoin('breeders_labs as bre', 'inv.Breeder', '=', 'bre.InicalesBreeder')
            ->leftJoin('tipo_fases_labs as fas', 'inv.FaseActual', '=', 'fas.id')
            ->leftJoin('lab_cuartos as lc', 'inv.id_Cuarto', '=', 'lc.id')
            ->leftJoin('lab_estantes as est', 'inv.id_Estante', '=', 'est.id')
            ->leftJoin('lab_nivels as ln', 'inv.id_Nivel', '=', 'ln.id')
            ->get();

        return $inventario;
    }
}
