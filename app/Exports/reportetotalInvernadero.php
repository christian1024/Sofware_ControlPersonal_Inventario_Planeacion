<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Model\GetEtiquetasLabInventario;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class reportetotalInvernadero implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        $repor=GetEtiquetasLabInventario::ReporteInvTotalActivoInvernadero();
        return $repor;
    }

    public function headings(): array
    {
        return [
            'Tipo',
            'Codigo Variedad',
            'Nombre Variedad',
            'Nombre Genero',
            'Codigo Barras',
            'Identificador',
            'Fase Actual',
            'Contenedor',
            'Semana Entrada',
            'Semana Despacho',
            'Plantas',
            'Ubicacion Actual',
            'Nombre Cliente',
        ];
    }
}
