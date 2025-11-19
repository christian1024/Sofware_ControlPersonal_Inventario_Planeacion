@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card container-fluid">
        <h4 class="card-header text-center">Reporte General Pedidos </h4>
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
                    <th scope="col">Cantidad despacho</th>
                    <th scope="col">Semana Despacho</th>
                    <th scope="col">Planeado</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Causa Cancelación</th>
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
                        @if($PedidoGeneral->SemanaPlaneacionDespacho === null)
                            <td></td>
                        @else
                            <td>{{ $PedidoGeneral->CantidadInicialModificada}}</td>
                        @endif
                        <td>{{ $PedidoGeneral->SemanaPlaneacionDespacho}}</td>

                        @if($PedidoGeneral->Flag_Activo=== '0' && $PedidoGeneral->Flag_ActivoPlaneacion=== '1' )
                            <td style="background-color: #ffcccc">SI</td>

                        @elseif($PedidoGeneral->Flag_Activo=== '1' && $PedidoGeneral->Flag_ActivoPlaneacion=== '1' )
                            <td>SI</td>
                        @else
                            <td>NO</td>
                        @endif
                        @if($PedidoGeneral->Flag_Activo=== '0' )
                            <td style="background-color: #ffcccc">Cancelado</td>
                        @else
                            <td>Activo</td>
                        @endif
                        @if($PedidoGeneral->ObservacionCancelacion=== NULL )
                            <td>{{ $PedidoGeneral->causalCancelacion}}</td>
                        @else
                            <td>{{ $PedidoGeneral->ObservacionCancelacion}}</td>
                        @endif
                    </tr>
                @endforeach

                </tbody>
            </table>
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
