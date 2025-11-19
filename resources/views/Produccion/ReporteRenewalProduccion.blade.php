@extends('layouts.Principal')
@section('contenidoPrincipal')
    <style>
        hr {
            margin-top: -2px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #3c8dbc;
        }
    </style>
    <div class="content-header col-lg-12">
        <h3>Reporte Estado Cajas Renewal</h3>
    </div>
    <div class="card card-primary card-outline col-lg-12">
        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

        <div class="box box-primary col-lg-12 " style="margin-left: 20px;">
            <div class="col-lg-6" style="margin-top: 20px">
                <div class="row">
                    <div class="col-lg-5">
                        <form id="Semana">
                            <label>Semana</label>

                            <input id="TxtSemana" type="week" class="form-control labelform">
                        </form>
                    </div>
                    <div style="margin-top: 30px;margin-left: 60px">
                        <form id="Consultar" method="POST" action="{{ route('ConsultaEstadoCajasRenewal') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <button id="btnConsultar" type="submit" class="btn btn-primary" style="margin-left: 20px"><i
                                    class="fa fa-refresh"></i> Actualizar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr style="margin-top: 20px">
        <div class="dataTables_wrapper dt-bootstrap4">
            <div class="table" style="margin-top: 20px">
                <table class="table-bordered table-striped datstyle scroll" id="TableReporteRenewal" style="width: 98%">
                    <thead>
                    <tr>
                        <th class="text-center">Numero Caja</th>
                        <th class="text-center">Cant. Necesaria</th>
                        <th class="text-center">Cant. Ingresos</th>
                        <th class="text-center">Cant. Salida</th>
                        <th class="text-center">Cant. Cancelados</th>
                        <th class="text-center">Estado Caja</th>
                        <th class="text-center">Detalle</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="ModalDetalleCaja" class="modal fade bigEntrance2" role="dialog">
        <form {{--action="{{ route('CambiarFaseLab') }}" method="post"--}}>
            {{--<input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">--}}
            <div class="modal-dialog modal-xl" style="width: 80% !important; margin-top: 20px">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="">Detalle de Caja # </h4>
                        <h4 class="modal-title" id="Caja">Detalle de Caja # </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body col-lg-12">

                    </div>

                    <div class="col-lg-12" id="divtabladetalles">
                        <div class="panel-primary">
                            <div class="box box-body">
                                <table id="TableCodigosBarras"
                                       class="table table-hover display nowrap col-lg-12 cell-border">
                                    <thead class="bg-blue-gradient" style="width: 100%">
                                    <tr>
                                        <th>Caja</th>
                                        <th>Codigo Barras</th>
                                        <th>Variedad</th>
                                        <th>Tamaño</th>
                                        <th>Bloque</th>
                                        <th>Nave</th>
                                        <th>Cama</th>
                                        <th>Estado Bolsillo</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {


            let ConsultaCajasRenewal = $('#Consultar').submit(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let semana = $('#TxtSemana').val();

                if (semana.length === 0) {
                    swal("Atencion", "Debes Seleccionar Semana A Consultar", "warning");
                } else {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        dataType: 'json',
                        data: {semana},
                        url: '/ConsultaEstadoCajasRenewal',
                        type: "post",

                        success: function (Result) {
                            var TableConsulta = $('#TableReporteRenewal').DataTable({
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
                                    {data: 'Caja'},
                                    {data: 'CantInventario'},
                                    {data: 'CantEntradas'},
                                    {data: 'CantSalidas'},
                                    {data: 'Cancelados'},
                                    {data: 'EstadoCaja'},
                                    {

                                        "render": function (data, type, row, meta) {
                                            return '<a href="javascript:void(0);" onclick="prueba(' + row.Caja + ')"><i class="fas fa-search"></i></a>';
                                        }, "targets": 0
                                    },
                                ],
                                "columnDefs": [
                                    {"className": "dt-center", "targets": "_all"}
                                ],
                                "createdRow": function (row, data, dataIndex) {
                                    if (data['EstadoCaja'] === 'Lista Para Entregar') {
                                        $($(row).find("td")[5]).css('background-color', '#f6c430');
                                    } else if (data['EstadoCaja'] === 'Entregada') {
                                        $($(row).find("td")[5]).css('background-color', '#5af53f');
                                    } else {
                                        $($(row).find("td")[5]).css('background-color', '#e33821');
                                    }


                                },
                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                                        titleAttr: 'Excel',
                                        messageTop: 'Semana ' + semana
                                    },
                                ],
                            });
                        }
                    });
                }
            });


        });

        function prueba(data) {
            event.preventDefault();
            let token = $('#token').val();
            let semana = $('#TxtSemana').val();
            $('#ModalDetalleCaja').modal('show');
            //$('#Caja').append(data);
            $('#Caja').text(data);

            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                dataType: 'json',
                data: {data, semana},
                url: '/ConsultaDetallesCajasRenewal',
                type: "post",

                success: function (Result) {

                    var TableDetalleConsulta = $('#TableCodigosBarras').DataTable({
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
                            {data: 'Caja'},
                            {data: 'CodigoBarras'},
                            {data: 'NombreVariedad'},
                            {data: 'Tamano_Esqueje'},
                            {data: 'Bloque'},
                            {data: 'Nave'},
                            {data: 'Cama'},
                            {data: 'ESTADOBOLSILLO'},
                        ],
                        "columnDefs": [
                            {"className": "dt-center", "targets": "_all"}
                        ],
                        "createdRow": function (row, data, dataIndex) {
                            if (data['ESTADOBOLSILLO'] === 'Recibido') {
                                $($(row).find("td")[7]).css('background-color', '#fcc31d');
                            } else if (data['ESTADOBOLSILLO'] === 'Entregado') {
                                $($(row).find("td")[7]).css('background-color', '#5af53f');
                            } else if (data['ESTADOBOLSILLO'] === 'Pendiente') {
                                $($(row).find("td")[7]).css('background-color', '#fa5c07');
                            } else {
                                $($(row).find("td")[7]).css('background-color', '#fd2f13');
                            }


                        },
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                                titleAttr: 'Excel',
                                messageTop: 'Caja ' + data
                            },
                        ],
                    });
                }
            });
        }
    </script>

@endsection
