<?php

namespace App\Exports;

use App\Model\GetEtiquetasLabInventario;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteInventario implements FromCollection, WithHeadings
{
    use Exportable;

    /**
     * @inheritDoc
     */
    public function collection()
    {
        // TODO: Implement collection() method.
        $repor=GetEtiquetasLabInventario::ReporteInv();
        return $repor;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Tipo',
            'Codigo Variedad',
            'Nombre Variedad',
            'Nombre Genero',
            'Identificador',
            'Codigo Barras',
            'Fase Actual',
            'Contenedor',
            'Semana Entrada',
            'Edad',
            'Semana Ultimo Movimiento',
            'Semana Despacho',
            'Ubicacion Actual',
            'Plantas',
            'Nombre Cliente',
        ];
    }
}
