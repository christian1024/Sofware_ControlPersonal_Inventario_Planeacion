<?php

namespace App\Exports;

use App\Model\GetEtiquetasLabInventario;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteInventarioTotal implements FromCollection, WithHeadings
{
    use Exportable;

    /**
     * @inheritDoc
     */
    public function collection()
    {
        // TODO: Implement collection() method.
        $repor=GetEtiquetasLabInventario::ReporteInvTotal();
        return $repor;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Codigo Variedad',
            'Nombre Variedad',
            'Nombre Genero',
            'Codigo Barras',
            'Identificador',
            'Fase Actual',
            'Contenedor',
            'Semana Entrada',
            'Semana Ultimo Movimiento',
            'Semana Despacho',
            'Ubicacion Actual',
            'Plantas',
            'Nombre Cliente',
        ];
    }
}
