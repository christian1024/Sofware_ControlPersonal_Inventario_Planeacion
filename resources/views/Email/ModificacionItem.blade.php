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
        <p>Se Modificó el siguiente Item Interno del pedido <b> {{ $CabezaPedido->NumeroPedido }}</b> para el cliente <b> {{ $CabezaPedido->Nombre }} </b></p>
    </div>
    <div class="col-lg-8">
        <table class="table table-striped">
            <thead border="1">
            <tr>
                <th>Genero</th>
                <th>Variedad</th>
                <th>Codigo</th>
                <th>Cantidad Solicitada</th>
                <th>Tipo Entrega</th>
                <th>Semana Solicitada</th>
            </tr>
            </thead>
            <tbody>
            @foreach($DetallePedido as $pe)
                <tr>
                    <td>{{ $pe->NombreGenero }}</td>
                    <td>{{ $pe->Nombre_Variedad }}</td>
                    <td>{{ $pe->Codigo }}</td>
                    <td>{{ $pe->CantidadInicialModificada }}</td>
                    <td>{{ $pe->TipoEntregaModificada }}</td>
                    <td>{{ $pe->SemanaEntregaModificada }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-lg-12"> <br>
        <div class="col-lg-4">
            <label>Observaciones</label>
            <br>
            <div>
                <p> {{ $CabezaPedido->Observaciones }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-12"> <br><br>
        <div class="col-lg-4">

            <p>Quedo atenta a cualquier inquietud o sugerencia</p> <br>

            <label>Diana Gaviria</label> <br>
            <span>Assistant to General Manager</span> <br>
            <span>Darwin Colombia SAS</span> <br>
            <span>M: +57 320 4478345</span> <br>
            <span>P: +57 489 9777 Ext: 115</span> <br>
            <span>E: dgaviria@darwinperennials.com</span> <br>
            <img src="{{ public_path('Principal/img/logodarwin(tc).png') }}" height="50" width="225"><br>
            <span>A division of Ball Horticultural Co.</span> <br>

        </div>
    </div>

</div>
</body>
</html>
