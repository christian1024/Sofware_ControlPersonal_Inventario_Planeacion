@extends('layouts.Principal')
@section('contenidoPrincipal')
    {{--<script type="text/javascript" async="" src="https://www.google-analytics.com/plugins/ua/linkid.js"></script>--}}
    {{--<script async="" src="https://www.google-analytics.com/analytics.js"></script>--}}
    {{--<script src="https://code.jquery.com/jquery.min.js"></script>--}}

    <div class="card row">
        <div style="display: flex; justify-content:center; align-items: flex-end;" class="text-center">
            <h2><i class="fa fa-line-chart"></i> Reporte Inventario Propagación</h2>
        </div>

        <div class="box-body">

            <ul class="nav nav-tabs">
                <li><a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ReporteEstandar">Reportes Estandar</a></li>
                <li><a class="nav-link" id="home-tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ReporteDinamicoFecha">Reporte Dinamico </a></li>
                <li><a class="nav-link" id="home-tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ReporteArqueo">Reporte Arqueo </a></li>

            </ul>
            <div class="tab-content">
                <div id="ReporteEstandar" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab" {{--style="background-color: #1d68a7"--}}>

                    <div class="card card-body">
                        <div class="form-row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="" class="control-label">{{ __('Semana ') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                    <input type="week" name="Fechainial" id="Fechainial" class="labelform" required="required">

                                    {{--  <label for="" class="control-label">{{ __('Fecha Fin ') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                      <input type="date" name="FechaFin" id="FechaFin" class="labelform" required="required">--}}
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <a class="btn btn-success" id="btnEntradaEstandar" href="">
                                    <i data-toggle="tooltip" title="Reporte entradas"> Entradas</i>
                                </a>
                                <a class="btn btn-success" id="btnSalidasEstandar" href="">
                                    <i data-toggle="tooltip" title="Reporte Salidas"> Salidas</i>
                                </a>

                                <a class="btn btn-success" id="btnSalidasDescartes" href="">
                                    <i data-toggle="tooltip" title="Reporte Descartes"> Descartes</i>
                                </a>


                            </div>
                            <div class="col-lg-5">
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Reportes Descargables
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" id="btnSalidasEstandar" href="{{ route('ExportInventarioTotal')}}">
                                            <i data-toggle="tooltip" title="Exportar Inventario"> Descargar Inv Total por bandeja</i>
                                        </a>

                                        <a class="dropdown-item" id="btnSalidasEstandar" href="{{ route('ExportInventarioAgrupado')}}">
                                            <i data-toggle="tooltip" title="Exportar Inventario"> Descargar Entradas por PlotID</i>
                                        </a>

                                        <a class="dropdown-item" id="btnSalidasEstandar" href="{{ route('ExportSalidasPlot') }}">
                                            <i data-toggle="tooltip" title="Exportar Inventario"> Descargar Salidas Total por Plot</i>
                                        </a>
                                        <a class="dropdown-item" id="btnSalidasEstandar" href="{{ route('ExportInventarioDescartado') }}">
                                            <i data-toggle="tooltip" title="Exportar Inventario"> Descargar Descartes Total por PlotID</i>
                                        </a>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div id="ReporteDinamicoFecha" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-lg-12 card card-primary">
                        <div class="">
                            <div class="form-row" style="margin-top: 10px">
                                <div class="col-lg-3">
                                    <label for="" class="control-label">{{ __('Fecha Inicio ') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                    <input type="week" name="Fechainial" id="Fechainiald" class="labelform" required="required">
                                </div>

                                {{-- <div class="col-lg-2">
                                     <label for="" class="control-label">{{ __('Fecha Fin ') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                     <input type="date" name="FechaFin" id="FechaFind" class="labelform" required="required">
                                 </div>--}}

                                <div class="col-lg-7">
                                    <a class="btn btn-success fa fa-sign-out" id="btnEntradasDinamico">
                                        <i data-toggle="tooltip" title="Reporte entradas"> Entradas</i>
                                    </a>
                                    {{-- <a class="btn btn-success fa fa-sign-out" id="btnSalidasEstandar">
                                         <i data-toggle="tooltip" title="Reporte Salidas"> Salidas</i>
                                     </a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" ID="tablasdinamicasConte" style="display: none">
                        <div class="box box-default Entrada">
                            <div id="ReporteDinamicoEntradas" style="display: none"></div>
                            <div id="ReporteDinamicoSalidas" style="display: none"></div>
                        </div>
                    </div>
                </div>

                <div id="ReporteArqueo" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">

                    <div class="card card-body">
                        <button class="btn btn-danger" id="btnLimpiarTables">Iniciar Arqueo</button>
                    </div>

                    <div class="card card-body">
                        <div class="box box-body table-responsive">
                            <table id="TableReporteArqueo" class="table table-bordered table-hover text-nowrap">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">PlotId</th>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Variedad</th>
                                    <th scope="col">Ubicacion Arqueo</th>
                                    <th scope="col">Ubicacion Entrada</th>
                                    <th scope="col">Cantidad Bandejas</th>
                                    <th scope="col">Cantidad Plantas</th>
                                    <th scope="col">Observación</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($Arqueo as $ar)
                                    <tr>
                                        <td> {{ $ar->PlotId }}</td>
                                        <td> {{ $ar->CodigoIntegracion }}</td>
                                        <td> {{ $ar->Nombre_Variedad }}</td>
                                        <td> {{ $ar->Ubicacion_Arqueo }}</td>
                                        <td> {{ $ar->ubicacionentrada }}</td>
                                        <td> {{ $ar->CantidadBandejas }}</td>
                                        <td> {{ $ar->plantas }}</td>
                                        @if($ar->comentario == 'ok')
                                            @if($ar->Ubicacion_Arqueo == $ar->ubicacionentrada )
                                                <td> En la misma Ubicación</td>
                                            @else
                                                <td> En diferente Ubicación</td>
                                            @endif
                                        @else
                                            <td> {{ $ar->comentario }}</td>
                                    @endif

                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="container-fluid contenedor">
            <div class="box-body" style="display: none" id="tablaReporteEntrada">
                <div class="text-center">
                    <h1 style="color: black">Reporte Entrada</h1>
                </div>
                <div class="box box-body table-responsive">
                    <table id="TableReportEntrada" class="table table-bordered table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Nombre_Variedad</th>
                            <th>NombreGenero</th>
                            <th>PlotIDNuevo</th>
                            <th>CodigoIntegracion</th>
                            <th>Plantas Programadas</th>
                            <th>Plantas Ingresadas</th>
                            <th>Plantas Actuales</th>
                            <th>Ubicación</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="box-body" style="display: none" id="tablaReporteSalida">
                <div class="text-center">
                    <h1 style="color: black">Reporte Salida</h1>
                </div>
                <div class="box box-body table-responsive">
                    <table id="TablaReporteSalidas" class="table table-bordered table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Variedad</th>
                            <th>Genero</th>
                            <th>PlotIDNuevo</th>
                            <th>Codigo Integracion</th>
                            <th>Semana Despacho</th>
                            <th>Semana Salida</th>
                            <th>Plantas</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>

            <div class="box-body" style="display: none" id="tablaReporteDescarte">
                <div class="text-center">
                    <h1 style="color: black">Reporte Descarte</h1>
                </div>
                <div class="box box-body table-responsive">
                    <table id="TablaReporteDescartes" class="table table-bordered table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Variedad</th>
                            <th>Genero</th>
                            <th>PlotIDNuevo</th>
                            <th>Semana Siembra</th>
                            <th>Causal Descarte</th>
                            <th>Total Plantas Descartadas</th>
                            <th>Semana Descarte</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>


            <div class="box-body" style="display: none" id="tablaReporteDevolucion">
                <div class="box box-body table-responsive">
                    <table id="TablaDevoluciones" class="table table-bordered table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Variedad</th>
                            <th>Causal</th>
                            <th>Codigo</th>
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
    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

    <script>

        $(document).ready(function () {

            $('#TableReporteArqueo').DataTable({
                "info": true,
                dom: "Bfrtip",
                paging: true,
                buttons: [
                    'excel'
                ],
                "language": {
                    "search": "Buscar:",
                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });


            $('#home-tab1').click(function () {
                $('#tablaReporteEntrada').hide(); //muestro mediante id$
                $('#tablaReporteSalida').hide(); //muestro mediante id
                $('#tablaReporteDescarte').hide(); //muestro mediante id
                $('#tablaReporteDevolucion').hide(); //muestro mediante id

            });

            let token = $('#token').val();

            $("#btnEntradaEstandar").click(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let FechaInicial = $('#Fechainial').val();
                //let FechaFinal = $('#FechaFin').val();
                let dataform = {FechaInicial/*, FechaFinal*/};

                if (FechaInicial === '' /*|| FechaFinal === ''*/) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                    $('#tablaReporteEntrada').hide(); //muestro mediante id$
                    $('#tablaReporteSalida').hide(); //muestro mediante id
                    $('#tablaReporteDescarte').hide(); //muestro mediante id
                    $('#tablaReporteDevolucion').hide(); //muestro mediante id
                } else {
                    $('#tablaReporteEntrada').show(); //muestro mediante id$
                    $('#tablaReporteSalida').hide(); //muestro mediante id
                    $('#tablaReporteDevolucion').hide(); //muestro mediante id
                    $('#tablaReporteDescarte').hide(); //muestro mediante id
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: dataform,
                        url: '{{ route('ReporteEntradaPropagacionEsta') }}',
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
                                data: Result.data,
                                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_  ",
                                    "search": "Buscar:",
                                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                                    "Previous": "Anterior",
                                },
                                columns: [
                                    {data: 'Nombre_Variedad'},
                                    {data: 'NombreGenero'},
                                    {data: 'PlotIDNuevo'},
                                    {data: 'CodigoIntegracion'},
                                    {data: 'Programadas'},
                                    {data: 'Ingresadas'},
                                    {data: 'actuales'},
                                    {data: 'Ubicacion'},

                                ],
                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                                        titleAttr: 'Excel',
                                        messageTop: 'Semana ' + FechaInicial
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

            $("#btnSalidasEstandar").click(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let FechaInicial = $('#Fechainial').val();
                /*let FechaFinal = $('#FechaFin').val();*/
                let dataform = {FechaInicial/*, FechaFinal*/};

                if (FechaInicial === '' /*|| FechaFinal === ''*/) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Semana',
                    });
                    $('#tablaReporteEntrada').hide(); //muestro mediante id$
                    $('#tablaReporteSalida').hide(); //muestro mediante
                    $('#tablaReporteDescarte').hide(); //muestro mediante id
                    $('#tablaReporteDevolucion').hide(); //muestro mediante id
                } else {
                    $('#tablaReporteSalida').show(); //muestro mediante id$
                    $('#tablaReporteEntrada').hide(); //muestro mediante id
                    $('#tablaReporteDescarte').hide(); //muestro mediante id
                    $('#tablaReporteDevolucion').hide(); //muestro mediante id
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: dataform,
                        url: '{{ route('ReporteSalidaPropagacionEsta') }}',
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
                                data: Result.data,
                                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_  ",
                                    "search": "Buscar:",
                                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                                    "Previous": "Anterior",
                                },

                                columns: [
                                    {data: 'Nombre_Variedad'},
                                    {data: 'NombreGenero'},
                                    {data: 'PlotIDNuevo'},
                                    {data: 'CodigoIntegracion'},
                                    {data: 'SemaDespacho'},
                                    {data: 'SemanaLectura'},
                                    {data: 'CantPlantas'}
                                ],
                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                                        titleAttr: 'Excel',
                                        messageTop: 'Semana ' + FechaInicial /*+ '  Fecha Final ' + FechaFinal*/
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

            $("#btnSalidasDescartes").click(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let FechaInicial = $('#Fechainial').val();
                let FechaFinal = $('#FechaFin').val();
                let dataform = {FechaInicial/*, FechaFinal*/};

                if (FechaInicial === '' /*|| FechaFinal === ''*/) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                    $('#tablaReporteEntrada').hide(); //muestro mediante id$
                    $('#tablaReporteSalida').hide(); //muestro mediante id
                    $('#tablaReporteDescarte').hide(); //muestro mediante id
                    $('#tablaReporteDevolucion').hide(); //muestro mediante id
                } else {
                    $('#tablaReporteSalida').hide(); //muestro mediante id$
                    $('#tablaReporteEntrada').hide(); //muestro mediante id
                    $('#tablaReporteDescarte').show(); //muestro mediante id
                    $('#tablaReporteDevolucion').hide(); //muestro mediante id
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: dataform,
                        url: '{{ route('ReporteDescartesPropagacionEsta') }}',
                        type: 'post',
                        dataType: 'json',
                        success: function (Result) {
                            //console.log(Result);
                            var TableRepor = $('#TablaReporteDescartes').DataTable({
                                "info": true,
                                dom: 'Bfrtip',
                                destroy: true,
                                paging: true,
                                data: Result.data,
                                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_  ",
                                    "search": "Buscar:",
                                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                                    "Previous": "Anterior",
                                },

                                columns: [
                                    {data: 'Nombre_Variedad'},
                                    {data: 'NombreGenero'},
                                    {data: 'PlotIDNuevo'},
                                    {data: 'Semana'},
                                    {data: 'CausalDescarte'},
                                    {data: 'PlantasDescartadas'},
                                    {data: 'SemanaDescarte'},

                                ],
                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                                        titleAttr: 'Excel',
                                        messageTop: 'Semana ' + FechaInicial/* + '  Fecha Final ' + FechaFinal*/
                                    },
                                ],
                            });
                        }
                    });
                }
            });

            $("#btnDevolucion").click(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let FechaInicial = $('#Fechainial').val();
                let FechaFinal = $('#FechaFin').val();
                let dataform = {FechaInicial/*, FechaFinal*/};

                if (FechaInicial === '' /*|| FechaFinal === ''*/) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                    $('#tablaReporteEntrada').hide(); //muestro mediante id$
                    $('#tablaReporteSalida').hide(); //muestro mediante id
                    $('#tablaReporteDescarte').hide(); //muestro mediante id
                    $('#tablaReporteDevolucion').hide(); //muestro mediante id
                } else {
                    $('#tablaReporteSalida').hide(); //muestro mediante id$
                    $('#tablaReporteEntrada').hide(); //muestro mediante id
                    $('#tablaReporteDescarte').hide(); //muestro mediante id
                    $('#tablaReporteDevolucion').show(); //muestro mediante id
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: dataform,
                        url: '{{ route('ReporteDevolucionPropagacionEsta') }}',
                        type: 'post',
                        dataType: 'json',
                        success: function (Result) {
                            //console.log(Result);
                            var TableRepor = $('#TablaDevoluciones').DataTable({
                                "info": true,
                                dom: 'Bfrtip',
                                destroy: true,
                                paging: true,
                                data: Result.data,
                                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_  ",
                                    "search": "Buscar:",
                                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                                    "Previous": "Anterior",
                                },

                                columns: [
                                    {data: 'Nombre_Variedad'},
                                    {data: 'CausalSalidas'},
                                    {data: 'CodigoBarras'},

                                ],
                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                                        titleAttr: 'Excel',
                                        messageTop: 'Fecha incial ' + FechaInicial /*+ '  Fecha Final ' + FechaFinal*/
                                    },
                                ],
                            });
                        }
                    });
                }
            });

            let ReporteDinamicoEntr = $("#btnEntradasDinamico").click(function (event) {
                event.preventDefault();

                let token = $('#token').val();
                let FechaInicial = $('#Fechainiald').val();
                let FechaFinal = $('#FechaFind').val();
                let dataform = {FechaInicial/*, FechaFinal*/};

                if (FechaInicial === '' /*|| FechaFinal === ''*/) {
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
                    /*url:" name route" + '/' + FechaInicial + '/' + FechaFinal,*/
                    $.ajax({
                        data: {FechaInicial: FechaInicial/*, FechaFinal: FechaFinal*/},
                        url: '/Propagacion/ReporteEntradaPropagacionDianmico/' + FechaInicial /*+ '/' + FechaFinal*/,
                        type: 'get',
                        success: function (Result) {
                            $("#ReporteDinamicoEntradas").pivotUI(Result.data,
                                {renderers: renderers},
                                false, "es"
                            );
                            $('#loading').hide();
                            $('#ReporteDinamicoSalidas').hide();
                            $('#ReporteDinamicoEntradas').show();
                            $('#tablasdinamicasConte').show();
                        },
                    });
                }
            });

            $("#btnLimpiarTables").click(function () {

                Swal.fire({
                    title: 'Limpiar Tablas',
                    text: 'Esta Realizando un limpiado de las tablas',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                            url: '{{ route('IniciarArqueo') }}',
                            type: 'post',
                            success: function (Result) {
                                if (Result.ok === 1) {
                                    iziToast.success({
                                        //timeout: 20000,
                                        title: 'success',
                                        position: 'center',
                                        message: 'Limpieza finalizada',
                                    });

                                    function waitFunc() {
                                        location.reload();
                                    }

                                    window.setInterval(waitFunc, 2000);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Algo salio mal LLamar a sistemas',
                                    });

                                }
                            },
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Cancelado',
                        });

                    }
                });


            });

        });


    </script>
@endsection
