@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card container-fluid">
        <h4 class="card-header text-center">Reporte Planeación Pedidos </h4>

        <div class="card card-body">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('ExportarReportePedido') }}" class="btn btn-success">
                        <i class="fa fa-table"></i>Exportar Programas </a>
                </div>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered" id="TableReporteConfirmacion">
                    <thead>
                    <tr>
                        <th scope="col"># Pedido</th>
                        <th scope="col">Semana Pedido</th>
                        <th scope="col">Genero</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Variedad</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Tipo entrega</th>
                        <th scope="col">Tipo Programa</th>
                        <th scope="col">Cantidad Solicitada</th>
                        <th scope="col">Semana Solicitada</th>
                        <th scope="col">Semana Despacho</th>
                        <th scope="col">Cantidad Despachar</th>
                        <th scope="col">Semana A Semana</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($PedidosGeneral as $PedidoGeneral)
                        <tr>
                            <td>{{ $PedidoGeneral->NumeroPedido }}</td>
                            <td>{{ $PedidoGeneral->SemanaCreacion}}</td>
                            <td>{{ $PedidoGeneral->NombreGenero}}</td>
                            <td>{{ $PedidoGeneral->Codigo}}</td>
                            <td>{{ $PedidoGeneral->Nombre_Variedad}}</td>
                            <td>{{ $PedidoGeneral->Indicativo}}</td>
                            <td>{{ $PedidoGeneral->TipoEntrega}}</td>
                            <td>{{ $PedidoGeneral->TipoPrograma}}</td>
                            <td>{{ $PedidoGeneral->CantidadInicialModificada}}</td>
                            <td>{{ $PedidoGeneral->SemanaEntrega}}</td>
                            <td>{{ $PedidoGeneral->SemanaPlaneacionDespacho}}</td>
                            <td>{{ $PedidoGeneral->CantidadInicialModificada}}</td>
                            <td>
                                <div class="card">
                                    <div class="card-header " style="cursor: move;">
                                        @php($caracteristicas = \App\Http\Controllers\OrdenesPedidoLaboratorioController::DetallesPlaneacionSemanaAsemanaC(encrypt($PedidoGeneral->id)))
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool btn btn-success btn-circle btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover" id="TablaDetallesPedido">
                                            <thead>
                                            <tr>
                                                <th>Semana</th>
                                                <th>Cantidad</th>
                                                <th>Fase</th>
                                                <!--<th>Accion</th>-->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            @foreach($caracteristicas as $caracteristica)
                                                <tbody>
                                                <tr>
                                                    <td> {{ $caracteristica->SemanaMovimiento }}</td>
                                                    <td>{{ $caracteristica->CantidadPlantas }}</td>
                                                    <td>{{ $caracteristica->NombreFase }}</td>
                                                    <!--<td>
                                                        <button type="button" class="btn btn-success btn-circle btn-sm" data-card-widget="collapse">
                                                        <i class="fas fa-check"></i>
                                                        </button>
                                                    </td>-->

                                                </tr>
                                                </tbody>
                                            @endforeach
                                        </table>

                                    </div>

                                </div>
                            </td>


                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $('#TableReporteConfirmacion').DataTable({
            dom: "Bfrtip",
            "paging": false,
            buttons: [
                'excel'
            ],
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "No hay registros disponibles",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
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
    </script>
@endsection
