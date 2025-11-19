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
        <th scope="col">Semana Movimiento</th>
        <th scope="col">Canrtidad plantas</th>
        <th scope="col">Fase</th>
        <th scope="col">Factor Planeacion </th>
        <th scope="col">Identificador </th>


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
            <td>{{ $PedidoGeneral->SemanaMovimiento}}</td>
            <td>{{ $PedidoGeneral->CantidadPlantas}}</td>
            <td>{{ $PedidoGeneral->NombreFase}}</td>
            <td>{{ $PedidoGeneral->FactorPlaneacion}}</td>
            <td>{{ $PedidoGeneral->Programas}}</td>



        </tr>
    @endforeach

    </tbody>
</table>
