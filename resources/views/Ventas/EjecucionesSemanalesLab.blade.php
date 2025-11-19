@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card">
        <h4 class="card-header text-center">Reporte Ejecuciones Semanales</h4>
        <div class="card-body">
            <table class="table table-bordered" id="TableReporteConfirmacion">
                <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Genero</th>
                    <th>Codigo</th>
                    <th>Variedad</th>
                    <th>Cliente</th>
                    <th>Identificador</th>
                    <th>Tipo Entrega</th>
                    <th>Etapa</th>
                    <th>Medio</th>
                    <th>ind*</th>
                    <th>tm</th>
                    <th>SM Entrega</th>
                    <th>Programa</th>
                    <th>Solicitado</th>
                    <th>Trabajo</th>
                    <th>Ope</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ejecuciones as $ejecucion)
                    <tr>
                        <td>Tipo</td>
                        <td>{{ $ejecucion->NombreGenero }}</td>
                        <td>{{ $ejecucion->Codigo }}</td>
                        <td>{{ $ejecucion->Nombre_Variedad }}</td>
                        <td>{{ $ejecucion->NombreCliente }}</td>
                        <td>{{ $ejecucion->Indentificador }}</td>
                        <td>Tipo Entrega</td>
                        <td>Etapa</td>
                        <td>Medio</td>
                        <td>ind*</td>
                        <td>tm</td>
                        <td>SM Entrega</td>
                        <td>Programa</td>
                        <td>Solicitado</td>
                        <td>Trabajo</td>
                        <td>Ope</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <script>
        $('#TableReporteConfirmacion').DataTable({
            /*"scrollX": true,*/
            dom: "Bfrtip",
            "paging": true,
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
