@extends('layouts.Principal')
@section('contenidoPrincipal')

    <style>
        #div1 {
            overflow: scroll;
            height: 200px;
        }
    </style>
    <div class="card row">
        <div style="display: flex; justify-content:center; align-items: flex-end;">
            <h2><i class="fa fa-barcode"></i> Generacion Etiquetas</h2>
        </div>
        <div class="box-body">
            <ul class="nav nav-tabs text-center" id="myTab" role="tablist">
                <li>
                    <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#CambioFaseProduccion">Cambio Fase</a></li>
                <li>
                    <a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#DespunteDiv">Despunte</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">

                <div id="CambioFaseProduccion" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">

                    <div class="card card-body">
                        <div class="card-primary ">
                            <table id="tableCambioFase" class="table table-hover display nowrap col-md-12 col-lg-12 col-xl-12 cell-border">
                                <thead class="bg-blue-gradient">
                                <tr>
                                    <th>Item</th>
                                    <th># Introduccion</th>
                                    <th>Semana Despacho</th>
                                    <th>Semana Ingreso</th>
                                    <th>Cliente</th>
                                    <th>Cantidad Plantas</th>
                                    <th>Fase Actual</th>
                                    <th>Fase Siguiente</th>
                                    <th>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($count = 1)
                                @foreach($introducciones  as $Introduccion)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{ $Introduccion->Indentificador }}</td>
                                        <td>{{ $Introduccion->SemanaDespacho }}</td>
                                        <td>{{ $Introduccion->SemanaIngreso }}</td>
                                        <td>{{ $Introduccion->cliente }}</td>
                                        <td>{{ $Introduccion->CantPlantas }}</td>
                                        <td>{{ $Introduccion->fase_Actual }}</td>
                                        <td>{{ $Introduccion->SiguienteFase }}</td>

                                        <td align="center">

                                            {{--<button data-wathever=" {{ json_encode($Introduccion) }}" data-toggle="modal" data-target="#cambiarfase" class="btn btn-primary" title="Cambiar Fase" style="position: center">
                                                <i class="fa fa-line-chart"></i>
                                            </button>--}}
                                            <button class="btn btn-primary btn-circle btn-sm" data-toggle="modal" data-target="#cambiarfase" data-whatever="{{ json_encode($Introduccion) }}">
                                                <i data-toggle="tooltip" data-placement="left" title="Cambiar Fase" class="fa fa-edit"></i>
                                            </button>
                                            {{-- <button class="btn btn-danger btn-round btn-sm"  data-target="#cambiarfase" data-whatever="{{ json_encode($Introduccion) }}">
                                                 <i data-toggle="tooltip" data-placement="left" title="Inactivar" class="fa fa-edit"></i>
                                             </button>--}}
                                        </td>
                                    </tr>
                                    @php($count++)
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>

                <div id="DespunteDiv" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card card-primary">
                        <div class="card card-body">
                            <table id="tableDespunte" class="table table-hover display nowrap col-md-12 col-lg-12 col-xl-12 cell-border">
                                <thead class="bg-blue-gradient">
                                <tr>
                                    <th>Item</th>
                                    <th># Introduccion</th>
                                    <th>Semana Despacho</th>
                                    <th>Semana Ingreso</th>
                                    <th>Cliente</th>
                                    <th>Cantidad Plantas</th>
                                    <th>Fase Actual</th>
                                    <th>Fase Siguiente</th>
                                    <th>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($count = 1)
                                @foreach($despuntes  as $despunte)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{ $despunte->Indentificador }}</td>
                                        <td>{{ $despunte->SemanaDespacho }}</td>
                                        <td>{{ $despunte->SemanaIngreso }}</td>
                                        <td>{{ $despunte->cliente }}</td>
                                        <td>{{ $despunte->CantPlantas }}</td>
                                        <td>{{ $despunte->fase_Actual }}</td>
                                        <td>{{ $despunte->SiguienteFase }}</td>

                                        <td align="center">
                                            <button class="btn btn-primary btn-circle btn-sm" data-toggle="modal" data-target="#Despunte" data-whatever="{{ json_encode($despunte) }}">
                                                <i data-toggle="tooltip" data-placement="left" title="Etiquetas Despunte" class="fa fa-edit"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    @php($count++)
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="cambiarfase" class="modal" role="dialog">
            <form action="{{ route('CambiarFaseLabChr') }}" id="CambiarFaseLabChr" method="post">
                @csrf
                <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <input type="hidden" id="NumIntroduccionEn" name="NumIntroduccionEn">
                        <input type="hidden" id="SemanaDespachoC" name="SemanaDespachoC">
                        <input type="hidden" id="SemanaIngresoC" name="SemanaIngresoC">
                        <input type="hidden" id="ID_VariedadC" name="ID_VariedadC">
                        <input type="hidden" id="ID_FaseActualC" name="ID_FaseActualC">
                        <input type="hidden" id="CantidadSalida" name="CantidadSalida">
                        <input type="hidden" id="clienteC" name="clienteC">
                        <div class="modal-header">
                            <h3 class="modal-title"><i style="font-size: 40px; color: #0b97c4"></i> Cambiar de Fase</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <label># Introduccion</label>
                                    <input id="NumIntroduccion" class="form-control labelform" disabled>

                                </div>
                                <div class="col-lg-4">
                                    <label>Fase Actual</label>
                                    <input id="FaseActual" name="FaseActual" class="form-control labelform" disabled>
                                </div>

                                <div class="col-lg-4">
                                    <label>Fase Siguiente</label>
                                    {{--<input id="FaseNueva" name="FaseNueva" class="form-control labelform" disabled>--}}
                                    <select class="labelform form-control" required="required" name="idFaseN" id="idFaseN">

                                    </select>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-lg-1">
                                    <label>Cant Plantas</label>
                                    <input id="Cantidad" name="Cantidad" CLASS="form-control labelform monto" onkeyup="sumar();">
                                </div>
                                <div class="col-lg-1">
                                    <label>Plantas Adic.</label>
                                    <input value="0" id="CantidadAdicional" name="CantidadAdicional" CLASS="form-control labelform monto" onkeyup="sumar();">
                                </div>

                                <div class="col-lg-1">
                                    <label>Total Plantas</label>
                                    <input id="TotalPlantas" name="TotalPlantas" CLASS="form-control labelform" disabled>
                                </div>

                                <div class="col-lg-1">
                                    <label>Cant Aproximadas</label>
                                    <input id="TotalPlantas" name="TotalPlantas" CLASS="form-control labelform" disabled>
                                </div>
                                <div class="col-lg-2"></div>
                                <div class="col-lg-3" id="SemDespacho">
                                    <label>Semana Despacho</label>
                                    <input type="week" id="SemDespachod" name="SemDespacho" CLASS="form-control labelform">
                                </div>
                                <div class="col-lg-3" id="Cliente">
                                    <label>Cliente</label>
                                    <select class="form-control labelform" name="Cliente" id="Cliented">
                                        <option selected="true" value="">Seleccione.....</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->Indicativo }}"> {{ $cliente->Nombre }} - {{ $cliente->Tipo }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12" id="divtabladetalles">
                            <div class="panel-primary">
                                <div class="box box-body">
                                    <div class="table-responsive" id="div1">
                                        <table id="TableCodigosBarras" class="table table-striped table-bordered" style="height: 150px;">
                                            <thead>
                                            <tr>
                                                <th>itemm</th>
                                                <th>Codigo Barras</th>
                                                <th>Variedad</th>
                                                <th>Tipo Frasco</th>
                                                <th>Cantidad Frasco</th>
                                                <th>Tipo Salida</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="form-row">
                                <div class="col-lg-12 card text-center" id="PreguntaAdicionales">
                                    <div class="col-lg-12">
                                        <label>Desea Agregar Programas Adicionales?</label>
                                    </div>
                                    <div class="">
                                        <label>Si
                                            <input type="radio" id="Radiosi" name="radio" value="1">
                                            <span class="checkmark"></span>
                                        </label>

                                        <label>No
                                            <input type="radio" id="Radiono" name="radio" value="0" checked>
                                            <span class="checkmark"></span>
                                        </label>

                                    </div>
                                </div>

                                <div class="row col-lg-12" id="DivAdicionales">

                                    <div class="col-md-4"></div>
                                    <div class="col-lg-4">
                                        <label>Programas Adicionales</label>
                                        <select class="form-control" id="Adicionales" name="Adicionales">
                                            <option selected="true" value="" id="Adicionales" disabled="disabled">Seleccione.....</option>
                                            <option value="1" id="Adiczg1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-row" id="DivAdicional1">
                                        <div class="col-lg-3" id="">
                                            <label>Fase Adic. 1</label>
                                            <select class="labelform form-control" id="idFaseAdi1" name="idFaseAdi1">
                                                <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                                <option value="5">Stock</option>
                                                <option value="6">Multiplicacion</option>
                                                <option value="7">Enraizamiento</option>
                                                <option value="8">Adaptacion</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Plantas Adic. 1</label>
                                            <input value="0" name="CantidadAdicional1" CLASS="form-control labelform monto" onkeyup="sumar();">
                                        </div>
                                        <div class="col-lg-3" id="DivSemDespacho1">
                                            <label>Sem Despacho Adic. 1</label>
                                            <input type="week" name="SemDespacho1" id="SemDespacho1" CLASS="form-control labelform">
                                        </div>
                                        <div class="col-lg-4" id="DivCliente1">
                                            <label>Cliente Adic. 1</label>
                                            <select class="form-control labelform" name="Cliente1" id="Cliente1">
                                                <option selected="true" value="">Seleccione.....</option>
                                                @foreach($clientes as $cliente)
                                                    <option value="{{ $cliente->Indicativo }}"> {{ $cliente->Nombre }} - {{ $cliente->Tipo }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div id="DivAdicional2" class="form-row">
                                        <div class="col-lg-3" id="">
                                            <label>Fase Adic. 2</label>
                                            <select class="labelform form-control" id="idFaseAdi2" name="idFaseAdi2">
                                                <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                                <option value="5">Stock</option>
                                                <option value="6">Multiplicacion</option>
                                                <option value="7">Enraizamiento</option>
                                                <option value="8">Adaptacion</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Plantas Adic. 2</label>
                                            <input value="0" name="CantidadAdicional2" CLASS="form-control labelform monto" onkeyup="sumar();">
                                        </div>
                                        <div class="col-lg-3" id="DivSemDespacho2">
                                            <label>Sem Despacho Adic. 2</label>
                                            <input type="week" name="SemDespacho2" id="SemDespacho2" CLASS="form-control labelform">
                                        </div>
                                        <div class="col-lg-4" id="DivCliente2">
                                            <label>Cliente Adic. 1</label>
                                            <select class="form-control labelform" name="Cliente2" id="Cliente2">
                                                <option selected="true" value="">Seleccione.....</option>
                                                @foreach($clientes as $cliente)
                                                    <option value="{{ $cliente->Indicativo }}"> {{ $cliente->Nombre }} - {{ $cliente->Tipo }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div id="DivAdicional3" class="form-row">
                                        <div class="col-lg-3" id="">
                                            <label>Fase Adic. 3</label>
                                            <select class="labelform form-control" id="idFaseAdi3" name="idFaseAdi3">
                                                <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                                <option value="5">Stock</option>
                                                <option value="6">Multiplicacion</option>
                                                <option value="7">Enraizamiento</option>
                                                <option value="8">Adaptacion</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Plantas Adic. 1</label>
                                            <input value="0" name="CantidadAdicional3" id="CantidadAdicional3" CLASS="form-control labelform monto" onkeyup="sumar();">
                                        </div>
                                        <div class="col-lg-3" id="DivSemDespacho3">
                                            <label>Sem Despacho Adic. 1</label>
                                            <input type="week" name="SemDespacho3" id="SemDespacho3" CLASS="form-control labelform">
                                        </div>
                                        <div class="col-lg-4" id="DivCliente3">
                                            <label>Cliente Adic. 1</label>
                                            <select class="form-control labelform" name="Cliente3" id="Cliente3">
                                                <option selected="true" value="">Seleccione.....</option>
                                                @foreach($clientes as $cliente)
                                                    <option value="{{ $cliente->Indicativo }}"> {{ $cliente->Nombre }} - {{ $cliente->Tipo }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col-lg-12" id="guardarInFra">
                                <button type="button" id="BtnCambiarFase" class="btn-lg btn-block btn btn-outline-success">Imprimir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div id="Despunte" class="modal fade bigEntrance2" role="dialog">
            <form id="FormEtiquetasDespunte" action="{{ route('EtiquetasDespunte') }}" method="post">
                @csrf
                <div class="modal-dialog modal-xl" style="width: 80% !important; margin-top: 20px">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <input type="hidden" id="NumIntroduccionEnDespunte" name="NumIntroduccionEnDespunte">
                        <input type="hidden" id="SemanaIngresoCDespunte" name="SemanaIngresoCDespunte">
                        <input type="hidden" id="SemanaDespachoCDespunte" name="SemanaDespachoCDespunte">
                        <input type="hidden" id="ID_VariedadCDespunte" name="ID_VariedadCDespunte">
                        <input type="hidden" id="ID_FaseActualCDespunte" name="ID_FaseActualCDespunte">
                        <input type="hidden" id="CantidadSalidaDespunte" name="CantidadSalidaDespunte">
                        <input type="hidden" id="clienteCDespunte" name="clienteCDespunte">
                        <div class="modal-header">
                            <h3 class="modal-title"><i style="font-size: 40px; color: #0b97c4"></i> Cambiar de Fase</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body col-lg-12">
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <label># Introduccion</label>
                                    <input id="NumIntroduccionDespunte" class="form-control labelform" disabled>

                                </div>
                                <div class="col-lg-4">
                                    <label>Fase Actual</label>
                                    <input id="FaseActualDespunte" name="FaseActualDespunte" class="form-control labelform" disabled>
                                </div>
                                <div class="col-lg-4">
                                    <label>Fase Siguiente</label>
                                    {{--<input id="FaseNueva" name="FaseNueva" class="form-control labelform" disabled>--}}
                                    <input id="NewFaseDespunte" name="NewFaseDespunte" value="Adaptacion" class="form-control labelform" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-1">
                                    <label>Cant Plantas</label>
                                    <input id="CantidadDespunte" name="CantidadDespunte" CLASS="form-control labelform montoDespunte" onkeyup="sumarDespunte();">
                                </div>
                                <div class="col-lg-1">
                                    <label>Plantas Adic.</label>
                                    <input value="0" id="CantidadAdicionalDespunte" name="CantidadAdicionalDespunte" CLASS="form-control labelform montoDespunte" onkeyup="sumarDespunte();">
                                </div>
                                <div class="col-lg-1">
                                    <label>Total Plantas</label>
                                    <input id="TotalPlantasDespunte" name="TotalPlantasDespunte" CLASS="form-control labelform" disabled>
                                </div>
                                <div class="col-lg-1">
                                    <label>Cant Aproximadas</label>
                                    <input id="TotalPlantasDespunte" name="TotalPlantasDespunte" CLASS="form-control labelform" disabled>
                                </div>
                                <div class="col-lg-2"></div>
                                <div class="col-lg-3" id="SemDespacho">
                                    <label>Semana Despacho</label>
                                    <input type="week" id="SemDespachoDespunte" name="SemDespachoDespunte" CLASS="form-control labelform">
                                </div>
                                <div class="col-lg-3" id="Cliente">
                                    <label>Cliente</label>
                                    <select class="form-control labelform" name="ClienteDespunte" id="ClienteDespunte">
                                        <option selected="true" value="">Seleccione.....</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->Indicativo }}"> {{ $cliente->Nombre }} - {{ $cliente->Tipo }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12" id="divtabladetalles">
                            <div class="panel-primary">
                                <div class="box box-body">
                                    <div class="table-responsive" id="div1">
                                        <table id="TableCodigosBarras" class="table table-hove">
                                            <thead class="bg-blue-gradient">
                                            <tr>
                                                <th>item</th>
                                                <th>Codigo Barras</th>
                                                <th>Variedad</th>
                                                <th>Tipo Frasco</th>
                                                <th>Cantidad Frasco</th>
                                                <th>Tipo Salida</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col-lg-12" id="guardarInFra">

                                <button id="BbtnimprimirDespunte" type="button" class="btn-lg btn-block btn btn-outline-success">Imprimir</button>


                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" value="{{ csrf_token() }}" name="token" id="token">

    <script>
        let token = $('#token').val();
        let count = 1;

        $('#DivSemDespacho1').hide();
        $('#DivCliente1').hide();
        $('#DivSemDespacho2').hide();
        $('#DivCliente2').hide();
        $('#DivSemDespacho3').hide();
        $('#DivCliente3').hide();

        $(document).ready(function () {
            $('#tableCambioFase').DataTable({});

            $('#tableDespunte').DataTable({});

            $('#idFaseN').change(function () {
                let Fase = $('#ID_FaseActualC').val();
                let a = $('#idFaseN').val();
                let SemanaDespachoC = $('#SemanaDespachoC').val();

                if (Fase === '2' || Fase === '1') {
                    $('#PreguntaAdicionales').hide();
                } else if (Fase === '12' && a >= '6' && SemanaDespachoC === '') {
                    $('#SemDespacho').show();
                    $('#Cliente').show();
                } else if (Fase === '12' && a >= '6' && SemanaDespachoC >= '0') {
                    $('#SemDespacho').hide();
                    $('#Cliente').hide();
                } else if (Fase >= 6) {
                    $('#SemDespacho').hide();
                    $('#Cliente').hide();
                } else if (Fase <= 3) {
                    $('#SemDespacho').hide();
                    $('#Cliente').hide();
                } else if (Fase >= '4' && a >= '6') {
                    $('#SemDespacho').show();
                    $('#Cliente').show();
                } else if (Fase >= '4' && a <= '5') {
                    $('#SemDespacho').hide();
                    $('#Cliente').hide();
                }

            });

            $('#Adicionales').change(function () {
                let cant = $(this).val();
                if (cant === '1') {
                    $('#DivAdicional1').show();
                    $('#DivAdicional2').hide();
                    $('#DivAdicional3').hide();
                } else if (cant === '2') {
                    $('#DivAdicional1').show();
                    $('#DivAdicional2').show();
                    $('#DivAdicional3').hide();
                } else if (cant === '3') {
                    $('#DivAdicional1').show();
                    $('#DivAdicional2').show();
                    $('#DivAdicional3').show();
                }
            });

            $('#idFaseAdi1').change(function () {
                let idFaseAdi1 = $(this).val();
                if (idFaseAdi1 === '5') {
                    $('#DivSemDespacho1').hide();
                    $('#DivCliente1').hide();
                } else {
                    $('#DivSemDespacho1').show();
                    $('#DivCliente1').show();
                }
            });

            $('#idFaseAdi2').change(function () {
                let idFaseAdi2 = $(this).val();
                if (idFaseAdi2 === '5') {
                    $('#DivSemDespacho2').hide();
                    $('#DivCliente2').hide();
                } else {
                    $('#DivSemDespacho2').show();
                    $('#DivCliente2').show();
                }
            });

            $('#idFaseAdi3').change(function () {
                let idFaseAdi3 = $(this).val();
                if (idFaseAdi3 === '5') {
                    $('#DivSemDespacho3').hide();
                    $('#DivCliente3').hide();
                } else {
                    $('#DivSemDespacho3').show();
                    $('#DivCliente3').show();
                }
            });

            $('#BbtnimprimirDespunte').click(function () {
                let SemanaDEspacho = $('#SemDespachoDespunte').val();
                let Cliente = $('#ClienteDespunte').val();
                if (SemanaDEspacho === '' || Cliente === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Debe llenar semana y cliente',
                    });
                } else {
                    $('#FormEtiquetasDespunte').submit();
                }
            });
        });

        $('#BtnCambiarFase').click(function (event) {
            let a = $('#idFaseN').val();
            let FaseActual = $('#ID_FaseActualC').val();
            let validaadicinal = $('input:radio[name=radio]:checked').val();
            let SemanaDespachoC = $('#SemanaDespachoC').val();

            if (FaseActual === '12') {
                $('#PreguntaAdicionales').hide();
            }

            if (FaseActual === '12' &&  a < '6') {

                    $('#CambiarFaseLabChr').submit();

            }

            else if (FaseActual === '12' &&  a >= '6' && SemanaDespachoC ==='') {
                if ($('#SemDespachod').val().trim() === '' || $('#Cliented').val().trim() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'error...',
                        text: 'Debe Diligeniciar todos los datos.',
                    });
                } else {
                    $('#CambiarFaseLabChr').submit();
                }
            }

            else if (FaseActual === '12' &&  a >= '6' && SemanaDespachoC >='') {
                $('#CambiarFaseLabChr').submit();
            }




            else if (a >= '6' && validaadicinal === '0' && FaseActual < '6') {
                if ($('#SemDespachod').val().trim() === '' || $('#Cliented').val().trim() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'error...',
                        text: 'Debe Diligeniciar todos los datos.',
                    });
                } else {
                    $('#CambiarFaseLabChr').submit();
                }
            } else if (a >= '6' && validaadicinal === '1' && FaseActual < '6') {
                let cantidadAdiconales = $('#Adicionales').val();
                if ($('#SemDespachod').val().trim() === '' || $('#Cliented').val().trim() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'error...',
                        text: 'Debe Diligeniciar todos los datos.',
                    });
                } else {
                    if (cantidadAdiconales === '1') {
                        if ($('#idFaseAdi1').val() > '5') {
                            if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: 'Debe Diligeniciar todos los datos',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() === '5') {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if (cantidadAdiconales === '2') {
                        if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() > '5') {
                            if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '' || $('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error...',
                                    text: 'Debe Diligeniciar todos los datos.',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() === '5') {
                            if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error...',
                                    text: 'Debe Diligeniciar todos los datos.',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() > '5') {
                            if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error...',
                                    text: 'Debe Diligeniciar todos los datos.',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() === '5') {
                            $('#CambiarFaseLabChr').submit();
                        }

                    } else if (cantidadAdiconales === '3') {
                        if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() > '5') {
                            if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '' || $('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '' || $('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error...',
                                    text: 'Debe Diligeniciar todos los datos.',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() === '5') {
                            if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error...',
                                    text: 'Debe Diligeniciar todos los datos.',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() === '5') {
                            if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '' || $('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error...',
                                    text: 'Debe Diligeniciar todos los datos.',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() > '5') {
                            if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '' || $('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error...',
                                    text: 'Debe Diligeniciar todos los datos.',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() > '5') {
                            if ($('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error...',
                                    text: 'Debe Diligeniciar todos los datos.',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() === '5') {
                            if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error...',
                                    text: 'Debe Diligeniciar todos los datos.',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() > '5') {
                            if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '' || $('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error...',
                                    text: 'Debe Diligeniciar todos los datos.',
                                });
                            } else {
                                $('#CambiarFaseLabChr').submit();
                            }
                        } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() === '5') {
                            $('#CambiarFaseLabChr').submit();
                        }
                    }
                }

            } else if (a < '6' && validaadicinal === '0') {
                $('#CambiarFaseLabChr').submit();
            } else if (a < '6' && validaadicinal === '1') {
                ////////////////////////////////////////////////////////////////////////////////////aqui
                let cantidadAdiconales = $('#Adicionales').val();
                if (cantidadAdiconales === '1') {
                    if ($('#idFaseAdi1').val() > '5') {
                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5') {
                        $('#CambiarFaseLabChr').submit();
                    }
                } else if (cantidadAdiconales === '2') {
                    if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() > '5') {
                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '' || $('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() === '5') {
                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() > '5') {
                        if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() === '5') {
                        $('#CambiarFaseLabChr').submit();
                    }

                } else if (cantidadAdiconales === '3') {

                    if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() > '5') {

                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '' || $('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '' || $('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }

                    } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() === '5') {
                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() === '5') {
                        if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '' || $('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() > '5') {
                        if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '' || $('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() > '5') {
                        if ($('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() === '5') {
                        if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() > '5') {
                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '' || $('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() === '5') {
                        $('#CambiarFaseLabChr').submit();
                    }
                }
            } else if (FaseActual >= '6' && a >= '6' && validaadicinal === '0') {
                $('#CambiarFaseLabChr').submit();
            } else if (FaseActual >= '6' && a >= '6' && validaadicinal === '1') {
                let cantidadAdiconales = $('#Adicionales').val();
                if (cantidadAdiconales === '1') {
                    if ($('#idFaseAdi1').val() > '5') {
                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5') {
                        $('#CambiarFaseLabChr').submit();
                    }
                } else if (cantidadAdiconales === '2') {
                    if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() > '5') {
                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '' || $('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() === '5') {
                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() > '5') {
                        if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() === '5') {
                        $('#CambiarFaseLabChr').submit();
                    }

                } else if (cantidadAdiconales === '3') {

                    if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() > '5') {

                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '' || $('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '' || $('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }

                    } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() === '5') {
                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() === '5') {
                        if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '' || $('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() > '5') {
                        if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '' || $('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() > '5') {
                        if ($('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() > '5' && $('#idFaseAdi3').val() === '5') {
                        if ($('#SemDespacho2').val().trim() === '' || $('#Cliente2').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() > '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() > '5') {
                        if ($('#SemDespacho1').val().trim() === '' || $('#Cliente1').val().trim() === '' || $('#SemDespacho3').val().trim() === '' || $('#Cliente3').val().trim() === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'error...',
                                text: 'Debe Diligeniciar todos los datos.',
                            });
                        } else {
                            $('#CambiarFaseLabChr').submit();
                        }
                    } else if ($('#idFaseAdi1').val() === '5' && $('#idFaseAdi2').val() === '5' && $('#idFaseAdi3').val() === '5') {
                        $('#CambiarFaseLabChr').submit();
                    }
                }
            }
        });


        $('#cambiarfase').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever'); // Extract info from data-* attributes
            let count = 1;
            let FaseActual = data.ID_FaseActual;
            let Indentificador = data.Indentificador;
            $('#SemDespacho').hide();
            $('#Cliente').hide();
            $('#DivAdicionales').hide();
            $('#DivAdicional1').hide();
            $('#DivAdicional2').hide();
            $('#DivAdicional3').hide();

            if (FaseActual <= '2' || FaseActual === '11') {
                $('#PreguntaAdicionales').hide();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {FaseActual,Indentificador},
                    url: '{{ route('SelectFasenueva') }}',
                    type: 'post',
                    success: function (Result) {
                        //console.log(Result);
                        $("#idFaseN").empty().selectpicker('destroy');
                        $.each(Result.Data, function (i, item) {
                            $("#idFaseN").append('<option value="' + item.id + '">' + item.NombreFase + '</option>');
                        });
                        $('#idFaseN').selectpicker({
                            size: 4,
                            liveSearch: true,
                        });
                    },
                    error: function (e) {
                        //console.log(e);
                        $.each(error.responseJSON.errors, function (i, item) {
                            alertify.error(item)
                        });
                    }
                });
            } else {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {FaseActual},
                    url: '{{ route('SelectFasenueva') }}',
                    type: 'post',
                    success: function (Result) {
                        //console.log(Result);
                        $("#idFaseN").empty().selectpicker('destroy');
                        $.each(Result.Data, function (i, item) {
                            $("#idFaseN").append('<option value="' + item.id + '">' + item.NombreFase + '</option>');
                        });
                        $('#idFaseN').selectpicker({
                            size: 4,
                            liveSearch: true,
                        });
                    },
                    error: function (e) {
                        //console.log(e);
                        $.each(error.responseJSON.errors, function (i, item) {
                            alertify.error(item)
                        });
                    }
                });
                $('#PreguntaAdicionales').show();
            }
            var modal = $(this);
            $('#NumIntroduccion').val(data.Indentificador);
            $('#FaseActual').val(data.fase_Actual);
            $('#Cantidad').val(data.CantPlantas);
            $('#TotalPlantas').val(data.CantPlantas);

            $('#NumIntroduccionEn').val(data.Indentificador);
            $('#SemanaDespachoC').val(data.SemanaDespacho);
            $('#SemanaIngresoC').val(data.SemanaIngreso);
            $('#ID_VariedadC').val(data.ID_Variedad);
            $('#ID_FaseActualC').val(data.ID_FaseActual);
            $('#clienteC').val(data.cliente);


            let Identificador = data.Indentificador;
            let faseactual = data.ID;
            let SemanaDespacho1 = data.SemanaDespacho;
            let cliente = data.cliente;


            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                data: {valor: Identificador, fase: faseactual, SemanaDespacho: SemanaDespacho1, cliente: cliente},
                url: "{{ route('DetallesIntroduccion') }}",
                type: 'post',

                success: function (Result) {
                    var tbHtml = '';
                    $.each(Result.datos, function (index, value) {
                        //console.log(datos);
                        //! Vamos agregando a nuestra tabla las filas necesarias !/
                        tbHtml += '<tr>' +
                            /*'<td><input type="hidden" name="Id_TipoSalida-' + indicador + '"></td>' +*/
                            '<td>' + count + '</td>' +
                            '<td>' + value.CodigoBarras + '</td>' +
                            '<td>' + value.Nombre_Variedad + '</td>' +
                            '<td>' + value.TipoContenedor + '</td>' +
                            '<td>' + value.CantContenedor + '</td>' +
                            '<td>' + 'Produccion' + '</td>' +
                            '</tr>';
                        count++;
                    });
                    $('#CantidadSalida').val(count - 1);
                    $('#TableCodigosBarras tbody').html(tbHtml);


                },
            });

        });

        $('#Despunte').on('show.bs.modal', function (event) {
            //alert('entro');
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever'); // Extract info from data-* attributes
            //console.log(data);

            let count = 1;
            let FaseActual = data.ID_FaseActual;

            var modal = $(this);
            $('#NumIntroduccionDespunte').val(data.Indentificador);
            $('#FaseActualDespunte').val(data.fase_Actual);
            $('#CantidadDespunte').val(data.CantPlantas);
            $('#TotalPlantasDespunte').val(data.CantPlantas);
            $('#NumIntroduccionEnDespunte').val(data.Indentificador);
            $('#SemanaDespachoCDespunte').val(data.SemanaDespacho);
            $('#SemanaIngresoCDespunte').val(data.SemanaIngreso);
            $('#ID_VariedadCDespunte').val(data.ID_Variedad);
            $('#ID_FaseActualCDespunte').val(data.ID_FaseActual);
            $('#clienteCDespunte').val(data.cliente);


            let Identificador = data.Indentificador;
            let faseactual = data.ID;
            let SemanaDespacho1 = data.SemanaDespacho;
            let cliente = data.cliente;

            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                data: {valorDespunte: Identificador, faseDespunte: faseactual, SemanaDespachoDespunte: SemanaDespacho1, clienteDespunte: cliente},
                url: "{{ route('DetallesDespunte') }}",
                type: 'post',

                success: function (Result) {
                    var tbHtml = '';
                    $.each(Result.datos, function (index, value) {

                        tbHtml += '<tr>' +
                            '<td>' + count + '</td>' +
                            '<td>' + value.CodigoBarras + '</td>' +
                            '<td>' + value.Nombre_Variedad + '</td>' +
                            '<td>' + value.TipoContenedor + '</td>' +
                            '<td>' + value.CantContenedor + '</td>' +
                            '<td>' + 'Produccion' + '</td>' +
                            '</tr>';
                        count++;
                    });
                    $('#CantidadSalidaDespunte').val(count - 1);
                    $('#TableCodigosBarras tbody').html(tbHtml);


                },
            });
        });


        function sumar() {
            var total = 0;
            $(".monto").each(function () {
                if (isNaN(parseFloat($(this).val()))) {
                    total += 0;
                } else {
                    total += parseFloat($(this).val());
                }
            });
            $('#TotalPlantas').val(total);
        }

        function sumarDespunte() {
            var total = 0;
            $(".montoDespunte").each(function () {
                if (isNaN(parseFloat($(this).val()))) {
                    total += 0;
                } else {
                    total += parseFloat($(this).val());
                }
            });
            $('#TotalPlantasDespunte').val(total);
        }

        $(function () {
            $('#Radiosi').click(function () {
                if ($(this).is(":checked")) {
                    $('#DivAdicionales').show();
                    $('#divtabladetalles').hide()
                }
            });
            $('#Radiono').click(function () {
                if ($(this).is(":checked")) {
                    $('#divtabladetalles').show();
                    $('#DivAdicionales').hide();
                    $('#DivAdicional1').hide();
                    $('#DivAdicional2').hide();
                    $('#DivAdicional3').hide();

                }
            });
        });

    </script>
@endsection

