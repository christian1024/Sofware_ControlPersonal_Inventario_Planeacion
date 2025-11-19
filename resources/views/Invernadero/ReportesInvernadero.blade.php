@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">

        <div class="text-center">
            <h2><i class="fa fa-line-chart"></i> Reporte Inventario Invernadero</h2>
        </div>

        <div class="box-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li>
                    <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ReporteEstandar">Reportes Estandar</a>
                </li>
                <li>
                    <a class="nav-link" id="home-tab1" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false" href="#ReporteDinamico">Reporte Dinamico</a>
                </li>
                <li>
                    <a class="nav-link" id="home-tab2" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false" href="#ReporteDinamicoFecha">Reporte Dinamico Fecha</a>
                </li>

            </ul>
            <div class="tab-content">
                <div id="ReporteEstandar" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                        <!-- card tools -->
                        <div class="card-tools">
                            <button type="button" aria-expanded="true" class="btn btn-primary btn-sm " data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus" id="a"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body news">
                        <div class="form-row">

                            <div class="col-lg-3">
                                <label for="" class="control-label">{{ __('Fecha Inicio ') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                <input type="date" name="Fechainial" id="Fechainial" class="labelform" required="required">

                            </div>

                            <div class="col-lg-3">
                                <label for="" class="control-label">{{ __('Fecha Fin ') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                <input type="date" name="FechaFin" id="FechaFin" class="labelform" required="required">
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('DescargaInventarioInvernadero')}}" class="btn btn-success fa fa-cloud-download">
                                    <i data-toggle="tooltip" title="Descargar Inventario Activo"> Descargar Inventario Activo</i>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <form id="ReporteDescartadas" action="{{ route('DescargaInventarioInvernaderoDescartes') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="Fechainialh" id="Fechainialh">
                                    <input type="hidden" name="FechaFinalh" id="FechaFinalh">
                                    <button id="DescargarDescartes" class="btn btn-success fa fa-cloud-download">
                                        <i data-toggle="tooltip" title="Descargar Descartes"> Descargar Descartes </i>
                                    </button>
                                </form>
                            </div>

                        </div>
                        <div class="col-lg-12">
                            <hr>
                        </div>
                        <div class="row row-cols-2">
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card bg-primary text-white ">
                                        <div class="card-body text-center">Tipo Reporte</div>
                                    </div>
                                    <div class="">
                                        <div class="col-lg-12">
                                            <label class="container">
                                                <input type="radio" id="radioentrada" name="radio"> Lectura Entradas
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="container">
                                                <input type="radio" id="radiosalida" name="radio"> Lectura Salidas
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="card callout-info">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center"> CAMPOS DISPONIBLES</div>
                                    </div>
                                    <div class="panel-body form-row" style="display: none" id="diventrada">
                                        <div class="col-lg-3">
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="custom-switch-input" name="lectEntrada" id="CodigovariEntrada"> Codigo Var
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="VariedadEntr"> Variedad
                                                </label>

                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="GeneroEntr"> Genero
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="BarcodeEntr"> Codigo Barras
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="IdentificadorEntr"> Identificador
                                                </label>
                                            </div>
                                            {{-- <div class="col-lg-12">
                                                 <label class="checkbox-inline">
                                                     <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="BreederEntr"> Breeder
                                                 </label>

                                             </div>--}}
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="FaseActualEntr"> Fase Actual
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="ContenedorEntr"> Contenedor
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="CantidadEntr"> Cantidad
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="FechaEntradaEntr"> Fe Entrada
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="SemanaEntradaEntr"> Se Entrada
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="SemanaDespachoEntr"> Se Despacho
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="UbicacionActEntr"> Ubicacion
                                                </label>

                                            </div>

                                        </div>

                                        <div class="col-lg-3">
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="PatinadorEntr"> Patinador
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="OperarioEntr"> Operario
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="RadicadoEntr"> Radicado
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectEntrada" class="custom-switch-input" id="ClienteEntr"> Cliente
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 text-center">
                                            <label class="checkbox-inline">
                                                <h3><input type="checkbox" id="TodosEntrada">Todos</h3>
                                            </label>
                                        </div>

                                        <div class="col-lg-12 text-center">
                                            <form id="Fechas" method="POST" action="{{ route('ReporteEntradaLab') }}">
                                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                                <button id="btnEntradas" type="submit" class="btn btn-primary btn-lg btn-block">Cargar</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="panel-body form-row" style="display: none" id="divsalidad">

                                        <div class="col-lg-3">
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="custom-switch-input" name="lectSalida" id="CodigovariSalida"> Codigo Var
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="VariedadSalida"> Variedad
                                                </label>

                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="GeneroSalida"> Genero
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="BarcodeSalida"> Codigo Barras
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="IdentificadorSalida"> Identificador
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="FaseActualrSalida"> Fase Actual
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="ContenedorSalida"> Contenedor
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="FechaSalida"> Fe Salida
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="SemanaSalida"> Se Salida
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="CantidadSalida"> Cantidad
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="Ubicacion"> Ubicacion
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="PatinadorSalida"> Patinador
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="OperarioSalida"> Operario
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="TipoSalida"> Tipo Salida
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="TipoCancelado"> Tipo Cancelacion
                                                </label>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="lectSalida" class="custom-switch-input" id="SemanaSalida"> Semana Trabajo
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 text-center">
                                            <label class="checkbox-inline">
                                                <h3><input type="checkbox" id="TodosSalida">Todos</h3>
                                            </label>
                                        </div>

                                        <div class="col-lg-12 text-center">
                                            <form id="ReporteSalidas" method="POST" action="{{ route('ReporteSalidaLab') }}">
                                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                                <button id="btnSalidas" type="submit" class="btn btn-primary btn-lg btn-block">Cargar</button>
                                            </form>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div id="ReporteDinamico" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-lg-12 box box-primary">
                        <div class="">
                            <div>
                                <div class="col-lg-12" style="margin-top: 10px">
                                    <div class="">
                                        <div>
                                            <label for="" class="control-label">{{ __('Fecha Inicio ') }}</label>
                                            <input type="date" name="Fechainial" id="FechainialDianmico" class="labelform" required="required">

                                            <label for="" class="control-label">{{ __('Fecha Fin ') }}</label>
                                            <input type="date" name="FechaFin" id="FechaFinDinamico" class="labelform" required="required">

                                            <label for="" class="control-label">{{ __('Variedad') }}</label>
                                            {{--<select class="selectpicker" data-show-subtext="true" name="idVariedad[]" id="idvariedad" data-live-search="true" multiple data-selected-text-format="count > 10" required="required">--}}
                                            <select class="selectpicker" data-show-subtext="true" name="idVariedad[]" id="idvariedad" data-live-search="true" multiple data-actions-box="true" data-selected-text-format="count > 10" required="required">
                                                <option selected="true" value="" disabled="disabled"></option>
                                                @foreach($VariedadesActivas as $VariedadesActiva)
                                                    <option value="{{ $VariedadesActiva->id }}">
                                                        {{ $VariedadesActiva->Codigo }}
                                                        {{ $VariedadesActiva->Nombre_Variedad }}
                                                        {{ $VariedadesActiva->NombreGenero }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            {{--<button id="btnEntradasDinamico" type="button" class="btn btn-success btn-xs btn-block"></button>--}}
                                            <a class="btn btn-success fa fa-sign-out" id="btnEntradasInvDinamico">
                                                <i data-toggle="tooltip" title="Reporte entradas"> Entradas</i>
                                            </a>


                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-12" style="margin-top: -10px;">
                                    <hr>
                                </div>
                                <div class="col-lg-12 Entrada">
                                    <div id="ReporteDinamicoEntradas"></div>
                                    <div id="loading" style="position: absolute; left: 50%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="ReporteDinamicoFecha" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-lg-12 box box-primary">
                        <div class="">
                            <div>
                                <div class="col-lg-12" style="margin-top: 10px">

                                    <div class="">
                                        <div>
                                            <label for="" class="control-label">{{ __('Fecha Inicio ') }}</label>
                                            <input type="date" name="Fechainial" id="FechainialDianmicoF" class="labelform" required="required">

                                            <label for="" class="control-label">{{ __('Fecha Fin ') }}</label>
                                            <input type="date" name="FechaFin" id="FechaFinDinamicoF" class="labelform" required="required">

                                            <a class="btn btn-success fa fa-sign-out" id="btnEntradasInvDinamicof">
                                                <i data-toggle="tooltip" title="Reporte entradas"> Entradas</i>
                                            </a>

                                            <a class="btn btn-success fa fa-sign-out" id="btnSalidasInvDinamicof">
                                                <i data-toggle="tooltip" title="Reporte Salidas"> Salidas</i>
                                            </a>

                                            <a class="btn btn-success fa fa-sign-out" id="btnDescartasInvDinamicof">
                                                <i data-toggle="tooltip" title="Reporte Descartes"> Descartes</i>
                                            </a>

                                            <a class="btn btn-success fa fa-sign-out" id="btnDescartesToInvDinamicof">
                                                <i data-toggle="tooltip" title="Reporte Descartes Total"> Descartes Total</i>
                                            </a>

                                            <a class="btn btn-success fa fa-sign-out" id="btnAlistamientoInvDinamicof">
                                                <i data-toggle="tooltip" title="Reporte Alistamiento"> Alistamiento</i>
                                            </a>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-12" style="margin-top: -10px;">
                                    <hr>
                                </div>
                                <div class="col-lg-12 Entrada">
                                    <div id="ReporteDinamicoEntradasF" style="display: none"></div>
                                    <div id="ReporteDinamicoSalidasF" style="display: none"></div>
                                    <div id="ReporteDinamicoDescarteF" style="display: none"></div>
                                    <div id="ReporteDinamicoDescarteTF" style="display: none"></div>
                                    <div id="ReporteDinamicoAlistamientoF" style="display: none"></div>
                                    <div id="loading" style="position: absolute; left: 50%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="box-body" style="display: none" id="tablaReporteEntrada">
                <div class="table table-responsive">
                    <table id="TableReportEntrada" class="display nowrap table table-hover cell-border" style="width:100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>Codigo Variedad</th>
                            <th>Genero</th>
                            <th>Variedad</th>
                            <th>Codigo Barras</th>
                            <th>Identificador</th>
                            {{--<th>Breeder</th>--}}
                            <th>Fase</th>
                            <th>Contenedor</th>
                            <th>Fecha Ingreso</th>
                            <th>Semana Ingreso</th>
                            <th>Semana Despacho</th>
                            <th>Ubicacion Actual</th>
                            <th># PLantas</th>
                            <th>Patinador</th>
                            <th>Operario</th>
                            <th>Cliente</th>


                            {{-- <th>Radicado</th>
                             --}}
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="box-body" style="display: none" id="tablaReporteSalida">
                <div class="box box-body table-responsive">
                    <table id="TablaReporteSalidas" class="display nowrap table table-hover cell-border" style="width:100%">
                        <thead class="thead-light">
                        <tr>
                            <th>Codigo Variedad</th>
                            <th>Variedad</th>
                            <th>Genero</th>
                            <th>Codigo Barras</th>
                            <th>Identificador</th>
                            <th>Fase</th>
                            <th>Contenedor</th>
                            <th>Fecha Salida</th>
                            <th>Semana Salida</th>
                            <th>Semana Trabajada</th>
                            <th># PLantas</th>
                            <th>Patinador</th>
                            <th>Operario</th>
                            <th>Tipo Salida</th>
                            <th>Causal Salida</th>
                            <th>Cliente</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>

        </div>
    </div>

    <div id="loader" class="text-center" style="display: none">
        <div class="spinner-grow text-primary" role="status">
        </div>
        <div class="spinner-grow text-secondary" role="status">
        </div>
        <div class="spinner-grow text-success" role="status">
        </div>
        <div class="spinner-grow text-danger" role="status">
        </div>
        <div class="spinner-grow text-warning" role="status">
        </div>
        <div class="spinner-grow text-info" role="status">
        </div>
        <div class="spinner-grow text-light" role="status">
        </div>
        <div class="spinner-grow text-dark" role="status">
        </div>
    </div>
    <script>

        //$('#loading').hide();
        //$('#ReporteDinamicoEntradas').hide();
        $('#ReporteDinamicoSalidas').hide();
        window.onload = function () {
            var fecha = new Date(); //Fecha actual
            var mes = fecha.getMonth() + 1; //obteniendo mes
            var dia = fecha.getDate(); //obteniendo dia
            var ano = fecha.getFullYear(); //obteniendo año
            if (dia < 10)
                dia = '0' + dia; //agrega cero si el menor de 10
            if (mes < 10)
                mes = '0' + mes //agrega cero si el menor de 10
            document.getElementById('FechaFin').value = ano + "-" + mes + "-" + dia;
        };


        $(function () {
            $("#radioentrada").click(function () {
                if ($(this).is(":checked")) {
                    $("#diventrada").show();
                    $("#divsalidad").hide();
                    $("#divajuste").hide();
                    $("#diventradasalida").hide();
                    $("#diventradaajuste").hide();
                    $("#divsalidaajuste").hide();
                    $("#diventradasalidaajuste").hide();
                }
            });
            $("#radiosalida").click(function () {
                if ($(this).is(":checked")) {
                    $("#diventrada").hide();
                    $("#divsalidad").show();
                    $("#divajuste").hide();
                    $("#diventradasalida").hide();
                    $("#diventradaajuste").hide();
                    $("#divsalidaajuste").hide();
                    $("#diventradasalidaajuste").hide();
                }
            });
            $("#radioajuste").click(function () {
                if ($(this).is(":checked")) {
                    $("#diventrada").hide();
                    $("#divsalidad").hide();
                    $("#divajuste").show();
                    $("#diventradasalida").hide();
                    $("#diventradaajuste").hide();
                    $("#divsalidaajuste").hide();
                    $("#diventradasalidaajuste").hide();

                }
            });

        });

        $("#TodosEntrada").on("click", function () {

            if ($('#TodosEntrada').prop('checked')) {
                $("input[name='lectEntrada']:checkbox").prop('checked', true);
            } else {
                $("input[name='lectEntrada']:checkbox").prop('checked', false);
            }
        });

        $("#TodosSalida").on("click", function () {

            if ($('#TodosSalida').prop('checked')) {
                $("input[name='lectSalida']:checkbox").prop('checked', true);
            } else {
                $("input[name='lectSalida']:checkbox").prop('checked', false);
            }
        });

        $(document).ready(function () {
            let token = $('#token').val();
            $("#btnEntradas").on("click", function () {
                $('#tablaReporteEntrada').hide(); //muestro mediante id
                $('#tablaReporteSalida').hide(); //muestro mediante id
                $('#a').click();
                $('.news').css('display', 'none');
            });
            $("#btnSalidas").on("click", function () {
                $('#tablaReporteSalida').show(); //muestro mediante id
                $('#tablaReporteEntrada').hide(); //muestro mediante id$
                $('#a').click();
                $('.news').css('display', 'none');

            });
            $('#home-tab1, #home-tab2').click(function () {
                $('#tablaReporteEntrada').hide();
                $('#tablaReporteSalida').hide(); //muestro mediante id
                $('#loader').hide();
            });

            let ReporEntradas = $("#Fechas").submit(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let FechaInicial = $('#Fechainial').val();
                let FechaFinal = $('#FechaFin').val();
                let dataform = {FechaInicial, FechaFinal};

                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                    $('#tablaReporteEntrada').hide(); //muestro mediante id$
                    $('#tablaReporteSalida').hide(); //muestro mediante id
                } else {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: dataform,
                        url: '{{ route('ReporteEntradaInvernadero') }}',
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                            $('#loader').show();
                        },
                        success: function (Result) {
                            //console.log(Result);
                            var TableRepor = $('#TableReportEntrada').DataTable({
                                "info": true,
                                dom: 'Bfrtip',
                                destroy: true,
                                paging: true,
                                //columns: Result.data,
                                data: Result.data,
                                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_  ",
                                    "search": "Buscar:",
                                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                                    "Previous": "Anterior",
                                },

                                columns: [
                                    {data: 'Codigo'},
                                    {data: 'NombreGenero'},
                                    {data: 'Nombre_Variedad'},
                                    {data: 'CodigoBarras'},
                                    {data: 'Indentificador'},
                                    {data: 'NombreFase'},
                                    {data: 'TipoContenedor'},
                                    {data: 'created_at'},
                                    {data: 'SemanaEntrada'},
                                    {data: 'SemanaDespacho'},
                                    {data: 'UbicacionActual'},
                                    {data: 'Plantas'},
                                    {data: 'NombrePatinador'},
                                    {data: 'NombreOperario'},
                                    {data: 'NombreCliente'},

                                ],
                                aoColumnDefs: [
                                    {
                                        "visible": ($('#CodigovariEntrada').prop('checked')) ? true : false,
                                        "aTargets": [0]
                                    },
                                    {
                                        "visible": ($('#VariedadEntr').prop('checked')) ? true : false,
                                        "aTargets": [1]
                                    },
                                    {
                                        "visible": ($('#GeneroEntr').prop('checked')) ? true : false,
                                        "aTargets": [2]
                                    },
                                    {
                                        "visible": ($('#BarcodeEntr').prop('checked')) ? true : false,
                                        "aTargets": [3]
                                    },
                                    {
                                        "visible": ($('#IdentificadorEntr').prop('checked')) ? true : false,
                                        "aTargets": [4]
                                    },
                                    /*{
                                        "visible": ($('#BreederEntr').prop('checked')) ? true : false,
                                        "aTargets": [5]
                                    },*/
                                    {
                                        "visible": ($('#FaseActualEntr').prop('checked')) ? true : false,
                                        "aTargets": [5]
                                    },
                                    {
                                        "visible": ($('#ContenedorEntr').prop('checked')) ? true : false,
                                        "aTargets": [6]
                                    },
                                    {
                                        "visible": ($('#FechaEntradaEntr').prop('checked')) ? true : false,
                                        "aTargets": [7]
                                    },
                                    {
                                        "visible": ($('#SemanaEntradaEntr').prop('checked')) ? true : false,
                                        "aTargets": [8]
                                    },
                                    {
                                        "visible": ($('#SemanaDespachoEntr').prop('checked')) ? true : false,
                                        "aTargets": [9]
                                    },
                                    {
                                        "visible": ($('#UbicacionActEntr').prop('checked')) ? true : false,
                                        "aTargets": [10]
                                    },
                                    {
                                        "visible": ($('#CantidadEntr').prop('checked')) ? true : false,
                                        "aTargets": [11]
                                    },
                                    {
                                        "visible": ($('#PatinadorEntr').prop('checked')) ? true : false,
                                        "aTargets": [12]
                                    },
                                    {
                                        "visible": ($('#OperarioEntr').prop('checked')) ? true : false,
                                        "aTargets": [13]
                                    },
                                    {
                                        "visible": ($('#ClienteEntr').prop('checked')) ? true : false,
                                        "aTargets": [14]
                                    },

                                ],
                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                                        titleAttr: 'Excel',
                                        messageTop: 'Fecha incial ' + FechaInicial + '  Fecha Final ' + FechaFinal
                                    },
                                ],
                            });
                        },
                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                            $('#loader').hide();
                            $('#tablaReporteEntrada').show();
                        },
                    });
                }
            });

            let ReporSalidas = $("#ReporteSalidas").submit(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let FechaInicial = $('#Fechainial').val();
                let FechaFinal = $('#FechaFin').val();
                let dataform = {FechaInicial, FechaFinal};

                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                    $('#tablaReporteEntrada').hide(); //muestro mediante id$
                    $('#tablaReporteSalida').hide(); //muestro mediante id
                } else {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: dataform,
                        url: '{{ route('ReporteSalidaInvernadero') }}',
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                            $('#loader').show();
                        },
                        success: function (Result) {
                            //console.log(Result);
                            var TableRepor = $('#TablaReporteSalidas').DataTable({
                                "info": true,
                                dom: 'Bfrtip',
                                destroy: true,
                                paging: true,
                                //columns: Result.data,
                                data: Result.data,
                                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_  ",
                                    "search": "Buscar:",
                                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                                    "Previous": "Anterior",
                                },

                                columns: [
                                    {data: 'Codigo'},
                                    {data: 'Nombre_Variedad'},
                                    {data: 'NombreGenero'},
                                    {data: 'CodigoBarras'},
                                    {data: 'Indentificador'},
                                    {data: 'NombreFase'},
                                    {data: 'TipoContenedor'},
                                    {data: 'created_at'},
                                    {data: 'SemanaSalida'},
                                    {data: 'SemanaDespacho'},
                                    {data: 'Plantas'},
                                    {data: 'NombrePatinador'},
                                    {data: 'NombreOperario'},
                                    {data: 'TipoSalida'},
                                    {data: 'CausalDescarte'},
                                    {data: 'NombreCliente'},


                                ],
                                aoColumnDefs: [
                                    {
                                        "visible": ($('#CodigovariSalida').prop('checked')) ? true : false,
                                        "aTargets": [0]
                                    },
                                    {
                                        "visible": ($('#VariedadSalida').prop('checked')) ? true : false,
                                        "aTargets": [1]
                                    },
                                    {
                                        "visible": ($('#GeneroSalida').prop('checked')) ? true : false,
                                        "aTargets": [2]
                                    },
                                    {
                                        "visible": ($('#BarcodeSalida').prop('checked')) ? true : false,
                                        "aTargets": [3]
                                    },
                                    {
                                        "visible": ($('#IdentificadorSalida').prop('checked')) ? true : false,
                                        "aTargets": [4]
                                    },
                                    /*{
                                        "visible": ($('#BreederEntr').prop('checked')) ? true : false,
                                        "aTargets": [5]
                                    },*/
                                    {
                                        "visible": ($('#FaseActualrSalida').prop('checked')) ? true : false,
                                        "aTargets": [5]
                                    },
                                    {
                                        "visible": ($('#ContenedorSalida').prop('checked')) ? true : false,
                                        "aTargets": [6]
                                    },
                                    {
                                        "visible": ($('#FechaSalida').prop('checked')) ? true : false,
                                        "aTargets": [7]
                                    },
                                    {
                                        "visible": ($('#SemanaSalida').prop('checked')) ? true : false,
                                        "aTargets": [8]
                                    },
                                    {
                                        "visible": ($('#CantidadSalida').prop('checked')) ? true : false,
                                        "aTargets": [9]
                                    },
                                    {
                                        "visible": ($('#PatinadorSalida').prop('checked')) ? true : false,
                                        "aTargets": [10]
                                    },
                                    {
                                        "visible": ($('#OperarioSalida').prop('checked')) ? true : false,
                                        "aTargets": [11]
                                    },
                                    {
                                        "visible": ($('#TipoSalida').prop('checked')) ? true : false,
                                        "aTargets": [12]
                                    },
                                    {
                                        "visible": ($('#TipoCancelado').prop('checked')) ? true : false,
                                        "aTargets": [13]
                                    },
                                    {
                                        "visible": ($('#SemanaSalida').prop('checked')) ? true : false,
                                        "aTargets": [14]
                                    },

                                ],
                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                                        titleAttr: 'Excel',
                                        messageTop: 'Fecha incial ' + FechaInicial + '  Fecha Final ' + FechaFinal
                                    },
                                ],
                            });
                        },
                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                            $('#loader').hide();
                        },
                    });
                }
            });

            $("#DescargarDescartes").click(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let FechaInicial = $('#Fechainial').val();
                let FechaFinal = $('#FechaFin').val();
                let dataform = {FechaInicial, FechaFinal};


                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                } else {

                    $('#Fechainialh').val(FechaInicial);
                    $('#FechaFinalh').val(FechaFinal);
                    $('#ReporteDescartadas').submit();
                    return false;
                }
            });


            let ReporteDinamico = $("#btnEntradasInvDinamico").click(function (event) {
                event.preventDefault();

                let token = $('#token').val();
                let FechaInicial = $('#FechainialDianmico').val();
                let FechaFinal = $('#FechaFinDinamico').val();
                let IDVariedad = $('#idvariedad').val();
                let dataform = {FechaInicial, FechaFinal};


                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                } else {

                    var derivers = $.pivotUtilities.derivers;
                    var renderers = $.extend($.pivotUtilities.renderers,
                        $.pivotUtilities.plotly_renderers);
                    $('#loading').html('<img style="text-align: center" src="https://mipropiedadhorizontal.com.co/phwebapp2/public/gif/ajax-loading-c2.gif"><br>' +
                        '<label style="text-align: justify-all">Cargando</label>');
                    //$.getJSON("http://visualmaster.com.co/umaco/wappumaco/public/general/datosCuboVentas", function(data) {
                    $.ajax({
                        data: {FechaInicial: FechaInicial, FechaFinal: FechaFinal, IDVariedad: IDVariedad},
                        url: '/Invernadero/Reportes/ReporteEntradaInvDinamico/' + FechaInicial + '/' + FechaFinal + '/' + IDVariedad + '/Get',
                        type: 'get',

                        success: function (Result) {
                            $("#ReporteDinamicoEntradas").pivotUI(Result.data,
                                {renderers: renderers},
                                false, "es"
                            );
                            $('#loading').hide();


                        },
                    });
                }
            });
            /*tercer tag*/

            let ReportEntradaDinamicoF = $("#btnEntradasInvDinamicof").click(function (event) {
                event.preventDefault();

                let token = $('#token').val();
                let FechaInicial = $('#FechainialDianmicoF').val();
                let FechaFinal = $('#FechaFinDinamicoF').val();

                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                } else {

                    var derivers = $.pivotUtilities.derivers;
                    var renderers = $.extend($.pivotUtilities.renderers,
                        $.pivotUtilities.plotly_renderers);
                    $('#loading').html('<img style="text-align: center" src="https://mipropiedadhorizontal.com.co/phwebapp2/public/gif/ajax-loading-c2.gif"><br>' +
                        '<label style="text-align: justify-all">Cargando</label>');
                    //$.getJSON("http://visualmaster.com.co/umaco/wappumaco/public/general/datosCuboVentas", function(data) {
                    $.ajax({
                        data: {FechaInicial: FechaInicial, FechaFinal: FechaFinal},
                        url: '/Invernadero/Reportes/ReporteEntradaInvDinamicoF/' + FechaInicial + '/' + FechaFinal + '/Get',
                        type: 'get',

                        success: function (Result) {
                            $("#ReporteDinamicoEntradasF").pivotUI(Result.data,
                                {renderers: renderers},
                                false, "es"
                            );
                            $('#loading').hide();
                            $('#ReporteDinamicoSalidasF').hide();
                            $('#ReporteDinamicoDescarteF').hide();
                            $('#ReporteDinamicoDescarteTF').hide();
                            $('#ReporteDinamicoAlistamientoF').hide();
                            $('#ReporteDinamicoEntradasF').show();


                        },
                    });
                }
            });

            let ReporteDinamicoSalidasF = $("#btnSalidasInvDinamicof").click(function (event) {
                event.preventDefault();

                let token = $('#token').val();
                let FechaInicial = $('#FechainialDianmicoF').val();
                let FechaFinal = $('#FechaFinDinamicoF').val();

                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                } else {

                    var derivers = $.pivotUtilities.derivers;
                    var renderers = $.extend($.pivotUtilities.renderers,
                        $.pivotUtilities.plotly_renderers);
                    $('#loading').html('<img style="text-align: center" src="https://mipropiedadhorizontal.com.co/phwebapp2/public/gif/ajax-loading-c2.gif"><br>' +
                        '<label style="text-align: justify-all">Cargando</label>');
                    //$.getJSON("http://visualmaster.com.co/umaco/wappumaco/public/general/datosCuboVentas", function(data) {
                    $.ajax({
                        data: {FechaInicial: FechaInicial, FechaFinal: FechaFinal},
                        url: '/Invernadero/Reportes/ReporteDinamicoSalidasF/' + FechaInicial + '/' + FechaFinal + '/Get',
                        type: 'get',

                        success: function (Result) {
                            $("#ReporteDinamicoSalidasF").pivotUI(Result.data,
                                {renderers: renderers},
                                false, "es"
                            );
                            $('#loading').hide();
                            $('#ReporteDinamicoDescarteF').hide();
                            $('#ReporteDinamicoDescarteTF').hide();
                            $('#ReporteDinamicoAlistamientoF').hide();
                            $('#ReporteDinamicoEntradasF').hide();
                            $('#ReporteDinamicoSalidasF').show();


                        },
                    });
                }
            });

            let ReporteDinamicoDescarteF = $("#btnDescartasInvDinamicof").click(function (event) {
                event.preventDefault();

                let token = $('#token').val();
                let FechaInicial = $('#FechainialDianmicoF').val();
                let FechaFinal = $('#FechaFinDinamicoF').val();

                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                } else {

                    var derivers = $.pivotUtilities.derivers;
                    var renderers = $.extend($.pivotUtilities.renderers,
                        $.pivotUtilities.plotly_renderers);
                    $('#loading').html('<img style="text-align: center" src="https://mipropiedadhorizontal.com.co/phwebapp2/public/gif/ajax-loading-c2.gif"><br>' +
                        '<label style="text-align: justify-all">Cargando</label>');
                    //$.getJSON("http://visualmaster.com.co/umaco/wappumaco/public/general/datosCuboVentas", function(data) {
                    $.ajax({
                        data: {FechaInicial: FechaInicial, FechaFinal: FechaFinal},
                        url: '/Invernadero/Reportes/ReporteDinamicoDescarteF/' + FechaInicial + '/' + FechaFinal + '/Get',
                        type: 'get',

                        success: function (Result) {
                            $("#ReporteDinamicoDescarteF").pivotUI(Result.data,
                                {renderers: renderers},
                                false, "es"
                            );
                            $('#loading').hide();
                            $('#ReporteDinamicoSalidasF').hide();
                            $('#ReporteDinamicoDescarteTF').hide();
                            $('#ReporteDinamicoAlistamientoF').hide();
                            $('#ReporteDinamicoEntradasF').hide();
                            $('#ReporteDinamicoDescarteF').show();
                        },
                    });
                }
            });

            let ReporteDinamicoDescarteTF = $("#btnDescartesToInvDinamicof").click(function (event) {
                event.preventDefault();

                let token = $('#token').val();
                let FechaInicial = $('#FechainialDianmicoF').val();
                let FechaFinal = $('#FechaFinDinamicoF').val();

                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                } else {

                    var derivers = $.pivotUtilities.derivers;
                    var renderers = $.extend($.pivotUtilities.renderers,
                        $.pivotUtilities.plotly_renderers);
                    $('#loading').html('<img style="text-align: center" src="https://mipropiedadhorizontal.com.co/phwebapp2/public/gif/ajax-loading-c2.gif"><br>' +
                        '<label style="text-align: justify-all">Cargando</label>');
                    //$.getJSON("http://visualmaster.com.co/umaco/wappumaco/public/general/datosCuboVentas", function(data) {
                    $.ajax({
                        data: {FechaInicial: FechaInicial, FechaFinal: FechaFinal},
                        url: '/Invernadero/Reportes/ReporteDinamicoDescarteTF/' + FechaInicial + '/' + FechaFinal + '/Get',
                        type: 'get',

                        success: function (Result) {
                            $("#ReporteDinamicoDescarteTF").pivotUI(Result.data,
                                {renderers: renderers},
                                false, "es"
                            );
                            $('#loading').hide();
                            $('#ReporteDinamicoSalidasF').hide();
                            $('#ReporteDinamicoDescarteF').hide();
                            $('#ReporteDinamicoAlistamientoF').hide();
                            $('#ReporteDinamicoEntradasF').hide();
                            $('#ReporteDinamicoDescarteTF').show();
                        },
                    });
                }
            });

            let ReporteDinamicoAlistamientoF = $("#btnAlistamientoInvDinamicof").click(function (event) {
                event.preventDefault();

                let token = $('#token').val();
                let FechaInicial = $('#FechainialDianmicoF').val();
                let FechaFinal = $('#FechaFinDinamicoF').val();

                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                } else {

                    var derivers = $.pivotUtilities.derivers;
                    var renderers = $.extend($.pivotUtilities.renderers,
                        $.pivotUtilities.plotly_renderers);
                    $('#loading').html('<img style="text-align: center" src="https://mipropiedadhorizontal.com.co/phwebapp2/public/gif/ajax-loading-c2.gif"><br>' +
                        '<label style="text-align: justify-all">Cargando</label>');
                    //$.getJSON("http://visualmaster.com.co/umaco/wappumaco/public/general/datosCuboVentas", function(data) {
                    $.ajax({
                        data: {FechaInicial: FechaInicial, FechaFinal: FechaFinal},
                        url: '/Invernadero/Reportes/ReporteDinamicoAlistamientoF/' + FechaInicial + '/' + FechaFinal + '/Get',
                        type: 'get',

                        success: function (Result) {
                            $("#ReporteDinamicoAlistamientoF").pivotUI(Result.data,
                                {renderers: renderers},
                                false, "es"
                            );
                            $('#loading').hide();
                            $('#ReporteDinamicoSalidasF').hide();
                            $('#ReporteDinamicoDescarteF').hide();
                            $('#ReporteDinamicoDescarteTF').hide();
                            $('#ReporteDinamicoEntradasF').hide();
                            $('#ReporteDinamicoAlistamientoF').show();
                        },
                    });
                }
            });
        });
    </script>
@endsection
