<?php

namespace App\Exports;

use App\Http\Controllers\PropagacionController;
use App\Model\GetEtiquetasRenewalProduncionModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportReportePropagacionDescriminado implements FromCollection, WithHeadings
{
    use Exportable;

    /**
     * @inheritDoc
     */
    public function collection()
    {
        // TODO: Implement collection() method.
        $repor= GetEtiquetasRenewalProduncionModel::ConsultaDescargueInventarioDiscriminado();
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
            'PlotID Origen',
            'Codigo Integracion',
            'Codigo Barras',
            'Ubicacion',
            'Semana Despacho',
            'Plantas',
            'Semana Siembra Propagacion',
            'Nombre Patinador',
            'Nombre Operario',
        ];
    }
}
