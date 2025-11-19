<?php

namespace App\Http\Controllers;

use App\Exports\ExportPlaneacionProgramas;
use App\Model\CausalesCancelacionPlaneacion;
use App\Model\ClientesLab;
use App\Model\GetEtiquetasLabInventario;
use App\Model\labCabezaPedidos;
use App\Model\labdetallesPedidos;
use App\Model\LabInfotecnicaVariedades;
use App\Model\ModelAnoSemana;
use App\Model\PlaneacionSemanalPorPedido;
use App\Model\Variedades;
use Carbon\Carbon;
use FontLib\Table\Type\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\DocBlock\Description;
use Swift_SwiftException;

class OrdenesPedidoLaboratorioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function OrdenesPedidosLaboratorio()
    {
        $ClientesAct = ClientesLab::clientesActivos();
        $Variedades = Variedades::VariedadesExistenteslab();
        $Pedidos = labCabezaPedidos::PedidosActivos();
        $radicadofinalAsignar = labCabezaPedidos::query()->max('NumeroPedido');
        $radicadofinalAsignar = $radicadofinalAsignar + 1;

        $detallescanceladossinasignara = labdetallesPedidos::query()
            ->select([
                'cab.NumeroPedido',
                'labDetallesPedidosPlaneacion.*',
                'vari.Codigo',
                'Indicativo'
            ])
            ->join('labCabezaPedidos as cab', 'cab.id', '=', 'labDetallesPedidosPlaneacion.id_CabezaPedido')
            ->join('URC_Variedades as vari', 'vari.id', '=', 'labDetallesPedidosPlaneacion.id_Variedad')
            ->join('clientesYBreeder_labs as cl', 'cl.id', '=', 'cab.id_Cliente')
            ->where('flag_ActivoPlaneacion', 1)
            ->where('CancelacionEjecucion', 1)
            ->whereNull('Flag_ActivoReplanteado')
            ->get();

        //dd($detallescanceladossinasignara);

        return view('Ventas.OrdenesPedidoLaboratorio', compact('ClientesAct', 'Variedades', 'Pedidos', 'radicadofinalAsignar', 'detallescanceladossinasignara'));
    }

    public function NewPedidoSolicitado(Request $request)
    {
        //dd($request->all());
        $array = $request['array'];


        $radicadoCancelado = $request['dataform']['RadicadoCancelado'];
        //dd($request->all());

        if ($radicadoCancelado === '' || $radicadoCancelado === null) {

            if ($array > 0) {
                $semana = $request['dataform']['Semana'];//capturo la fecha como viene es 2019-W31
                if (is_Null($semana)) {
                    $SemanaEntrega = 'N/A';
                } else {
                    $semanaP = explode('-W', $semana);//elimino el -Wy me rea un arreglo de dos [0],[1]
                    $dato1 = $semanaP[0];//Guardo arreglo 0 en una varieble
                    $dato2 = $semanaP[1];//Guardo arreglo 1 en una varieble
                    $SemanaEntrega = $dato1 . '' . $dato2;//Junto arreglos en una variable que guardo en base de datos
                }
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
//$SemanaEjecucion->AnoYSemana


                //$SemanaActual = $yearAc . '' . $SemanaAc;
                $users = auth()->user()->id;

                $NumPedido = labCabezaPedidos::query()->pluck('NumeroPedido')->last();
                $NumPedido = $NumPedido + 1;

                $createCabeza = labCabezaPedidos::query()
                    ->create([
                        'id_Cliente' => $request['dataform']['id_cliente'],
                        'SemanaEntrega' => $SemanaEntrega,
                        'SemanaCreacion' => $SemanaEjecucion->AnoYSemana,
                        'NumeroPedido' => $NumPedido,
                        'id_UserCreacion' => $users,
                        'EstadoDocumento' => 'Solicitado',
                        'Observaciones' => $request['dataform']['Observaciones'],
                        'TipoPrograma' => $request['dataform']['TipoPrograma'],
                        'Flag_Activo' => 1,
                    ]);

                $ultimoCreado = $createCabeza->id;
                for ($i = 0; $i < count($array); $i++) {
                    $detalles = labdetallesPedidos::query()
                        ->create([
                            'id_Variedad' => $array[$i]['Variedad'],
                            'TipoEntrega' => $array[$i]['TEntrega'],
                            'CantidadInicial' => $array[$i]['Cantidad'],
                            'SemanaEntrega' => $array[$i]['Fecha'],
                            'TipoEntregaModificada' => $array[$i]['TEntrega'],
                            'CantidadInicialModificada' => $array[$i]['Cantidad'],
                            'SemanaEntregaModificada' => $array[$i]['Fecha'],
                            'id_CabezaPedido' => $ultimoCreado,
                            'Flag_Activo' => 1,
                        ]);
                }

                $detallesPedidostTable = labdetallesPedidos::query()
                    ->select([
                        'gen.NombreGenero',
                        'vari.Nombre_Variedad',
                        'vari.Codigo',
                        'labDetallesPedidosPlaneacion.CantidadInicialModificada',
                        'labDetallesPedidosPlaneacion.TipoEntregaModificada',
                        'labDetallesPedidosPlaneacion.SemanaEntregaModificada'
                    ])
                    ->join('URC_Variedades as vari', 'labDetallesPedidosPlaneacion.id_Variedad', '=', 'vari.id ')
                    ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                    ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                    ->where('id_CabezaPedido', $ultimoCreado)->get();

                $cabezaPedido = labCabezaPedidos::query()
                    ->select(['cli.Nombre',
                        'NumeroPedido',
                        'Observaciones'
                    ])
                    ->join('clientesYBreeder_labs as cli', 'labCabezaPedidos.id_Cliente', '=', 'cli.id')
                    ->where('labCabezaPedidos.id', $createCabeza->id)->first();

                $subj = 'Nuevo Pedido ' . $cabezaPedido->Nombre;
                Mail::send('Email.NewPedido', ['CabezaPedido' => $cabezaPedido, 'DetallePedido' => $detallesPedidostTable], function ($msg) use ($subj) {
                    $msg->subject($subj);
                    $msg->from('pedidos@darwinperennials.com', $subj);
                    $msg->to('mmunoz@darwinperennials.com');
                    $msg->to('ppatino@darwinperennials.com');
                    $msg->to('dgaviria@darwinperennials.com');

                });
                return response()->json([
                    'data' => 1,
                ]);
            } else {
                return response()->json([
                    'data' => 0,
                ]);
            }
        } else {
            if ($array > 0) {
                $semana = $request['dataform']['Semana'];//capturo la fecha como viene es 2019-W31
                if (is_Null($semana)) {
                    $SemanaEntrega = 'N/A';
                } else {
                    $semanaP = explode('-W', $semana);//elimino el -Wy me rea un arreglo de dos [0],[1]
                    $dato1 = $semanaP[0];//Guardo arreglo 0 en una varieble
                    $dato2 = $semanaP[1];//Guardo arreglo 1 en una varieble
                    $SemanaEntrega = $dato1 . '' . $dato2;//Junto arreglos en una variable que guardo en base de datos
                }

                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
//$SemanaEjecucion->AnoYSemana

                $users = auth()->user()->id;

                $NumPedido = labCabezaPedidos::query()->max('NumeroPedido');
                $NumPedido = $NumPedido + 1;

                $detalle = labdetallesPedidos::query()
                    ->select([
                        'cab.id as cab',
                        'NumeroPedido',
                        'labDetallesPedidosPlaneacion.id',
                        'cab.TipoPrograma'
                    ])
                    ->join('labCabezaPedidos as cab', 'cab.id', '=', 'labDetallesPedidosPlaneacion.id_CabezaPedido')
                    ->where('labDetallesPedidosPlaneacion.id', $radicadoCancelado)
                    ->first();
                //dd($detalle);

                $createCabeza = labCabezaPedidos::query()
                    ->create([
                        'id_Cliente' => $request['dataform']['id_cliente'],
                        'SemanaEntrega' => $SemanaEntrega,
                        'SemanaCreacion' => $SemanaEjecucion->AnoYSemana,
                        'NumeroPedido' => $NumPedido,
                        'id_UserCreacion' => $users,
                        'EstadoDocumento' => 'Solicitado',
                        'Observaciones' => 'cancelacion de referencia ' . $NumPedido . '-' . $detalle->NumeroPedido . '-' . $detalle->id . ' ' . $request['dataform']['Observaciones'],
                        'IdcabezaInicial' => $detalle->cab,
                        'TipoPrograma' => $detalle->TipoPrograma,
                        'Flag_Activo' => 1,
                    ]);

                $ultimoCreado = $createCabeza->id;
                for ($i = 0; $i < count($array); $i++) {
                    $detalles = labdetallesPedidos::query()
                        ->create([
                            'id_Variedad' => $array[$i]['Variedad'],
                            'TipoEntrega' => $array[$i]['TEntrega'],
                            'CantidadInicial' => $array[$i]['Cantidad'],
                            'SemanaEntrega' => $array[$i]['Fecha'],
                            'TipoEntregaModificada' => $array[$i]['TEntrega'],
                            'CantidadInicialModificada' => $array[$i]['Cantidad'],
                            'SemanaEntregaModificada' => $array[$i]['Fecha'],
                            'id_CabezaPedido' => $ultimoCreado,
                            'IdDetalleInicial' => $detalle->id,
                            'Flag_Activo' => 1,
                        ]);
                }
                $updateitem = labdetallesPedidos::query()
                    ->where('id', $radicadoCancelado)
                    ->update([
                        'Flag_ActivoReplanteado' => 1,
                    ]);
                $detallesPedidostTable = labdetallesPedidos::query()
                    ->select([
                        'gen.NombreGenero',
                        'vari.Nombre_Variedad',
                        'vari.Codigo',
                        'labDetallesPedidosPlaneacion.CantidadInicialModificada',
                        'labDetallesPedidosPlaneacion.TipoEntregaModificada',
                        'labDetallesPedidosPlaneacion.SemanaEntregaModificada'
                    ])
                    ->join('URC_Variedades as vari', 'labDetallesPedidosPlaneacion.id_Variedad', '=', 'vari.id ')
                    ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                    ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                    ->where('id_CabezaPedido', $ultimoCreado)->get();

                $cabezaPedido = labCabezaPedidos::query()
                    ->select(['cli.Nombre',
                        'NumeroPedido',
                        'Observaciones'
                    ])
                    ->join('clientesYBreeder_labs as cli', 'labCabezaPedidos.id_Cliente', '=', 'cli.id')
                    ->where('labCabezaPedidos.id', $createCabeza->id)->first();

                $subj = 'Nuevo Pedido ' . $cabezaPedido->Nombre;
                Mail::send('Email.OrdenPreconfirmado', ['CabezaPedido' => $cabezaPedido, 'DetallePedido' => $detallesPedidostTable], function ($msg) use ($subj) {
                    $msg->subject($subj);
                    $msg->from('pedidosLaboratorioDW@gmail.com', $subj);
                    $msg->to('mmunoz@darwinperennials.com');
                    $msg->to('ppatino@darwinperennials.com');
                    $msg->to('dgaviria@darwinperennials.com');
                });
                return response()->json([
                    'data' => 1,
                ]);
            } else {
                return response()->json([
                    'data' => 0,
                ]);
            }
        }
    }

    public function DetallesPedido($id)
    {
        //dd($id);
        $Variedades = Variedades::VariedadesExistenteslab();
        $detallePedidoc = labCabezaPedidos::DetallesPedidoSolicitado($id);
        return view('Ventas.DetallesOrdenPedidoSolicitado', compact('detallePedidoc', 'Variedades'));
    }

    static function caracteristicas($Numpedido, $idVari)
    {
        $Pedidos = labCabezaPedidos::DetallesCaracteristicas($Numpedido, $idVari);
        return $Pedidos;
    }

    static function ProgramasPorvariedad($idVari)
    {
        $programas = labCabezaPedidos::ProgramasPorVariedad($idVari);
        return $programas;
    }

    public function VistaDetallasProgramasPlaneados(Request $request)
    {
        //dd($request->all());
        $programasFormados = labdetallesPedidos::query()
            ->select([
                'NumeroPedido',
                'CantidadInicialModificada',
                'SemanaPlaneacionDespacho'
            ])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'labDetallesPedidosPlaneacion.id_Variedad')
            ->join('labCabezaPedidos', 'labCabezaPedidos.id', '=', 'labDetallesPedidosPlaneacion.id_CabezaPedido')
            ->where('vari.id', $request->get('data'))
            ->where('labDetallesPedidosPlaneacion.Flag_ActivoPlaneacion', 1)
            ->where('labDetallesPedidosPlaneacion.Flag_Activo', 1)
            ->get();

        if (count($programasFormados) >= 1) {
            return response()->json([
                'data' => 1,
                'Programas' => $programasFormados,
            ]);
        } else
            return response()->json([
                'data' => 0,
            ]);
    }

    public function ViewPLaneacionVariedad(Request $request)
    {
        //dd($request->all());
        $array = $request->get('ProgramasH');
        $array = explode(',', $array);
        $datos = labCabezaPedidos::DetallesPLaneacion($request);

        $informacionTecnicaM = LabInfotecnicaVariedades::query()
            ->select(['CoeficienteMultiplicacion'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.Codigo', $request->get('IdVaridadH'))
            ->where('lab_infotecnica_variedades.id_fase', 6)
            ->first();

        $programasFormados = labdetallesPedidos::query()
            ->select([
                DB::raw('sum(CantidadPlaneacion) as CantPLantas'),
                DB::raw('count(labDetallesPedidosPlaneacion.id) as CantiRegistros'),
                'labDetallesPedidosPlaneacion.id_Variedad'
            ])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'labDetallesPedidosPlaneacion.id_Variedad')
            ->where('vari.Codigo', $request->get('IdVaridadH'))
            ->where('labDetallesPedidosPlaneacion.Flag_ActivoPlaneacion', 1)
            ->where('labDetallesPedidosPlaneacion.Flag_Activo', 1)
            ->groupBy('labDetallesPedidosPlaneacion.id_Variedad')
            ->first();

        //dd($programasFormados);


        $Germos = GetEtiquetasLabInventario::query()
            ->select([
                DB::raw('sum(CantContenedor) as CanGermo')
            ])
            ->join('LabLecturaEntradas as ent', 'ent.CodigoBarras', '=', 'BarCode')
            ->wherein('Indentificador', $array)
            ->where('ent.Flag_Activo', 1)
            ->where('ID_FaseActual', 4)
            ->first();

        $Stock = GetEtiquetasLabInventario::query()
            ->select([
                DB::raw('sum(CantContenedor) as cantStock')
            ])
            ->join('LabLecturaEntradas as ent', 'ent.CodigoBarras', '=', 'BarCode')
            ->wherein('Indentificador', $array)
            ->where('ent.Flag_Activo', 1)
            ->where('ID_FaseActual', 5)
            ->first();

        $GermosyStock = GetEtiquetasLabInventario::query()
            ->select([
                'Indentificador',
                'SemanUltimoMovimiento',
                'NombreFase',
                DB::raw('sum(CantContenedor) as CantPlantas')
            ])
            ->join('LabLecturaEntradas as ent', 'ent.CodigoBarras', '=', 'BarCode')
            ->join('tipo_fases_labs as fas', 'fas.id', '=', 'GetEtiquetasLabInventario.ID_FaseActual')
            ->wherein('Indentificador', $array)
            ->where('ent.Flag_Activo', 1)
            ->wherein('ID_FaseActual', [4, 5])
            ->groupBy('Indentificador', 'SemanUltimoMovimiento', 'NombreFase')
            ->get();

        return view('Ventas.PlaneacionVariedad', compact('datos', 'Germos', 'Stock', 'informacionTecnicaM', 'GermosyStock', 'programasFormados'));
    }

    public function CalcularPedido(Request $request)
    {

        //dd($request->all());
        $informacionTecnicaM = LabInfotecnicaVariedades::query()
            ->select(['SemanasXFase'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.Codigo', $request->get('CodigoVariedad'))
            ->where('lab_infotecnica_variedades.id_fase', 6)
            ->first();
        $informacionTecnicaE = LabInfotecnicaVariedades::query()
            ->select(['SemanasXFase', 'PorcentajePerdidaFase'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.Codigo', $request->get('CodigoVariedad'))
            ->where('lab_infotecnica_variedades.id_fase', 7)
            ->first();
        $informacionTecnicaA = LabInfotecnicaVariedades::query()
            ->select(['SemanasXFase', 'PorcentajePerdidaFase'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.Codigo', $request->get('CodigoVariedad'))
            ->where('lab_infotecnica_variedades.id_fase', 8)
            ->first();


        /*Año actual*/
        $date = Carbon::now();
        $year = $date->format('Y');
        /*un año adicional*/
        $date1 = Carbon::now();
        $endDate1 = $date1->addYear();
        $year1 = $date1->format('Y');
        /*dos años adicionales*/
        $date2 = Carbon::now();
        $endDate2 = $date2->addYears(2);
        $year2 = $endDate2->format('Y');
        /*tres años adicionales*/
        $date3 = Carbon::now();
        $endDate3 = $date3->addYears(3);
        $year3 = $endDate3->format('Y');
        /*cuatro años adicionales*/
        $date4 = Carbon::now();
        $endDate4 = $date4->addYears(4);
        $year4 = $endDate4->format('Y');

        $weekFinal = Carbon::parse('29-12-' . $year)->week();
        $weekFinal1 = Carbon::parse('29-12-' . $year1)->week();
        $weekFinal2 = Carbon::parse('29-12-' . $year2)->week();
        $weekFinal3 = Carbon::parse('29-12-' . $year3)->week();
        $weekFinal4 = Carbon::parse('29-12-' . $year4)->week();

        $SemanaInicialCalculo = $request->get('Semana');
        $CantidadInicialCalculo = $request->get('Cantidad');
        $FactorMultiplicacion = $request->get('FactoMul');
        $CantidadSolicitada = $request->get('CantidadSolicitada');
        $semanaIC = explode('-W', $SemanaInicialCalculo);
        $yearActual = $semanaIC[0];
        $weekPlaning = $semanaIC[1];
        $weekPlaning = $weekPlaning + 1;
        $vecesCiclo = 0;
        $CantidadSolicitadaEnraizamiento = $CantidadSolicitada * $informacionTecnicaE->PorcentajePerdidaFase;//asegurar enraizamiento
        $CantidadSolicitadaAdaptada = $CantidadSolicitada * $informacionTecnicaA->PorcentajePerdidaFase;//asegurar Adaptación*/
        $resul = $CantidadInicialCalculo;

        if (intval($request->get('germo') > 0)) {
            //dd('germo');
            $vecesCiclo = 1;
            //dd($vecesCiclo);
            for ($i = 0; $resul < $CantidadSolicitadaEnraizamiento; $i++) {
                $array = [ceil($resul)];
                $resul = $resul * $FactorMultiplicacion;
                $vecesCiclo++;
            }
        } else {
            //dd('stock');
            for ($i = 0; $resul < $CantidadSolicitadaEnraizamiento; $i++) {
                $array = [ceil($resul)];
                $resul = $resul * $FactorMultiplicacion;
                $vecesCiclo++;
            }
        }

        $CantidadSemanasMultiplicacion = ($vecesCiclo - 1) * $informacionTecnicaM->SemanasXFase;
        $sumaProgramaMultiplicacion = $CantidadSemanasMultiplicacion + $weekPlaning;
        $sumaProgramaEnraizado = $sumaProgramaMultiplicacion + $informacionTecnicaE->SemanasXFase;
        $sumaProgramaAdaptacion = $sumaProgramaEnraizado + $informacionTecnicaE->SemanasXFase;
        $sumaProgramaEnraizamientoEntrega = $sumaProgramaEnraizado + $informacionTecnicaE->SemanasXFase;
        $sumaProgramaAdaptacionEntrega = $sumaProgramaAdaptacion + $informacionTecnicaA->SemanasXFase;


        if ($yearActual === $year) {
            if ($sumaProgramaMultiplicacion <= $weekFinal && $yearActual === $year) {
                $weekFinalMultiplicacion = $year . '' . $sumaProgramaMultiplicacion;
            } else {
                $TotalrestaSemanasM = $sumaProgramaMultiplicacion - $weekFinal1 - 1;
                if ($TotalrestaSemanasM <= $weekFinal1) {
                    $weekFinalMultiplicacion = $year1 . '' . $TotalrestaSemanasM;
                } else {
                    $TotalrestaSemanasM = $TotalrestaSemanasM - $weekFinal1;
                    if ($TotalrestaSemanasM <= $weekFinal2) {
                        $weekFinalMultiplicacion = $year2 . '' . $TotalrestaSemanasM;
                    } else {
                        $TotalrestaSemanasM = $TotalrestaSemanasM - $weekFinal2;
                        if ($TotalrestaSemanasM <= $weekFinal3) {
                            $weekFinalMultiplicacion = $year3 . '' . $TotalrestaSemanasM;
                        } else {
                            $TotalrestaSemanasM = $TotalrestaSemanasM - $weekFinal3;
                            if ($TotalrestaSemanasM <= $weekFinal4) {
                                $weekFinalMultiplicacion = $year4 . '' . $TotalrestaSemanasM;
                            } else {
                                dd('pailas mucho tiempo');
                            }
                        }
                    }
                }
            }

            //dd($weekFinalMultiplicacion);
            if ($sumaProgramaEnraizado <= $weekFinal && $yearActual === $year) {
                $weekFinalEnraizamiento = $year . '' . $sumaProgramaEnraizado;
            } else {
                $TotalrestaSemanasE = $sumaProgramaEnraizado - $weekFinal1 - 1;
                if ($TotalrestaSemanasE <= $weekFinal1) {
                    $weekFinalEnraizamiento = $year1 . '' . $TotalrestaSemanasE;
                } else {
                    $TotalrestaSemanasE = $TotalrestaSemanasE - $weekFinal1;
                    if ($TotalrestaSemanasE <= $weekFinal2) {
                        $weekFinalEnraizamiento = $year2 . '' . $TotalrestaSemanasE;
                    } else {
                        $TotalrestaSemanasE = $TotalrestaSemanasE - $weekFinal2;
                        //echo 'resta tres' . $TotalrestaSemanasEC;
                        if ($TotalrestaSemanasE <= $weekFinal3) {
                            $weekFinalEnraizamiento = $year3 . '' . $TotalrestaSemanasE;
                        } else {
                            $TotalrestaSemanasE = $TotalrestaSemanasE - $weekFinal3;
                            if ($TotalrestaSemanasE <= $weekFinal4) {
                                $weekFinalEnraizamiento = $year4 . '' . $TotalrestaSemanasE;
                            } else {
                                dd('pailas mucho tiempo');
                            }
                        }
                    }
                }
            }

            if ($sumaProgramaAdaptacion <= $weekFinal && $yearActual === $year) {
                $weekFinalAdaptacion = $year . '' . $sumaProgramaAdaptacion;
            } else {
                $TotalrestaSemanasA = $sumaProgramaAdaptacion - $weekFinal1 - 1;
                if ($TotalrestaSemanasA <= $weekFinal1) {
                    $weekFinalAdaptacion = $year1 . '' . $TotalrestaSemanasA;
                } else {
                    $TotalrestaSemanasA = $TotalrestaSemanasA - $weekFinal1;
                    if ($TotalrestaSemanasA <= $weekFinal2) {
                        $weekFinalAdaptacion = $year2 . '' . $TotalrestaSemanasA;
                    } else {
                        $TotalrestaSemanasA = $TotalrestaSemanasA - $weekFinal2;
                        //echo 'resta tres' . $TotalrestaSemanasAC;
                        if ($TotalrestaSemanasA <= $weekFinal3) {
                            $weekFinalAdaptacion = $year3 . '' . $TotalrestaSemanasA;
                        } else {
                            $TotalrestaSemanasA = $TotalrestaSemanasA - $weekFinal3;
                            if ($TotalrestaSemanasA <= $weekFinal4) {
                                $weekFinalAdaptacion = $year4 . '' . $TotalrestaSemanasA;
                            } else {
                                dd('pailas mucho tiempo');
                            }
                        }
                    }
                }
            }
            /*DESDE AQUI*/
            if ($sumaProgramaEnraizamientoEntrega <= $weekFinal && $yearActual === $year) {
                $weekFinalaa = $year . '' . $sumaProgramaEnraizamientoEntrega;
                //dd($weekFinalMultiplicacion);
            } else {
                $TotalrestaSemanasB = $sumaProgramaEnraizamientoEntrega - $weekFinal1 - 1;
                if ($TotalrestaSemanasB <= $weekFinal1) {
                    $weekFinalaa = $year1 . '' . $TotalrestaSemanasB;
                } else {
                    $TotalrestaSemanasB = $TotalrestaSemanasB - $weekFinal1;
                    if ($TotalrestaSemanasB <= $weekFinal2) {
                        $weekFinalaa = $year2 . '' . $TotalrestaSemanasB;
                    } else {
                        $TotalrestaSemanasB = $TotalrestaSemanasB - $weekFinal2;
                        //echo 'resta tres' . $TotalrestaSemanasBC;
                        if ($TotalrestaSemanasB <= $weekFinal3) {
                            $weekFinalaa = $year3 . '' . $TotalrestaSemanasB;
                        } else {
                            $TotalrestaSemanasB = $TotalrestaSemanasB - $weekFinal3;
                            if ($TotalrestaSemanasB <= $weekFinal4) {
                                $weekFinalaa = $year4 . '' . $TotalrestaSemanasB;
                            } else {
                                dd('pailas mucho tiempo');
                            }
                        }
                    }
                }
            }

            if ($sumaProgramaAdaptacionEntrega <= $weekFinal && $yearActual === $year) {
                $weekFinalbb = $year . '' . $sumaProgramaAdaptacionEntrega;
            } else {
                $TotalrestaSemanasC = $sumaProgramaAdaptacionEntrega - $weekFinal1 - 1;
                if ($TotalrestaSemanasC <= $weekFinal1) {
                    $weekFinalbb = $year1 . '' . $TotalrestaSemanasC;
                } else {
                    $TotalrestaSemanasC = $TotalrestaSemanasC - $weekFinal1;
                    if ($TotalrestaSemanasC <= $weekFinal2) {
                        $weekFinalbb = $year2 . '' . $TotalrestaSemanasC;
                    } else {
                        $TotalrestaSemanasC = $TotalrestaSemanasC - $weekFinal2;
                        //echo 'resta tres' . $TotalrestaSemanasCC;
                        if ($TotalrestaSemanasC <= $weekFinal3) {
                            $weekFinalbb = $year3 . '' . $TotalrestaSemanasC;
                        } else {
                            $TotalrestaSemanasC = $TotalrestaSemanasC - $weekFinal3;
                            if ($TotalrestaSemanasC <= $weekFinal4) {
                                $weekFinalbb = $year4 . '' . $TotalrestaSemanasC;
                            } else {
                                dd('pailas mucho tiempo');
                            }
                        }
                    }
                }
            }

            if ($request->get('TipoEntrega') === 'Invitro') {
                $weekDespacho = $weekFinalaa;

            } else {
                $weekDespacho = $weekFinalbb;
            }
            $unoantes = $weekFinalMultiplicacion - 4;

            if (strlen($weekFinalMultiplicacion) === 5) {
                $Inicial = substr($weekFinalMultiplicacion, 0, 4);
                $ultimo = substr($weekFinalMultiplicacion, -1);
                $weekFinalMultiplicacion = $Inicial . '0' . $ultimo;
            }
            if (strlen($unoantes) === 5) {
                $Inicial = substr($unoantes, 0, 4);
                $ultimo = substr($unoantes, -1);
                $unoantes = $Inicial . '0' . $ultimo;
            }
            if (strlen($weekFinalEnraizamiento) === 5) {
                $Inicial = substr($weekFinalEnraizamiento, 0, 4);
                $ultimo = substr($weekFinalEnraizamiento, -1);
                $weekFinalEnraizamiento = $Inicial . '0' . $ultimo;
            }
            if (strlen($weekFinalAdaptacion) === 5) {
                $Inicial = substr($weekFinalAdaptacion, 0, 4);
                $ultimo = substr($weekFinalAdaptacion, -1);
                $weekFinalAdaptacion = $Inicial . '0' . $ultimo;
            }
            if (strlen($weekDespacho) === 5) {
                $Inicial = substr($weekDespacho, 0, 4);
                $ultimo = substr($weekDespacho, -1);
                $weekDespacho = $Inicial . '0' . $ultimo;
            }


            return response()->json([
                'SemanaMultiplicacion' => $weekFinalMultiplicacion,
                'SemanaMultiplicacionAntes' => $unoantes,
                'CantidadPlantasMultiplicacion' => $array,
                'CantidadPlantasMultiplicacionM' => ceil($resul),
                'SemanaEnraizamiento' => $weekFinalEnraizamiento,
                'PlanttasEnreiazar' => ceil($CantidadSolicitadaEnraizamiento),
                'SemanaAdaptacion' => $weekFinalAdaptacion,
                'CantidadAdaptacion' => ceil($CantidadSolicitadaAdaptada),
                'SEmanaDespacho' => $weekDespacho,
                'data' => 1,
            ]);
        } else {
            if ($sumaProgramaMultiplicacion <= $weekFinal && $yearActual === $year) {
                $weekFinalMultiplicacion = $year . '' . $sumaProgramaMultiplicacion;
            } else {
                $TotalrestaSemanasM = $sumaProgramaMultiplicacion + 1 - $weekPlaning;
                if ($TotalrestaSemanasM <= $weekFinal1) {
                    $weekFinalMultiplicacion = $year1 . '' . $TotalrestaSemanasM;
                } else {
                    $TotalrestaSemanasM = $TotalrestaSemanasM - $weekFinal1;
                    if ($TotalrestaSemanasM <= $weekFinal2) {
                        $weekFinalMultiplicacion = $year2 . '' . $TotalrestaSemanasM;
                    } else {
                        $TotalrestaSemanasM = $TotalrestaSemanasM - $weekFinal2;
                        //echo 'resta tres' . $TotalrestaSemanasMC;
                        if ($TotalrestaSemanasM <= $weekFinal3) {
                            $weekFinalMultiplicacion = $year3 . '' . $TotalrestaSemanasM;
                        } else {
                            $TotalrestaSemanasM = $TotalrestaSemanasM - $weekFinal3;
                            if ($TotalrestaSemanasM <= $weekFinal4) {
                                $weekFinalMultiplicacion = $year4 . '' . $TotalrestaSemanasM;
                            } else {
                                dd('pailas mucho tiempo');
                            }
                        }
                    }
                }
            }
            if ($sumaProgramaEnraizado <= $weekFinal && $yearActual === $year) {
                $weekFinalEnraizamiento = $year . '' . $sumaProgramaEnraizado;
            } else {
                $TotalrestaSemanasE = $sumaProgramaEnraizado + $weekPlaning - 1;
                if ($TotalrestaSemanasE <= $weekFinal1) {
                    $weekFinalEnraizamiento = $year1 . '' . $TotalrestaSemanasE;
                } else {
                    $TotalrestaSemanasE = $TotalrestaSemanasE - $weekFinal1;
                    if ($TotalrestaSemanasE <= $weekFinal2) {
                        $weekFinalEnraizamiento = $year2 . '' . $TotalrestaSemanasE;
                    } else {
                        $TotalrestaSemanasE = $TotalrestaSemanasE - $weekFinal2;
                        //echo 'resta tres' . $TotalrestaSemanasEC;
                        if ($TotalrestaSemanasE <= $weekFinal3) {
                            $weekFinalEnraizamiento = $year3 . '' . $TotalrestaSemanasE;
                        } else {
                            $TotalrestaSemanasE = $TotalrestaSemanasE - $weekFinal3;
                            if ($TotalrestaSemanasE <= $weekFinal4) {
                                $weekFinalEnraizamiento = $year4 . '' . $TotalrestaSemanasE;
                            } else {
                                dd('pailas mucho tiempo');
                            }
                        }
                    }
                }
            }

            if ($sumaProgramaAdaptacion <= $weekFinal && $yearActual === $year) {
                $weekFinalAdaptacion = $year . '' . $sumaProgramaAdaptacion;
            } else {
                $TotalrestaSemanasA = $sumaProgramaAdaptacion + $weekPlaning - 1;
                if ($TotalrestaSemanasA <= $weekFinal1) {
                    $weekFinalAdaptacion = $year1 . '' . $TotalrestaSemanasA;
                } else {
                    $TotalrestaSemanasA = $TotalrestaSemanasA - $weekFinal1;
                    if ($TotalrestaSemanasA <= $weekFinal2) {
                        $weekFinalAdaptacion = $year2 . '' . $TotalrestaSemanasA;
                    } else {
                        $TotalrestaSemanasA = $TotalrestaSemanasA - $weekFinal2;
                        if ($TotalrestaSemanasA <= $weekFinal3) {
                            $weekFinalAdaptacion = $year3 . '' . $TotalrestaSemanasA;
                        } else {
                            $TotalrestaSemanasA = $TotalrestaSemanasA - $weekFinal3;
                            if ($TotalrestaSemanasA <= $weekFinal4) {
                                $weekFinalAdaptacion = $year4 . '' . $TotalrestaSemanasA;
                            } else {
                                dd('pailas mucho tiempo');
                            }
                        }
                    }
                }
            }

            /*DESDE AQUI*/
            if ($sumaProgramaEnraizamientoEntrega <= $weekFinal && $yearActual === $year) {
                $weekFinalaa = $year . '' . $sumaProgramaEnraizamientoEntrega;
                //dd($weekFinalMultiplicacion);
            } else {
                $TotalrestaSemanasB = $sumaProgramaEnraizamientoEntrega + $weekPlaning - 1;
                if ($TotalrestaSemanasB <= $weekFinal1) {
                    $weekFinalaa = $year1 . '' . $TotalrestaSemanasB;
                } else {
                    $TotalrestaSemanasB = $TotalrestaSemanasB - $weekFinal1;
                    if ($TotalrestaSemanasB <= $weekFinal2) {
                        $weekFinalaa = $year2 . '' . $TotalrestaSemanasB;
                    } else {
                        $TotalrestaSemanasB = $TotalrestaSemanasB - $weekFinal2;
                        //echo 'resta tres' . $TotalrestaSemanasBC;
                        if ($TotalrestaSemanasB <= $weekFinal3) {
                            $weekFinalaa = $year3 . '' . $TotalrestaSemanasB;
                        } else {
                            $TotalrestaSemanasB = $TotalrestaSemanasB - $weekFinal3;
                            if ($TotalrestaSemanasB <= $weekFinal4) {
                                $weekFinalaa = $year4 . '' . $TotalrestaSemanasB;
                            } else {
                                dd('pailas mucho tiempo');
                            }
                        }
                    }
                }
            }

            if ($sumaProgramaAdaptacionEntrega <= $weekFinal && $yearActual === $year) {
                $weekFinalbb = $year . '' . $sumaProgramaAdaptacionEntrega;
                //dd($weekFinalMultiplicacion);
            } else {
                $TotalrestaSemanasC = $sumaProgramaAdaptacionEntrega + $weekPlaning - 1;
                if ($TotalrestaSemanasC <= $weekFinal1) {
                    $weekFinalbb = $year1 . '' . $TotalrestaSemanasC;
                } else {
                    $TotalrestaSemanasC = $TotalrestaSemanasC - $weekFinal1;
                    if ($TotalrestaSemanasC <= $weekFinal2) {
                        $weekFinalbb = $year2 . '' . $TotalrestaSemanasC;
                    } else {
                        $TotalrestaSemanasC = $TotalrestaSemanasC - $weekFinal2;
                        //echo 'resta tres' . $TotalrestaSemanasCC;
                        if ($TotalrestaSemanasC <= $weekFinal3) {
                            $weekFinalbb = $year3 . '' . $TotalrestaSemanasC;
                        } else {
                            $TotalrestaSemanasC = $TotalrestaSemanasC - $weekFinal3;
                            if ($TotalrestaSemanasC <= $weekFinal4) {
                                $weekFinalbb = $year4 . '' . $TotalrestaSemanasC;
                            } else {
                                dd('pailas mucho tiempo');
                            }
                        }
                    }
                }
            }
            $unoantes = $weekFinalMultiplicacion - 4;
            if ($request->get('TipoEntrega') === 'Invitro') {
                $weekDespacho = $weekFinalaa;

            } else {
                $weekDespacho = $weekFinalbb;
            }
            //$weekDespacho = $weekFinalAdaptacion + $informacionTecnicaA->SemanasXFase;
            if (strlen($weekFinalMultiplicacion) === 5) {
                $Inicial = substr($weekFinalMultiplicacion, 0, 4);
                $ultimo = substr($weekFinalMultiplicacion, -1);
                $weekFinalMultiplicacion = $Inicial . '0' . $ultimo;
            }
            if (strlen($unoantes) === 5) {
                $Inicial = substr($unoantes, 0, 4);
                $ultimo = substr($unoantes, -1);
                $unoantes = $Inicial . '0' . $ultimo;
            }
            if (strlen($weekFinalEnraizamiento) === 5) {
                $Inicial = substr($weekFinalEnraizamiento, 0, 4);
                $ultimo = substr($weekFinalEnraizamiento, -1);
                $weekFinalEnraizamiento = $Inicial . '0' . $ultimo;
            }
            if (strlen($weekFinalAdaptacion) === 5) {
                $Inicial = substr($weekFinalAdaptacion, 0, 4);
                $ultimo = substr($weekFinalAdaptacion, -1);
                $weekFinalAdaptacion = $Inicial . '0' . $ultimo;
            }
            if (strlen($weekDespacho) === 5) {
                $Inicial = substr($weekDespacho, 0, 4);
                $ultimo = substr($weekDespacho, -1);
                $weekDespacho = $Inicial . '0' . $ultimo;
            }

            return response()->json([
                'SemanaMultiplicacion' => $weekFinalMultiplicacion,
                'SemanaMultiplicacionAntes' => $unoantes,
                'CantidadPlantasMultiplicacion' => $array,
                'CantidadPlantasMultiplicacionM' => ceil($resul),
                'SemanaEnraizamiento' => $weekFinalEnraizamiento,
                'PlanttasEnreiazar' => ceil($CantidadSolicitadaEnraizamiento),
                'SemanaAdaptacion' => $weekFinalAdaptacion,
                'CantidadAdaptacion' => ceil($CantidadSolicitadaAdaptada),
                'SEmanaDespacho' => $weekDespacho,
                'data' => 1,
            ]);
        }

    }

    public function GuardarCalculoPedido(Request $request)
    {
        //dd($request->all());
        //dd($request->get('CodCabeza'));
        if ($request->ajax()) {

            $id = encrypt($request->get('CodCabeza'));
            $contador = $request->get('contadorEn');

            $dateA = Carbon::now();
            $dateMasSema = $dateA->format('Y-m-d');
            $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();




            $informacionTecnicaM = LabInfotecnicaVariedades::query()
                ->select(['CoeficienteMultiplicacion', 'SemanasXFase', 'PorcentajePerdidaFase'])
                ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
                ->where('vari.Codigo', $request->get('CodigoVariedadd'))
                ->where('lab_infotecnica_variedades.id_fase', 6)
                ->first();

            $informacionTecnicaE = LabInfotecnicaVariedades::query()
                ->select(['SemanasXFase', 'PorcentajePerdidaFase'])
                ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
                ->where('vari.Codigo', $request->get('CodigoVariedadd'))
                ->where('lab_infotecnica_variedades.id_fase', 7)
                ->first();
            $informacionTecnicaA = LabInfotecnicaVariedades::query()
                ->select(['SemanasXFase', 'PorcentajePerdidaFase'])
                ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
                ->where('vari.Codigo', $request->get('CodigoVariedadd'))
                ->where('lab_infotecnica_variedades.id_fase', 8)
                ->first();
//dd($contador);
            for ($i = 1; $i <= $contador; $i++) {
                //dd($request->get('Programas'));
                $array = $request->get('ProgramasH-' . $i);
                // $array = explode(',', $array);

                $SemanaInicialCalculo = $request->get('SemanaInicio-' . $i);
                $semanaIC = explode('-W', $SemanaInicialCalculo);
                $yearActual = $semanaIC[0];
                $weekPlaning = $semanaIC[1];
                $semana = $yearActual . '' . $weekPlaning;

                //dd($array);
                if ($request->get('TipoEntrega-' . $i) === 'Invitro') {
                    $weekadaptado = 0;
                    $Cantaptado = 0;
                } else {
                    $weekadaptado = $request->get('SemanaAdaptacionH-' . $i);
                    $Cantaptado = $request->get('cantAdaptacionH-' . $i);
                }
                $update = labdetallesPedidos::query()
                    ->where('id', $request->get('idVariedad-' . $i))
                    ->update([
                        'SemanaRealizoPlaneacion' => $SemanaEjecucion->AnoYSemana,
                        'CantidadStock' => $request->get('stock'),
                        'CantidadGermo' => $request->get('Germo'),
                        'FactorInformacionTecnica' => $informacionTecnicaM->CoeficienteMultiplicacion,
                        'FactorPlaneacion' => $request->get('FactorMulEdit'),
                        'SemanaPlaneacion' => $semana,
                        'CantidadPlaneacion' => $request->get('CantidadInicia-' . $i),
                        'SemanaPlaneacionCicloantes' => $request->get('SemanaMultiplicacionUnoantesH-' . $i),
                        'CantidadPlaneacionCicloantes' => $request->get('CantPlantasMultiplicacionUnoAntesH-' . $i),
                        'SemanaPlaneacionCicloFinal' => $request->get('SemanaMultiplicacionUnoDespuesH-' . $i),
                        'CantidadPlaneacionCicloFinal' => $request->get('CantPlantasMultiplicacionUnoDespuesH-' . $i),
                        'SemanaPlaneacionEnraizamiento' => $request->get('SemanaEnraizamientoH-' . $i),
                        'CantidadPlaneacionEnraizamiento' => $request->get('CantEnreizarH-' . $i),
                        'SemanaPlaneacionAdaptado' => $weekadaptado,
                        'CantidadPlaneacionAdaptado' => $Cantaptado,
                        'SemanaPlaneacionDespacho' => $request->get('SemanaDespachoH-' . $i),
                        'SemanasXFaseMultiplicacion' => $informacionTecnicaM->SemanasXFase,
                        'SemanasXFaseEnra' => $informacionTecnicaE->SemanasXFase,
                        'PorcentajePerdidaFaseEnra' => $informacionTecnicaE->PorcentajePerdidaFase,
                        'SemanasXFaseAdap' => $informacionTecnicaA->SemanasXFase,
                        'PorcentajePerdidaFaseAdap' => $informacionTecnicaA->PorcentajePerdidaFase,
                        'Programas' => $array,
                        'Flag_ActivoPlaneacion' => 1,
                    ]);

                $update++;
            }


            $CambioEstado = labdetallesPedidos::query()
                ->where('id_CabezaPedido', $request->get('CodCabeza'))
                ->whereNull('Flag_ActivoPlaneacion')
                ->where('Flag_Activo', 1)
                ->count();

            //echo ->Flag_ActivoPlaneacion;
            //dd($CambioEstado);
            if ($CambioEstado === 0) {
                $cambioestadocabeza = labCabezaPedidos::query()
                    ->where('id', $request->get('CodCabeza'))
                    ->update([
                        'EstadoDocumento' => 'PreConfirmado',
                    ]);

                $detallesPedidostTable = labdetallesPedidos::query()
                    ->select([
                        'gen.NombreGenero',
                        'vari.Nombre_Variedad',
                        'vari.Codigo',
                        'labDetallesPedidosPlaneacion.TipoEntregaModificada',
                        'labDetallesPedidosPlaneacion.CantidadInicialModificada',
                        'labDetallesPedidosPlaneacion.SemanaPlaneacionDespacho'
                    ])
                    ->join('URC_Variedades as vari', 'labDetallesPedidosPlaneacion.id_Variedad', '=', 'vari.id ')
                    ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                    ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                    ->where('id_CabezaPedido', $request->get('CodCabeza'))
                    ->where('labDetallesPedidosPlaneacion.Flag_Activo', 1)
                    ->get();

                $cabezaPedido = labCabezaPedidos::query()
                    ->select(['cli.Nombre',
                        'NumeroPedido',
                        'Observaciones'
                    ])
                    ->join('clientesYBreeder_labs as cli', 'labCabezaPedidos.id_Cliente', '=', 'cli.id')
                    ->where('labCabezaPedidos.id', $request->get('CodCabeza'))->first();
                //dd($cabezaPedido);
                $subj = 'Planeación para el cliente ' . $cabezaPedido->Nombre;
                Mail::send('Email.PedidoPlaneado', ['CabezaPedido' => $cabezaPedido, 'DetallePedido' => $detallesPedidostTable], function ($msg) use ($subj) {
                    $msg->subject($subj);
                    $msg->from('pedidosLaboratorioDW@gmail.com', $subj);
                    $msg->to('dgaviria@darwinperennials.com');
                });
                //dd('enviado');
                return response()->json([
                    'ok' => 1,
                    'id' => $id
                ]);
            } else {
                return response()->json([
                    'ok' => 1,
                    'id' => $id
                ]);
            }
        } else {
            return response()->json([
                'ok' => 2,
            ]);
        }
    }

    public function ViewPedidoConfirmado($id)
    {
        //dd($id);
        $detallePedidoc = labCabezaPedidos::DetallesPedidoPreconfirmado($id);
        //dd($detallePedidoc);
        return view('Ventas.DetallesOrdenPedidoPreConfirmado', compact('detallePedidoc'));
    }

    public function NuevoitemPedido(Request $request)
    {
        $request->validate([
            'cabeza' => 'required',
            'IdVaridad' => 'required',
            'TipoEntrega' => 'required',
            'SemanaEntrega' => 'required',
            'cantidadInicial' => 'required',
        ]);

        $variedad = Variedades::query()
            ->select([
                'id'
            ])
            ->where('Codigo', $request->get('IdVaridad'))
            ->first();
        $SemanaInicialCalculo = $request->get('SemanaEntrega');
        $semanaIC = explode('-W', $SemanaInicialCalculo);
        $yearActual = $semanaIC[0];
        $weekPlaning = $semanaIC[1];
        $semana = $yearActual . '' . $weekPlaning;

        $detalles = labdetallesPedidos::query()
            ->create([
                'id_Variedad' => $variedad->id,
                'TipoEntrega' => $request->get('TipoEntrega'),
                'CantidadInicial' => $request->get('cantidadInicial'),
                'SemanaEntrega' => $semana,
                'TipoEntregaModificada' => $request->get('TipoEntrega'),
                'CantidadInicialModificada' => $request->get('cantidadInicial'),
                'SemanaEntregaModificada' => $semana,
                'id_CabezaPedido' => $request->get('cabeza'),
                'ObservacionnuevoItem' => 'Item Nuevo',
                'Flag_Activo' => 1,
            ]);

        $detallesPedidostTable = labdetallesPedidos::query()
            ->select([
                'gen.NombreGenero',
                'vari.Nombre_Variedad',
                'vari.Codigo',
                'labDetallesPedidosPlaneacion.CantidadInicialModificada',
                'labDetallesPedidosPlaneacion.TipoEntregaModificada',
                'labDetallesPedidosPlaneacion.SemanaEntregaModificada'
            ])
            ->join('URC_Variedades as vari', 'labDetallesPedidosPlaneacion.id_Variedad', '=', 'vari.id ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->where('labDetallesPedidosPlaneacion.id', $detalles->id)->get();

        $cabezaPedido = labCabezaPedidos::query()
            ->select(['cli.Nombre',
                'NumeroPedido',
                'Observaciones'
            ])
            ->join('clientesYBreeder_labs as cli', 'labCabezaPedidos.id_Cliente', '=', 'cli.id')
            ->where('labCabezaPedidos.id', $request->get('cabeza'))->first();
        //  dd($cabezaPedido);
        $subj = 'Nuevo item del pedido ' . $cabezaPedido->Nombre;
        Mail::send('Email.NuevoItemPedido', ['CabezaPedido' => $cabezaPedido, 'DetallePedido' => $detallesPedidostTable], function ($msg) use ($subj) {
            $msg->subject($subj);
            $msg->from('pedidosLaboratorioDW@gmail.com', $subj);
            $msg->to('mmunoz@darwinperennials.com');
            $msg->to('ppatino@darwinperennials.com');
            $msg->to('dgaviria@darwinperennials.com');
        });
        return redirect(route('OrdenPedidoDetalle', ['id' => encrypt($request->get('cabeza'))]));
    }

    public function deleteItem(Request $request)
    {
        //dd($request->all());
        $date = Carbon::now()->format('Y-d-m H:i:s');

        $request->validate([
            'cabeza' => 'required',
            'Detalle' => 'required',
            'CausalCancelarPedido' => 'required',
        ]);
        $update = labdetallesPedidos::query()
            ->where('id', $request->get('Detalle'))
            ->update([
                'Flag_Activo' => 0,
                'ObservacionCancelacion' => $request->get('CausalCancelarPedido'),
                'FechaCancelacion' => $date,
            ]);


        $totalDetalles = labdetallesPedidos::query()
            ->where('id_CabezaPedido', $request->get('cabeza'))
            ->count();

        $totalActivosYPlaneados = labdetallesPedidos::query()
            ->where('id_CabezaPedido', $request->get('cabeza'))
            ->where('Flag_Activo', 1)
            ->where('Flag_ActivoPlaneacion', 1)
            ->count();

        $totalInactivos = labdetallesPedidos::query()
            ->where('id_CabezaPedido', $request->get('cabeza'))
            ->where('Flag_Activo', 0)
            ->count();

        $totalRegistros = $totalActivosYPlaneados + $totalInactivos;

        $detallesPedidostTable = labdetallesPedidos::query()
            ->select([
                'gen.NombreGenero',
                'vari.Nombre_Variedad',
                'vari.Codigo',
                'labDetallesPedidosPlaneacion.CantidadInicialModificada',
                'labDetallesPedidosPlaneacion.TipoEntregaModificada',
                'labDetallesPedidosPlaneacion.SemanaEntregaModificada',
                'labDetallesPedidosPlaneacion.id',
                'labDetallesPedidosPlaneacion.ObservacionCancelacion'
            ])
            ->join('URC_Variedades as vari', 'labDetallesPedidosPlaneacion.id_Variedad', '=', 'vari.id ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->where('labDetallesPedidosPlaneacion.id', $request->get('Detalle'))->get();

        $cabezaPedido = labCabezaPedidos::query()
            ->select(['cli.Nombre',
                'NumeroPedido',
                'Observaciones'
            ])
            ->join('clientesYBreeder_labs as cli', 'labCabezaPedidos.id_Cliente', '=', 'cli.id')
            ->where('labCabezaPedidos.id', $request->get('cabeza'))
            ->first();

        $subj = 'Cancelacion Item Pedido ' . $cabezaPedido->Nombre;
        Mail::send('Email.CancelacionItemSinPlanear', ['CabezaPedido' => $cabezaPedido, 'DetallePedido' => $detallesPedidostTable], function ($msg) use ($subj) {
            $msg->subject($subj);
            $msg->from('pedidosLaboratorioDW@gmail.com', $subj);
            $msg->to('mmunoz@darwinperennials.com');
            $msg->to('ppatino@darwinperennials.com');
            $msg->to('dgaviria@darwinperennials.com');
        });

        if ($totalDetalles === $totalInactivos) {
            $cambioestadocabeza = labCabezaPedidos::query()
                ->where('id', $request->get('cabeza'))
                ->update([
                    'EstadoDocumento' => 'Cancelado',
                ]);
            return redirect(route('OrdenesPedidos'));
        } elseif ($totalRegistros === $totalDetalles) {
            $cambioestadocabeza = labCabezaPedidos::query()
                ->where('id', $request->get('cabeza'))
                ->update([
                    'EstadoDocumento' => 'PreConfirmado',
                ]);
            return redirect(route('OrdenesPedidos'));
        } else {

            return redirect(route('OrdenPedidoDetalle', ['id' => encrypt($request->get('cabeza'))]));
        }
    }

    public function updateItem(Request $request)
    {

        $request->validate([
            'cabeza' => 'required',
            'idCodigo' => 'required',
            'TipoEntregaUpdate' => 'required',
            'semanaEntregaUpdate' => 'required',
            'CantidadEntregaUpdate' => 'required',
        ]);

        $dateA = Carbon::now();
        $dateMasSema = $dateA->format('Y-m-d');
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
//$SemanaEjecucion->AnoYSemana


        $update = labdetallesPedidos::query()
            ->where('id', $request->get('idCodigo'))
            ->update([
                'TipoEntregaModificada' => $request->get('TipoEntregaUpdate'),
                'CantidadInicialModificada' => $request->get('CantidadEntregaUpdate'),
                'SemanaEntregaModificada' => $request->get('semanaEntregaUpdate'),
                'SemanaModificacion' => $SemanaEjecucion->AnoYSemana,
            ]);

        $detallesPedidostTable = labdetallesPedidos::query()
            ->select([
                'gen.NombreGenero',
                'vari.Nombre_Variedad',
                'vari.Codigo',
                'labDetallesPedidosPlaneacion.CantidadInicialModificada',
                'labDetallesPedidosPlaneacion.TipoEntregaModificada',
                'labDetallesPedidosPlaneacion.SemanaEntregaModificada'
            ])
            ->join('URC_Variedades as vari', 'labDetallesPedidosPlaneacion.id_Variedad', '=', 'vari.id ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->where('labDetallesPedidosPlaneacion.id', $request->get('idCodigo'))->get();

        $cabezaPedido = labCabezaPedidos::query()
            ->select(['cli.Nombre',
                'NumeroPedido',
                'Observaciones'
            ])
            ->join('clientesYBreeder_labs as cli', 'labCabezaPedidos.id_Cliente', '=', 'cli.id')
            ->where('labCabezaPedidos.id', $request->get('cabeza'))->first();
        //  dd($cabezaPedido);
        $subj = 'Modificacion item del pedido ' . $cabezaPedido->Nombre;
        Mail::send('Email.ModificacionItem', ['CabezaPedido' => $cabezaPedido, 'DetallePedido' => $detallesPedidostTable], function ($msg) use ($subj) {
            $msg->subject($subj);
            $msg->from('pedidosLaboratorioDW@gmail.com', $subj);
            $msg->to('mmunoz@darwinperennials.com');
            $msg->to('ppatino@darwinperennials.com');
            $msg->to('dgaviria@darwinperennials.com');
        });
        return redirect(route('OrdenPedidoDetalle', ['id' => encrypt($request->get('cabeza'))]));


    }

    public function ViewPedidoAceptado($id)
    {
        $detallePedidoc = labCabezaPedidos::DetallesPedidoCAceptado($id);
        $caulesCancelaciones = CausalesCancelacionPlaneacion::query()
            ->where('Flag_Activo', 1)
            ->get();
        return view('Ventas.DetallesPedidoAceptado', compact('detallePedidoc', 'caulesCancelaciones'));
    }

    /*YA CON UNA PLANEACION*/
    public function CancelacionItemPedidoPreConfirmado($id, $idCabeza)
    {
        //dd(decrypt($idCabeza));//10--8
        $date = Carbon::now()->format('Y-d-m H:i:s');

        $update = labdetallesPedidos::query()
            ->where('id', decrypt($id))
            ->update([
                'Flag_Activo' => 0,
                'FlagActivo_CancelacionPreConfirmado' => 1,
                'FechaPreConfirmacionCliente' => $date,
            ]);


        $totalDetalles = labdetallesPedidos::query()
            ->where('id_CabezaPedido', decrypt($idCabeza))
            ->count();


        $totalActivosPlaneadosyConfirmados = labdetallesPedidos::query()
            ->where('id_CabezaPedido', decrypt($idCabeza))
            ->where('Flag_Activo', 1)
            ->where('Flag_ActivoPlaneacion', 1)
            ->where('FlagActivo_EstadoPreConfirmacion', 1)
            ->count();

        $totalInactivos = labdetallesPedidos::query()
            ->where('id_CabezaPedido', decrypt($idCabeza))
            ->where('Flag_Activo', 0)
            ->count();

        $totalRegistros = $totalActivosPlaneadosyConfirmados + $totalInactivos;

        //dd($totalDetalles,$totalActivosPlaneadosyConfirmados,$totalInactivos,$totalRegistros);

        if ($totalDetalles === $totalInactivos) {
            $cambioestadocabeza = labCabezaPedidos::query()
                ->where('id', decrypt($idCabeza))
                ->update([
                    'EstadoDocumento' => 'Cancelado',
                ]);
            $detallePedidoc = labCabezaPedidos::DetallesPedidoPreconfirmado($idCabeza);
            return view('Ventas.DetallesOrdenPedidoPreConfirmado', compact('detallePedidoc'));
        } elseif ($totalRegistros === $totalDetalles) {
            $cambioestadocabeza = labCabezaPedidos::query()
                ->where('id', decrypt($idCabeza))
                ->update([
                    'EstadoDocumento' => 'Aceptado',
                ]);
            /* $detallePedidoc = labCabezaPedidos::DetallesPedidoPreconfirmado($idCabeza);
             return view('Ventas.DetallesOrdenPedidoPreConfirmado', compact('detallePedidoc'));*/
            return redirect(route('OrdenesPedidos'));
        } else {
            $detallePedidoc = labCabezaPedidos::DetallesPedidoPreconfirmado($idCabeza);
            return view('Ventas.DetallesOrdenPedidoPreConfirmado', compact('detallePedidoc'));
        }
    }

    public function ConfirmacionItemPedidoPreConfirmado($id, $idCabeza)
    {

        $date = Carbon::now()->format('Y-d-m H:i:s');

        $update = labdetallesPedidos::query()
            ->where('id', decrypt($id))
            ->update([
                'FlagActivo_EstadoPreConfirmacion' => 1,
                'FechaPreConfirmacionCliente' => $date,
            ]);

        $datosCalculo = labdetallesPedidos::query()
            ->select([
                'SemanaPlaneacionCicloFinal',
                'CantidadPlaneacionCicloFinal',
                'FactorPlaneacion',
                'SemanasXFaseMultiplicacion',
                'SemanaPlaneacion',
                'SemanaPlaneacionEnraizamiento',
                'CantidadPlaneacionEnraizamiento',
                'SemanaPlaneacionAdaptado',
                'CantidadPlaneacionAdaptado',
                'SemanaPlaneacionDespacho',
                'CantidadInicialModificada',
                'CantidadGermo',
                'CantidadPlaneacion',

            ])
            ->where('id_CabezaPedido', decrypt($idCabeza))
            ->where('Flag_Activo', 1)
            ->first();

        $SemanaPlaneacion = $datosCalculo->SemanaPlaneacionCicloFinal;
        $Semanafin = $datosCalculo->SemanaPlaneacion;
        $NumeroDeSemanasMultiplicacion = $datosCalculo->SemanasXFaseMultiplicacion;
        $cantidaPlantasFinal = $datosCalculo->CantidadPlaneacionCicloFinal;
        $Factor = $datosCalculo->FactorPlaneacion;

        $date = Carbon::now();
        $year = $date->format('Y');
        /*un año adicional*/
        $date1 = Carbon::now();
        $endDate1 = $date1->addYear();
        $year1 = $date1->format('Y');
        /*dos años adicionales*/
        $date2 = Carbon::now();
        $endDate2 = $date2->addYears(2);
        $year2 = $endDate2->format('Y');
        /*tres años adicionales*/
        $date3 = Carbon::now();
        $endDate3 = $date3->addYears(3);
        $year3 = $endDate3->format('Y');
        /*cuatro años adicionales*/
        $date4 = Carbon::now();
        $endDate4 = $date4->addYears(4);
        $year4 = $endDate4->format('Y');

        $weekFinal = Carbon::parse('29-12-' . $year)->week();
        $weekFinal1 = Carbon::parse('29-12-' . $year1)->week();
        $weekFinal2 = Carbon::parse('29-12-' . $year2)->week();
        $weekFinal3 = Carbon::parse('29-12-' . $year3)->week();
        $weekFinal4 = Carbon::parse('29-12-' . $year4)->week();

        $semanaigual = $SemanaPlaneacion;
        $resultadoPLantas = $cantidaPlantasFinal;
        //dd($datosCalculo->SemanaPlaneacion);

        while ($semanaigual >= $Semanafin) {
            //$array = array('Semana' => $semanaigual, 'Plantas' => $resultadoPLantas);
            $array = array('Semana' => $semanaigual, 'Plantas' => $resultadoPLantas);

            $cantidaPlantasFinal = $cantidaPlantasFinal / $Factor;
            $resultadoPLantas = $cantidaPlantasFinal;
            $SemanaPlaneacion = $SemanaPlaneacion - $NumeroDeSemanasMultiplicacion;
            $semanaigual = $SemanaPlaneacion;
            $Inicial = substr($semanaigual, 0, 4);
            $ultimo = substr($semanaigual, -2);
            if ($Inicial === $year && $ultimo > $weekFinal) {
                $semanaRela = 100 - $ultimo;
                $weekFinal = $weekFinal - $semanaRela;
                $SemanaPlaneacion = $year . '' . $weekFinal;
                $semanaigual = $SemanaPlaneacion;
            }

            if ($Inicial === $year1 && $ultimo > $weekFinal1) {
                $semanaRela = 100 - $ultimo;
                $weekFinal1 = $weekFinal1 - $semanaRela;
                $SemanaPlaneacion = $year1 . '' . $weekFinal1;
                $semanaigual = $SemanaPlaneacion;
            }
            if ($Inicial === $year2 && $ultimo > $weekFinal2) {
                $semanaRela = 100 - $ultimo;
                $weekFinal2 = $weekFinal2 - $semanaRela;
                $SemanaPlaneacion = $year2 . '' . $weekFinal2;
                $semanaigual = $SemanaPlaneacion;
            }

            if ($Inicial === $year3 && $ultimo > $weekFinal3) {
                $semanaRela = 100 - $ultimo;
                $weekFinal3 = $weekFinal3 - $semanaRela;
                $SemanaPlaneacion = $year3 . '' . $weekFinal3;
                $semanaigual = $SemanaPlaneacion;


            }
            if ($Inicial === $year4 && $ultimo > $weekFinal4) {
                $semanaRela = 100 - $ultimo;
                $weekFinal4 = $weekFinal4 - $semanaRela;
                $SemanaPlaneacion = $year4 . '' . $weekFinal4;
                $semanaigual = $SemanaPlaneacion;
            }


            $validandoSEmana = $array['Semana'];
            $ano = substr($semanaigual, 0, 4);
            $semana = substr($semanaigual, -2);

            if ($semana === '00' || $semana === 00) {
                $ano = $ano - 1;
                if ($ano == $year) {
                    $SemanaPlaneacion = $year . '' . $weekFinal;
                    $semanaigual = $SemanaPlaneacion;
                }
                if ($ano == $year1) {
                    $SemanaPlaneacion = $year1 . '' . $weekFinal1;
                    $semanaigual = $SemanaPlaneacion;
                }
                if ($ano == $year2) {
                    $SemanaPlaneacion = $year2 . '' . $weekFinal2;
                    $semanaigual = $SemanaPlaneacion;
                }
                if ($ano == $year3) {
                    $SemanaPlaneacion = $year3 . '' . $weekFinal3;
                    $semanaigual = $SemanaPlaneacion;
                }
                if ($ano == $year4) {
                    $SemanaPlaneacion = $year4 . '' . $weekFinal4;
                    $semanaigual = $SemanaPlaneacion;
                }
            }


            // dd( $array['Semana']);
            PlaneacionSemanalPorPedido::query()
                ->create([
                    'IdItemDetallePedido' => decrypt($id),
                    'SemanaMovimiento' => $array['Semana'],
                    'CantidadPlantas' => ceil($array['Plantas']),
                    'fase' => 6,
                    'flag_Activo' => 1
                ]);
        }

        PlaneacionSemanalPorPedido::query()
            ->create(['IdItemDetallePedido' => decrypt($id),
                'SemanaMovimiento' => $datosCalculo->SemanaPlaneacionEnraizamiento,
                'CantidadPlantas' => $datosCalculo->CantidadPlaneacionEnraizamiento,
                'fase' => 7,
                'flag_Activo' => 1]);
        PlaneacionSemanalPorPedido::query()
            ->create(['IdItemDetallePedido' => decrypt($id),
                'SemanaMovimiento' => $datosCalculo->SemanaPlaneacionAdaptado,
                'CantidadPlantas' => $datosCalculo->CantidadPlaneacionAdaptado,
                'fase' => 8,
                'flag_Activo' => 1]);

        PlaneacionSemanalPorPedido::query()
            ->create(['IdItemDetallePedido' => decrypt($id),
                'SemanaMovimiento' => $datosCalculo->SemanaPlaneacionDespacho,
                'CantidadPlantas' => $datosCalculo->CantidadInicialModificada,
                'fase' => 9,
                'flag_Activo' => 1]);


        $totalDetalles = labdetallesPedidos::query()
            ->where('id_CabezaPedido', decrypt($idCabeza))
            ->count();

        $totalActivosPlaneadosyConfirmados = labdetallesPedidos::query()
            ->where('id_CabezaPedido', decrypt($idCabeza))
            ->where('Flag_Activo', 1)
            ->where('Flag_ActivoPlaneacion', 1)
            ->where('FlagActivo_EstadoPreConfirmacion', 1)
            ->count();

        $totalInactivos = labdetallesPedidos::query()
            ->where('id_CabezaPedido', decrypt($idCabeza))
            ->where('Flag_Activo', 0)
            ->count();

        $totalRegistros = $totalActivosPlaneadosyConfirmados + $totalInactivos;


        if ($totalDetalles === $totalInactivos) {
            $cambioestadocabeza = labCabezaPedidos::query()
                ->where('id', decrypt($idCabeza))
                ->update(['EstadoDocumento' => 'Cancelado',]);
            /*$detallePedidoc = labCabezaPedidos::DetallesPedidoPreconfirmado($idCabeza);
            return view('Ventas.DetallesOrdenPedidoPreConfirmado', compact('detallePedidoc'));*/
            return redirect(route('OrdenesPedidos'));
        } elseif ($totalRegistros === $totalDetalles) {
            $cambioestadocabeza = labCabezaPedidos::query()
                ->where('id', decrypt($idCabeza))
                ->update([
                    'EstadoDocumento' => 'Aceptado',
                ]);

            $detallesPedidostTable = labdetallesPedidos::query()
                ->select([
                    'gen.NombreGenero',
                    'vari.Nombre_Variedad',
                    'vari.Codigo',
                    'labDetallesPedidosPlaneacion.CantidadInicialModificada',
                    'labDetallesPedidosPlaneacion.TipoEntregaModificada',
                    'labDetallesPedidosPlaneacion.SemanaEntregaModificada',
                    'labDetallesPedidosPlaneacion.FlagActivo_CancelacionPreConfirmado'
                ])
                ->join('URC_Variedades as vari', 'labDetallesPedidosPlaneacion.id_Variedad', '=', 'vari.id ')
                ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                ->where('id_CabezaPedido', decrypt($idCabeza))->get();

            $cabezaPedido = labCabezaPedidos::query()
                ->select(['cli.Nombre',
                    'NumeroPedido',
                    'Observaciones'
                ])
                ->join('clientesYBreeder_labs as cli', 'labCabezaPedidos.id_Cliente', '=', 'cli.id')
                ->where('labCabezaPedidos.id', decrypt($idCabeza))->first();

            $subj = 'Confirmacion pedido ' . $cabezaPedido->Nombre;
            Mail::send('Email.ConfirmacionCliente', ['CabezaPedido' => $cabezaPedido, 'DetallePedido' => $detallesPedidostTable], function ($msg) use ($subj) {
                $msg->subject($subj);
                $msg->from('pedidosLaboratorioDW@gmail.com', $subj);
                $msg->to('mmunoz@darwinperennials.com');
            });


            return redirect(route('OrdenesPedidos'));
        } else {
            $detallePedidoc = labCabezaPedidos::DetallesPedidoPreconfirmado($idCabeza);
            return view('Ventas.DetallesOrdenPedidoPreConfirmado', compact('detallePedidoc'));
        }
    }

    static function DetallesPlaneacionSemanaAsemanaC($id)
    {
        $detalles = PlaneacionSemanalPorPedido::DetallesPlaneacionSemanaAsemana($id);
        return $detalles;
    }

    function DeleteItemPlaneado(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'CausalCancelarPedido' => 'required',
            'cabeza' => 'required',
            'Detalle' => 'required'
        ]);

        $CausalCancelacion = $request->get('CausalCancelarPedido');
        $users = auth()->user()->id;

        if ($CausalCancelacion === '2' || $CausalCancelacion === '3') {
            $cabeza = labCabezaPedidos::query()
                ->where('id', $request->get('cabeza'))
                ->first();
            $detalle = labdetallesPedidos::query()
                ->where('id', $request->get('Detalle'))
                ->first();

            $NumPedido = labCabezaPedidos::query()->max('NumeroPedido');
            $NumPedido = $NumPedido + 1;

            $RadicadoCancelado = labdetallesPedidos::query()->max('RadicadoCancelacion');
            $RadicadoCancelado = $RadicadoCancelado + 1;

            $createCabeza = labCabezaPedidos::query()
                ->create([
                    'id_Cliente' => $cabeza->id_Cliente,
                    'SemanaEntrega' => $cabeza->SemanaEntrega,
                    'SemanaCreacion' => $cabeza->SemanaCreacion,
                    'NumeroPedido' => $NumPedido,
                    'id_UserCreacion' => $users,
                    'EstadoDocumento' => 'Solicitado',
                    'Observaciones' => 'cancelacion de referencia ' . $NumPedido . '-' . $cabeza->NumeroPedido . '-' . $detalle->id,
                    'Flag_Activo' => 1,
                    'IdcabezaInicial' => $cabeza->id,
                ]);
            $ultimoCreado = $createCabeza->id;
            $detalles = labdetallesPedidos::query()
                ->create([
                    'id_Variedad' => $detalle->id_Variedad,
                    'TipoEntrega' => $detalle->TipoEntrega,
                    'CantidadInicial' => $detalle->CantidadInicial,
                    'SemanaEntrega' => $detalle->SemanaEntrega,
                    'TipoEntregaModificada' => $detalle->TipoEntregaModificada,
                    'CantidadInicialModificada' => $detalle->CantidadInicialModificada,
                    'SemanaEntregaModificada' => $detalle->SemanaEntregaModificada,
                    'id_CabezaPedido' => $ultimoCreado,
                    'Flag_Activo' => 1,
                    'RadicadoCancelacion' => $RadicadoCancelado,
                    'IdDetalleInicial' => $detalle->cabe,
                ]);

            $updateitem = labdetallesPedidos::query()
                ->where('id', $request->get('Detalle'))
                ->update([
                    'CausalCancelacionEjecucion' => $request->get('CausalCancelarPedido'),
                    'CancelacionEjecucion' => 1,
                    'Flag_ActivoReplanteado' => 1,
                    'Flag_Activo' => 0,
                ]);

            $updateitem = PlaneacionSemanalPorPedido::query()
                ->where('IdItemDetallePedido', $request->get('Detalle'))
                ->update([
                    'flag_Activo' => 0,
                ]);
            /*aqui*/
            $totalDetalles = labdetallesPedidos::query()
                ->where('id_CabezaPedido', $request->get('cabeza'))
                ->count();

            $totalInactivos = labdetallesPedidos::query()
                ->where('id_CabezaPedido', $request->get('cabeza'))
                ->where('Flag_Activo', 0)
                ->count();
            if ($totalDetalles === $totalInactivos) {
                $cambioestadocabeza = labCabezaPedidos::query()
                    ->where('id', $request->get('cabeza'))
                    ->update([
                        'EstadoDocumento' => 'Cancelado',
                    ]);
                return redirect(route('OrdenesPedidos'));
            } else {
                $id = encrypt($request->get('cabeza'));
                $detallePedidoc = labCabezaPedidos::DetallesPedidoPreconfirmado($id);
                return view('Ventas.DetallesOrdenPedidoPreConfirmado', compact('detallePedidoc'));
            }

        } else {
            $RadicadoCancelado = labdetallesPedidos::query()->max('RadicadoCancelacion');
            $RadicadoCancelado = $RadicadoCancelado + 1;

            $cabeza = labCabezaPedidos::query()
                ->where('id', $request->get('cabeza'))
                ->first();
            $detalle = labdetallesPedidos::query()
                ->where('id', $request->get('Detalle'))
                ->first();

            $updateitem = labdetallesPedidos::query()
                ->where('id', $request->get('Detalle'))
                ->update([
                    'CausalCancelacionEjecucion' => $request->get('CausalCancelarPedido'),
                    'CancelacionEjecucion' => 1,
                    'RadicadoCancelacion' => $RadicadoCancelado,
                    'Flag_Activo' => 0,
                ]);

            $updateitem = PlaneacionSemanalPorPedido::query()
                ->where('IdItemDetallePedido', $request->get('Detalle'))
                ->update([
                    'flag_Activo' => 0,
                ]);
            $totalDetalles = labdetallesPedidos::query()
                ->where('id_CabezaPedido', $request->get('cabeza'))
                ->count();

            $totalInactivos = labdetallesPedidos::query()
                ->where('id_CabezaPedido', $request->get('cabeza'))
                ->where('Flag_Activo', 0)
                ->count();
            if ($totalDetalles === $totalInactivos) {
                $cambioestadocabeza = labCabezaPedidos::query()
                    ->where('id', $request->get('cabeza'))
                    ->update([
                        'EstadoDocumento' => 'Cancelado',
                    ]);
                return redirect(route('OrdenesPedidos'));
            } else {
                $id = encrypt($request->get('cabeza'));
                $detallePedidoc = labCabezaPedidos::DetallesPedidoPreconfirmado($id);
                return view('Ventas.DetallesOrdenPedidoPreConfirmado', compact('detallePedidoc'));
            }
        }
    }


    /**********************************************REPORTES DE LOS PEDIDOS ******************************************/
    public function ReporteConfirmacion()
    {
        $PedidosConfirmados = DB::table('labcabezapedidos as cb')
            ->leftJoin('clientesYBreeder_labs as cl', 'cl.id', '=', 'cb.id_Cliente')
            ->leftJoin('labDetallesPedidosPlaneacion as dt', 'dt.id_CabezaPedido', '=', 'cb.id')
            ->join('urc_variedades as vari', 'vari.id', '=', 'dt.id_Variedad')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'vari.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
            ->select(
                'cb.NumeroPedido',
                'URC_Generos.NombreGenero',
                'vari.Codigo',
                'vari.Nombre_Variedad',
                'cl.Indicativo',
                'dt.TipoEntrega',
                'cb.TipoPrograma',
                'dt.SemanaPlaneacionDespacho',
                'dt.CantidadInicialModificada'

            )
            ->where('cb.Flag_Activo', '=', 1)
            ->where('cb.EstadoDocumento', '=', 'Aceptado')
            ->get();

        // dd($PedidosConfirmados);

        return view('Ventas.ReporteConfirmacion', compact('PedidosConfirmados'));
    }

    public function ReporteGeneralPedidos()
    {
        $PedidosGeneral = DB::table('labcabezapedidos as cb')
            ->leftJoin('clientesYBreeder_labs as cl', 'cl.id', '=', 'cb.id_Cliente')
            ->leftJoin('labDetallesPedidosPlaneacion as dt', 'dt.id_CabezaPedido', '=', 'cb.id')
            ->leftJoin('CausalesCancelacionPlaneacion as cau', 'cau.id', '=', 'dt.CausalCancelacionEjecucion')
            ->join('urc_variedades as vari', 'vari.id', '=', 'dt.id_Variedad')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'vari.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
            ->select(
                'cb.NumeroPedido',
                'URC_Generos.NombreGenero',
                'vari.Codigo',
                'vari.Nombre_Variedad',
                'cl.Indicativo',
                'dt.TipoEntrega',
                'cb.TipoPrograma',
                'dt.SemanaPlaneacionDespacho',
                'dt.CantidadInicialModificada',
                'cb.SemanaCreacion',
                'dt.CantidadInicialModificada',
                'dt.Flag_Activo',
                'dt.ObservacionCancelacion',
                'cau.causalCancelacion',
                'dt.SemanaEntrega',
                'dt.Flag_ActivoPlaneacion',
                'dt.CancelacionEjecucion'
            )
            ->get();

        //dd($PedidosGeneral);

        return view('Ventas.ReporteGeneralPedidos', compact('PedidosGeneral'));
    }

    public function ReportePlaneacionPedidos()
    {
        $PedidosGeneral = DB::table('labcabezapedidos as cb')
            ->leftJoin('clientesYBreeder_labs as cl', 'cl.id', '=', 'cb.id_Cliente')
            ->leftJoin('labDetallesPedidosPlaneacion as dt', 'dt.id_CabezaPedido', '=', 'cb.id')
            ->leftJoin('CausalesCancelacionPlaneacion as cau', 'cau.id', '=', 'dt.CausalCancelacionEjecucion')
            ->join('urc_variedades as vari', 'vari.id', '=', 'dt.id_Variedad')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'vari.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
            ->select(
                'dt.id',
                'cb.NumeroPedido',
                'URC_Generos.NombreGenero',
                'vari.Codigo',
                'vari.Nombre_Variedad',
                'cl.Indicativo',
                'dt.TipoEntrega',
                'cb.TipoPrograma',
                'dt.SemanaPlaneacionDespacho',
                'dt.CantidadInicialModificada',
                'cb.SemanaCreacion',
                'dt.CantidadInicialModificada',
                'dt.Flag_Activo',
                'dt.ObservacionCancelacion',
                'cau.causalCancelacion',
                'dt.SemanaEntrega',
                'dt.CancelacionEjecucion'

            )
            ->where('dt.Flag_Activo', 1)
            ->where('dt.FlagActivo_EstadoPreConfirmacion', 1)
            ->get();

        //dd($PedidosGeneral);

        return view('Ventas.ReportePlaneacionPedidos', compact('PedidosGeneral'));
    }

    public function ExportarReportePedido()
    {
        set_time_limit(0);
        return Excel::download(new ExportPlaneacionProgramas(), 'Reporte Planeacion.xlsx');
    }

    public function NewVariedad(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'cabeza' => 'required',
            'Variedad' => 'required',
            'TipoEntrega' => 'required',
            'SemanaV' => 'required',
            'Cantidad' => 'required',
        ]);
        $SemanaInicialCalculo = $request->get('SemanaV');
        $semanaIC = explode('-W', $SemanaInicialCalculo);
        $yearActual = $semanaIC[0];
        $weekPlaning = $semanaIC[1];
        $semana = $yearActual . '' . $weekPlaning;

        $detalles = labdetallesPedidos::query()
            ->create([
                'id_Variedad' => $request->get('Variedad'),
                'TipoEntrega' => $request->get('TipoEntrega'),
                'CantidadInicial' => $request->get('Cantidad'),
                'SemanaEntrega' => $semana,
                'TipoEntregaModificada' => $request->get('TipoEntrega'),
                'CantidadInicialModificada' => $request->get('Cantidad'),
                'SemanaEntregaModificada' => $semana,
                'id_CabezaPedido' => $request->get('cabeza'),
                'Flag_Activo' => 1,
            ]);
        return redirect(route('OrdenPedidoDetalle', ['id' => encrypt($request->get('cabeza'))]));
    }


    /**********************EJECUCIONES SEMANALES ************/

    public function vistaRepoteEjecucionesSemanales()
    {

        $ejecuciones = GetEtiquetasLabInventario::EjecucionSemanales();

        return view('Ventas.EjecucionesSemanalesLab', compact('ejecuciones'));
    }
}
