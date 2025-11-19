<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelIntroduccionesFuturas extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabIntroduciconesFuturas";
    protected $fillable = [
        'SemanaIntroduccion',
        'IdCliente',
        'IdVariedad',
        'IdGenero',
        'TipoIntroduccion',
        'Cantidad',
        'SemanaCreacion',
        'idusers',
    ];

    public static function ReporteIntroducionesFuturas()
    {
       $Introducionesfuturas = ModelIntroduccionesFuturas::query()
           ->select('SemanaIntroduccion','cl.Nombre','NombreGenero', 'Nombre_Variedad','TipoIntroduccion', 'Cantidad')
           ->join('URC_Generos as gn ','gn.id','=','LabIntroduciconesFuturas.IdGenero')
           ->join('URC_Variedades as var ','var.id','=','LabIntroduciconesFuturas.IdVariedad')
           ->join('clientesYBreeder_labs as cl ','cl.id','=','LabIntroduciconesFuturas.IdCliente')
           ->get();

        return $Introducionesfuturas;

    }
}
