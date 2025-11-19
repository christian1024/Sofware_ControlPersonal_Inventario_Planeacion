<!doctype html>
<html lang="es">
<head>

    <link rel="stylesheet" href="{{ asset('Principal/css/adminlte.min.css') }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Pedido Solcitado</title>
</head>
<body>
<div class="col-lg-12">
    <div class="col-lg-12">
        <p>Buen Dia</p>
        <p>El pedido <b> {{ $CabezaPedido->NumeroPedido }}</b> del cliente <b> {{ $CabezaPedido->Nombre }} </b> se encuentra Aceptado de la siguente manera</p>
    </div>
    <div class="col-lg-8">
        <table class="table table-striped">
            <thead border="1">
            <tr>
                <th>Genero</th>
                <th>Variedad</th>
                <th>Codigo</th>
                <th>Tipo Entrega</th>
                <th>Cantidad Solicitada</th>
                <th>Semana Despacho</th>
                <th>Confirmacion</th>
            </tr>
            </thead>
            <tbody>
            @foreach($DetallePedido as $pe)
                <tr>
                    <td>{{ $pe->NombreGenero }}</td>
                    <td>{{ $pe->Nombre_Variedad }}</td>
                    <td>{{ $pe->Codigo }}</td>
                    <td>{{ $pe->TipoEntregaModificada }}</td>
                    <td>{{ $pe->CantidadInicialModificada }}</td>
                    <td>{{ $pe->SemanaPlaneacionDespacho }}</td>
                    @if($pe->FlagActivo_CancelacionPreConfirmado=== '1' || $pe->FlagActivo_CancelacionPreConfirmado===1)
                        <td>Cancelado</td>
                    @else
                        <td>Aceptado</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-lg-12"><br>
        <div class="col-lg-4">
            <label>Por favor informar al cliente para dar su aceptación</label>
            <br>
        </div>
    </div>

    <div class="col-lg-12"><br><br>
        <div class="col-lg-4">

            <p>Saludos</p> <br>

            <label>Marcela Muñoz Ramírez</label> <br>
            <span>Head of Planning and Logistic</span> <br>
            <span>Darwin Colombia SAS</span> <br>
            <span>P: +57 489 9777 Ext: 110</span> <br>
            <span>E: dgaviria@darwinperennials.com</span> <br>
            <img src="{{ public_path('Principal/img/logodarwin(tc).png') }}" height="50" width="225"><br>
            <span>A division of Ball Horticultural Co.</span> <br>

        </div>
    </div>

</div>
</body>
</html>
