@extends('layouts.Principal')
@section('contenidoPrincipal')


    <div class="card">
        <h3 class="card-header text-center"><strong> REPORTES </strong></h3>

        <div class="card-body">

            <ul class="nav nav-tabs">
                <li><a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ReporteEstandar">Reportes Novedades</a></li>
                <li><a class="nav-link" id="home-tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ReporteEstandar1">Reportes Proximas Siembras</a></li>
            </ul>

            <div class="tab-content">

                <div id="ReporteEstandar" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card card-body">
                        <table class="table table-bordered" id="TableNovedades">
                            <thead>
                            <tr class="thead-dark">
                                <th>plotid</th>
                                <th>codigo</th>
                                <th>variedad</th>
                                <th>genero</th>
                                <th>especie</th>
                                <th>Bloque</th>
                                <th>Procedencia</th>
                                <th>Plantas Canastilla</th>
                                <th>Hora Luz</th>
                                <th>Bandeja</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($novedadesSemanaActual as $novedadSemanaActual)
                                <tr>
                                    <td>{{ $novedadSemanaActual->PlotIDNuevo }}</td>
                                    <td>{{ $novedadSemanaActual->Codigo }}</td>
                                    <td>{{ $novedadSemanaActual->Nombre_Variedad }}</td>
                                    <td>{{ $novedadSemanaActual->NombreGenero }}</td>
                                    <td>{{ $novedadSemanaActual->NombreEspecie }}</td>
                                    <td>{{ $novedadSemanaActual->Bloque_siembra_Producción }}</td>
                                    <td>{{ $novedadSemanaActual->Procedencia }}</td>
                                    <td>{{ $novedadSemanaActual->Plantas_X_Canastilla }}</td>
                                    <td>{{ $novedadSemanaActual->Horas_luz_producción }}</td>
                                    <td>{{ $novedadSemanaActual->tipo_de_bandeja }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="ReporteEstandar1" class="card tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card card-body">
                        <table class="table table-bordered" id="TableSiembrasProximasEntregas">
                            <thead>
                            <tr class="thead-dark">
                                <th>plotid</th>
                                <th>codigo</th>
                                <th>variedad</th>
                                <th>genero</th>
                                <th>especie</th>
                                <th>Bloque</th>
                                <th>Procedencia</th>
                                <th>Plantas Canastilla</th>
                                <th>Hora Luz</th>
                                <th>Bandeja</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($siembrasFutura as $siembra)
                                <tr>
                                    <td>{{ $siembra->PlotId }}</td>
                                    <td>{{ $siembra->Codigo }}</td>
                                    <td>{{ $siembra->Nombre_Variedad }}</td>
                                    <td>{{ $siembra->NombreGenero }}</td>
                                    <td>{{ $siembra->NombreEspecie }}</td>
                                    <td>{{ $siembra->Bloque_siembra_Producción }}</td>
                                    <td>{{ $siembra->Procedencia }}</td>
                                    <td>{{ $siembra->Plantas_X_Canastilla }}</td>
                                    <td>{{ $siembra->Horas_luz_producción }}</td>
                                    <td>{{ $siembra->tipo_de_bandeja }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#TableSiembrasProximasEntregas').DataTable({
            dom: "Bfrtip",
            "paging": true,
            "order": [[5, "asc"], [2, "asc"]],
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

        $('#TableNovedades').DataTable({
            dom: "Bfrtip",
            "paging": true,
            "order": [[5, "asc"], [2, "asc"]],
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

