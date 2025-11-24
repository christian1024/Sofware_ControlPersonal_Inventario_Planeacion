<?php

namespace App\Imports;


use App\Models\ClientesLab;
use App\Models\ImportProgramasSemanales;
use App\Models\TipoFasesLab;
use App\Models\Variedades;
use Maatwebsite\Excel\Concerns\{Importable, ToModel, WithHeadingRow};

class ImportarProgramasImport implements ToModel, WithHeadingRow
{
    use Importable;


    public function model(array $row)
    {
        //dd($row);

     /*   $Variedades = variedades::query()->select('Codigo')->where('Codigo', $row['codigovariedad'])->first();
        $cliente = ClientesLab::query()->select('Indicativo')->where('Indicativo', $row['cliente'])->first();
        $Fase = TipoFasesLab::query()->select('Codigo')->where('Codigo', $row['faseactual'])->first();


        if (empty($Variedades) || empty($cliente) || empty($Fase)) {
            return redirect(route('vistaProgramas'));
        } else {
            return new ImportProgramasSemanales([
                "CodigoVariedad" => $row['codigovariedad'],
                "FaseEntrada" => $row['faseactual'],
                "CantidadSolicitada" => $row['cantidad'],
                "SemanaDespacho" => $row['semanadespacho'],
                "cliente" => $row['cliente'],
            ]);
        }*/

        return new ImportProgramasSemanales([
            "CodigoVariedad" => $row['codigovariedad'],
            "FaseEntrada" => $row['faseactual'],
            "CantidadSolicitada" => $row['cantidad'],
            "SemanaDespacho" => $row['semanadespacho'],
            "cliente" => $row['cliente'],
        ]);


    }
}
