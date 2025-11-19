@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card">
        <h4 class="card-header text-center">Reporte Pedidos Confirmados</h4>
        <div class="card-body">
            <table class="table table-bordered" id="TableReporteConfirmacion">
                <thead>
                <tr>
                    <th scope="col"># Pedido</th>
                    <th scope="col">Genero</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Variedad</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Tipo entrega</th>
                    <th scope="col">Tipo Programa</th>
                    <th scope="col">Semana Despacho</th>
                    <th scope="col">Cantidad Despachar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($PedidosConfirmados as $PedidoConfirmado)
                    <tr>
                        <td>{{ $PedidoConfirmado->NumeroPedido }}</td>
                        <td>{{ $PedidoConfirmado->NombreGenero}}</td>
                        <td>{{ $PedidoConfirmado->Codigo}}</td>
                        <td>{{ $PedidoConfirmado->Nombre_Variedad}}</td>
                        <td>{{ $PedidoConfirmado->Indicativo}}</td>
                        <td>{{ $PedidoConfirmado->TipoEntrega}}</td>
                        <td>{{ $PedidoConfirmado->TipoPrograma}}</td>
                        <td>{{ $PedidoConfirmado->SemanaPlaneacionDespacho}}</td>
                        <td>{{ $PedidoConfirmado->CantidadInicialModificada}}</td>
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
