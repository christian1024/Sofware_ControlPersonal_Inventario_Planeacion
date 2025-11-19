<?php

namespace App\Imports;

use App\Model\CargueEtiquetasPro;
use App\Model\ProdInformacionTecnicaVariedades;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportInformacionTecnicaVariedadesURC implements ToModel, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \App\Model\ProdInformacionTecnicaVariedades
     */

    public function model(array $row)
    {
        $existeCodi = ProdInformacionTecnicaVariedades::query()->where('Codigo_Integracion', '=', $row['codigo'])->first();
        if ($existeCodi) {
            ProdInformacionTecnicaVariedades::where('Codigo_Integracion', $row['codigo'])
                ->update([
                    'Porcentaje_Enraizamiento' => $row['porcentaje_enraizamiento'],
                    'TablaVPD' => $row['tablavpd'],
                    'MEDIO_Enraizamiento' => $row['medio_enraizamiento'],
                    'tipo_de_bandeja' => $row['tipo_de_bandeja'],
                    'Condiciones_crecimiento_Enraizamiento' => $row['condiciones_crecimiento_enraizamiento'],
                    'Hormonas_enraizamiento' => $row['hormonas_enraizamiento'],
                    'Horas_luz_enraizamiento' => $row['horas_luz_enraizamiento'],
                    'Semanas_Enraizamiento' => $row['semanas_enraizamiento'],
                    'Horas_luz_producción' => $row['horas_luz_produccion'],
                    'Sombra' => $row['sombra'],
                    'Búnker' => $row['bunker'],
                    'Bloque_siembra_Producción' => $row['bloque_siembra_produccion'],
                    'Medio_producción' => $row['medio_produccion'],
                    'Hormona' => $row['hormona'],
                    'Tratamientos_adicionales' => $row['tratamientos_adicionales'],
                    'Plantas_X_Canastilla' => $row['plantas_x_canastilla'],
                    'Conductividad' => $row['conductividad'],
                    'Primer_Pinch_Nudos' => $row['primer_pinch_nudos'],
                    'Segundo_Pinch_Nudos' => $row['segundo_pinch_nudos'],
                    'Factor_Prod' => $row['factor_prod'],
                    'Tipo_esqueje' => $row['tipo_esqueje'],
                    'Herramienta' => $row['herramienta'],
                    'TamanoMinCm' => $row['tamanomincm'],
                    'TamanoMaxCm' => $row['tamanomaxcm'],
                    'Delicado' => $row['delicado'],
                    'Hojas_Maduras_Min' => $row['hojas_maduras_min'],
                    'Hojas_Maduras_Max' => $row['hojas_maduras_max'],
                    'Long_Base_Min_Pata' => $row['long_base_min_pata'],
                    'Long_Base_Max_Pata' => $row['long_base_max_pata'],
                    'Diam_Base_Min' => $row['diam_base_min'],
                    'Diam_Base_Max' => $row['diam_base_max'],
                    'Nudos_Min' => $row['nudos_min'],
                    'Nudos_Max' => $row['nudos_max'],
                    'Observaciones_Cosecha' => $row['observaciones_cosecha'],
                    'Buffer_Produccion' => $row['buffer_produccion'],
                    'Vida_Util' => $row['vida_util'],
                    'Sem_adulta' => $row['sem_adulta'],
                    'Semanas_en_producción' => $row['semanas_en_produccion'],
                    'Juvenil_1' => $row['juvenil_1'],
                    'Juvenil_2' => $row['juvenil_2'],
                    'Juvenil_3' => $row['juvenil_3'],
                    'Factor_Juvenil_1' => $row['factor_juvenil_1'],
                    'Factor_Juvenil_2' => $row['factor_juvenil_2'],
                    'Factor_Juvenil_3' => $row['factor_juvenil_3'],
                    'Tamano_Esqueje' => $row['tamano_esqueje'],
                    'Cant_Esquejes_Bolsillo' => $row['cant_esquejes_bolsillo'],
                ]);
        }
        else{
            ProdInformacionTecnicaVariedades::query()->create([
                'Codigo_Integracion' => $row['codigo'],
                'Porcentaje_Enraizamiento' => $row['porcentaje_enraizamiento'],
                'TablaVPD' => $row['tablavpd'],
                'MEDIO_Enraizamiento' => $row['medio_enraizamiento'],
                'tipo_de_bandeja' => $row['tipo_de_bandeja'],
                'Condiciones_crecimiento_Enraizamiento' => $row['condiciones_crecimiento_enraizamiento'],
                'Hormonas_enraizamiento' => $row['hormonas_enraizamiento'],
                'Horas_luz_enraizamiento' => $row['horas_luz_enraizamiento'],
                'Semanas_Enraizamiento' => $row['semanas_enraizamiento'],
                'Horas_luz_producción' => $row['horas_luz_produccion'],
                'Sombra' => $row['sombra'],
                'Búnker' => $row['bunker'],
                'Bloque_siembra_Producción' => $row['bloque_siembra_produccion'],
                'Medio_producción' => $row['medio_produccion'],
                'Hormona' => $row['hormona'],
                'Tratamientos_adicionales' => $row['tratamientos_adicionales'],
                'Plantas_X_Canastilla' => $row['plantas_x_canastilla'],
                'Conductividad' => $row['conductividad'],
                'Primer_Pinch_Nudos' => $row['primer_pinch_nudos'],
                'Segundo_Pinch_Nudos' => $row['segundo_pinch_nudos'],
                'Factor_Prod' => $row['factor_prod'],
                'Tipo_esqueje' => $row['tipo_esqueje'],
                'Herramienta' => $row['herramienta'],
                'TamanoMinCm' => $row['tamanomincm'],
                'TamanoMaxCm' => $row['tamanomaxcm'],
                'Delicado' => $row['delicado'],
                'Hojas_Maduras_Min' => $row['hojas_maduras_min'],
                'Hojas_Maduras_Max' => $row['hojas_maduras_max'],
                'Long_Base_Min_Pata' => $row['long_base_min_pata'],
                'Long_Base_Max_Pata' => $row['long_base_max_pata'],
                'Diam_Base_Min' => $row['diam_base_min'],
                'Diam_Base_Max' => $row['diam_base_max'],
                'Nudos_Min' => $row['nudos_min'],
                'Nudos_Max' => $row['nudos_max'],
                'Observaciones_Cosecha' => $row['observaciones_cosecha'],
                'Buffer_Produccion' => $row['buffer_produccion'],
                'Vida_Util' => $row['vida_util'],
                'Sem_adulta' => $row['sem_adulta'],
                'Semanas_en_producción' => $row['semanas_en_produccion'],
                'Juvenil_1' => $row['juvenil_1'],
                'Juvenil_2' => $row['juvenil_2'],
                'Juvenil_3' => $row['juvenil_3'],
                'Factor_Juvenil_1' => $row['factor_juvenil_1'],
                'Factor_Juvenil_2' => $row['factor_juvenil_2'],
                'Factor_Juvenil_3' => $row['factor_juvenil_3'],
                'Tamano_Esqueje' => $row['tamano_esqueje'],
                'Cant_Esquejes_Bolsillo' => $row['cant_esquejes_bolsillo'],
                'Flag_Activo' => 1,
            ]);
        }
    }
}
