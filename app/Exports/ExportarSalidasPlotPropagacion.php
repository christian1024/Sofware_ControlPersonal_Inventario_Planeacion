<?php

namespace App\Exports;

use App\Model\GetEtiquetasRenewalProduncionModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportarSalidasPlotPropagacion implements FromCollection, WithHeadings
{
    use Exportable;

    /**
     * @inheritDoc
     */
    public function collection()
    {
        // TODO: Implement collection() method.
        $repor= GetEtiquetasRenewalProduncionModel::ConsultaDescargueSalidasAgrupado();
        return $repor;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Nombre Variedad',
            'Nombre Genero',
            'PlotID Nuevo',
            'Codigo',
            'Semana Cosecha',
            'Semana Salida',
            'Plantas'
        ];
    }
}
