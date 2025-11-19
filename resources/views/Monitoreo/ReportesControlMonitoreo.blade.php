@extends('layouts.Principal')
@section('contenidoPrincipal')
    {{--<script type="text/javascript" async="" src="https://www.google-analytics.com/plugins/ua/linkid.js"></script>--}}
    {{--<script async="" src="https://www.google-analytics.com/analytics.js"></script>--}}
    {{--<script src="https://code.jquery.com/jquery.min.js"></script>--}}

    <div class="card row">
        <div style="display: flex; justify-content:center; align-items: flex-end;" class="text-center">
            <h2><i class="fa fa-line-chart"></i> Reporte Inventario Monitoreo</h2>
        </div>

        <div class="box-body">

            <ul class="nav nav-tabs">
                <li><a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ReporteEstandar">Reportes Estandar</a></li>
                <li><a class="nav-link" id="home-tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ReporteEstandarDespacho">Reporte Despacho </a></li>
                <li><a class="nav-link" id="home-tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ReporteRendimientoMonitoreo">Reporte Rendimiento </a></li>

            </ul>
            <div class="tab-content">
                <div id="ReporteEstandar" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab" {{--style="background-color: #1d68a7"--}}>

                    <div class="card card-body">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="control-label">{{ __('Desde') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                    <input type="date" name="Fechainial" id="FechainialEstandar" class="labelform" required="required">

                                    <label for="" class="control-label">{{ __('Hasta') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                    <input type="date" name="FechaFin" id="FechaFinEstandar" class="labelform" required="required">
                                </div>


                            </div>

                            <div class="col-lg-5">
                                <a class="btn btn-success" id="btnEntradaEstandar" href="">
                                    <i class="fa fa-search nav-icon"></i>
                                    <i data-toggle="tooltip" title="Reporte entradas"> Buscar</i>
                                </a>


                            </div>
                        <!--                            <div class="col-lg-5">
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
                            </div>-->
                        </div>
                    </div>
                    <div class="container-fluid contenedor">
                        <div class="box-body" id="tablaReporteEntrada">
                            <div class="text-center">
                                <h1 style="color: black">Reporte General</h1>
                            </div>
                            <div class="box box-body table-responsive">
                                <table id="TableReportEntrada" class="table table-bordered table-hover text-nowrap" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Codigo Barras</th>
                                        <th># Caja</th>
                                        <th>Dia Despacho</th>
                                        <th>Nombre_Variedad</th>
                                        <th>NombreGenero</th>
                                        <th>Codigo Integracion</th>
                                        <th>Inicio Monitoreo</th>
                                        <th>Finalizo Monitoreo</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="ReporteEstandarDespacho" class="card tab-pane fade show" role="tabpanel" aria-labelledby="home-tab" {{--style="background-color: #1d68a7"--}}>

                    <div class="card card-body">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="control-label">{{ __('Desde') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                    <input type="date" name="FechainialD" id="FechainialEstandarDespacho" class="labelform" required="required">

                                    <label for="" class="control-label">{{ __('Hasta') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                    <input type="date" name="FechaFinD" id="FechaFinEstandarDespacho" class="labelform" required="required">
                                </div>


                            </div>

                            <div class="col-lg-5">
                                <a class="btn btn-success" id="btnEntradaEstandarDespacho" href="">
                                    <i class="fa fa-search nav-icon"></i>
                                    <i data-toggle="tooltip" title="Reporte Despacho"> Buscar</i>
                                </a>


                            </div>

                        </div>
                    </div>
                    <div class="container-fluid contenedor">
                        <div class="box-body" id="tablaReporteEntradaDespacho">
                            <div class="text-center">
                                <h1 style="color: black">Reporte Entrada Cuarto</h1>
                            </div>
                            <div class="box box-body table-responsive">
                                <table id="tableReporteEntradaDespacho" class="table table-bordered table-hover text-nowrap" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Genero</th>
                                        <th>Especie</th>
                                        <th>Variedad</th>
                                        <th>Codigo Integracion</th>
                                        <th>Codigo Barras</th>
                                        <th>Bags</th>
                                        <th>Cuttings</th>

                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="ReporteRendimientoMonitoreo" class="card tab-pane fade show" role="tabpanel" aria-labelledby="home-tab" {{--style="background-color: #1d68a7"--}}>

                    <div class="card card-body">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="control-label">{{ __('Desde') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                    <input type="date" name="FechainialRM" id="FechainialRendimiento" class="labelform" required="required">

                                    <label for="" class="control-label">{{ __('Hasta') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                    <input type="date" name="FechaFinRM" id="FechaFinRendimeinto" class="labelform" required="required">
                                </div>


                            </div>

                            <div class="col-lg-5">
                                <a class="btn btn-success" id="btnReporteRendimeintoMo" href="">
                                    <i class="fa fa-search nav-icon"></i>
                                    <i data-toggle="tooltip" title="Reporte Despacho"> Buscar</i>
                                </a>


                            </div>

                        </div>
                    </div>
                    <div class="container-fluid contenedor">
                        <div class="box-body" id="tablaReporteEntradaDespacho">
                            <div class="text-center">
                                <h1 style="color: black">Reporte Entrada Cuarto</h1>
                            </div>
                            <div class="box box-body table-responsive">
                                <table id="tableReporteRendimientoMonitoreo" class="table table-bordered table-hover text-nowrap" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Codigo Barras</th>
                                        <th>Nombre Monitor</th>
                                        <th>Genero</th>
                                        <th>Variedad</th>
                                        <th>Codigo Integracion</th>
                                        <th>Fecha y hora Inicio Monitoreo</th>
                                        <th>Fecha y hora Monitoreo</th>

                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
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
            window.onload = function () {
                var fecha = new Date(); //Fecha actual
                var mes = fecha.getMonth() + 1; //obteniendo mes
                var dia = fecha.getDate(); //obteniendo dia
                var ano = fecha.getFullYear(); //obteniendo año
                if (dia < 10)
                    dia = '0' + dia; //agrega cero si el menor de 10
                if (mes < 10)
                    mes = '0' + mes //agrega cero si el menor de 10
                document.getElementById('FechaFinEstandar').value = ano + "-" + mes + "-" + dia;
                document.getElementById('FechaFinEstandarDespacho').value = ano + "-" + mes + "-" + dia;
                document.getElementById('FechaFinRendimeinto').value = ano + "-" + mes + "-" + dia;

            };

            let token = $('#token').val();
            $('#tablaReporteEntrada').hide(); //muestro mediante id$


            $("#btnEntradaEstandar").click(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let FechaInicial = $('#FechainialEstandar').val();
                let FechaFinal = $('#FechaFinEstandar').val();
                let dataform = {FechaInicial, FechaFinal};

                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                } else {

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: dataform,
                        url: '{{ route('ReporteEstandarMonitoreo') }}',
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
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_  ",
                                    "search": "Buscar:",
                                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                                    "Previous": "Anterior",
                                },
                                columns: [
                                    {data: 'EnCuCodigo'},
                                    {data: 'Caja'},
                                    {data: 'diadespacho'},
                                    {data: 'Nombre_Variedad'},
                                    {data: 'NombreGenero'},
                                    {data: 'Codigo'},
                                    {
                                        data: 'InicioMonitoreo',
                                        render: function (data) {
                                            if (data === null) {
                                                return '<span>No</span>';
                                            } else {
                                                return '<span>Si</span>';
                                            }
                                        }
                                    },
                                    {
                                        data: 'Flag_ActivoEntrada',
                                        render: function (data) {
                                            if (data === null) {
                                                return '<span>No</span>';
                                            } else if (data === '1') {
                                                return '<span>No</span>';
                                            } else {
                                                return '<span>Si</span>';
                                            }
                                        }
                                    },


                                ],
                                "order": [[2, 'asc']],
                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                                        title: 'Reporte Monitoreo Fecha Inicial ' + FechaInicial + '  Fecha Final ' + FechaFinal,
                                        messageTop: 'Fecha incial ' + FechaInicial + '  Fecha Final ' + FechaFinal
                                    },
                                ],
                            });
                        },
                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                            $('#loader').hide();
                            $('#tablaReporteEntrada').show(); //muestro mediante id$
                        },
                    });
                }
            });

            $("#btnReporteRendimeintoMo").click(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let FechaInicial = $('#FechainialRendimiento').val();
                let FechaFinal = $('#FechaFinRendimeinto').val();
                let dataform = {FechaInicial, FechaFinal};

                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione Rango de fechas',
                    });
                } else {

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: dataform,
                        data1: dataform,
                        url: '{{ route('ReporteRendimeintoMonitoreo') }}',
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                            $('#loader').show();
                        },
                        success: function (Result) {

                            //console.log(Result);
                            var TableRepor = $('#tableReporteRendimientoMonitoreo').DataTable({
                                "info": true,
                                dom: 'Bfrtip',
                                destroy: true,
                                paging: true,
                                //columns: Result.data,
                                data: Result.data,
                                data1: Result.data,
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_  ",
                                    "search": "Buscar:",
                                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                                    "Previous": "Anterior",
                                },
                                columns: [
                                    {data: 'CodigoBarras'},
                                    {data: 'Monitor'},
                                    {data: 'NombreGenero'},
                                    {data: 'Nombre_Variedad'},
                                    {data: 'Codigo'},
                                    {data: 'created_at'},
                                    {
                                        data: 'Flag_ActivoEntrada',

                                        render: function (data, type, row) {
                                            if (data === '0' ) {
                                                return row.updated_at
                                            }else{
                                                return '<span>SIN FINALIZAR</span>';
                                            }
                                        }

                                        /*render: function (data) {

                                            if (data === '0') {
                                                return
                                            ????
                                                '';
                                            } else {
                                                return '<span>N/A</span>';
                                            }
                                        }*/
                                    },
                                ],

                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                                        title: 'Reporte Monitoreo Fecha Inicial ' + FechaInicial + '  Fecha Final ' + FechaFinal,
                                        messageTop: 'Fecha incial ' + FechaInicial + '  Fecha Final ' + FechaFinal
                                    },
                                ],
                            });
                        },
                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                            $('#loader').hide();
                            $('#tablaReporteEntrada').show(); //muestro mediante id$
                        },
                    });
                }
            });

            $("#btnEntradaEstandarDespacho").click(function (event) {
                /*aqui el tema de las tblas*/


                event.preventDefault();
                let token = $('#token').val();
                let FechaInicial = $('#FechainialEstandarDespacho').val();
                let FechaFinal = $('#FechaFinEstandarDespacho').val();
                let dataform = {FechaInicial, FechaFinal};

                if (FechaInicial === '' || FechaFinal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error...',
                        text: 'Seleccione Rango de fechas',
                    });
                } else {

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: dataform,
                        url: '{{ route('ReporteEstandarMonitoreoDespacho') }}',
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                            $('#loader').show();
                        },
                        success: function (Result) {
                            let Bags = '1';
                            let Cuttings = '50';
                            //console.log(Result);
                            var TableRepor = $('#tableReporteEntradaDespacho').DataTable({
                                "info": true,
                                dom: 'Bfrtip',
                                destroy: true,
                                paging: true,
                                //columns: Result.data,
                                data: Result.data,
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_  ",
                                    "search": "Buscar:",
                                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                                    "Previous": "Anterior",
                                },
                                columns: [
                                    {data: 'NombreGenero'},
                                    {data: 'NombreEspecie'},
                                    {data: 'Nombre_Variedad'},
                                    {data: 'Codigo'},
                                    {data: 'CodigoBarras'},
                                    {
                                        data: 'Flag_Activo',
                                        render: function (data) {
                                            if (data === '') {
                                                return '<span></span>';
                                            } else {
                                                return '<span>1</span>';
                                            }
                                        }
                                    },
                                    {
                                        data: 'Flag_Activo',
                                        render: function (data) {
                                            if (data === '') {
                                                return '<span></span>';
                                            } else {
                                                return '<span>50</span>';
                                            }
                                        }
                                    },
                                    /*{Bags},
                                    {Cuttings}*/

                                ],
                                "order": [[2, 'asc']],
                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',

                                    },
                                ],
                            });
                        },
                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                            $('#loader').hide();
                            $('#tableReporteEntradaDespacho').show(); //muestro mediante id$
                        },
                    });
                }
            });

        });


    </script>
@endsection
