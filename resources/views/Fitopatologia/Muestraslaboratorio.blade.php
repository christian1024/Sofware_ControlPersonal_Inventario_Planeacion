@extends('layouts.Principal')
@section('contenidoPrincipal')


    <div class="card">
        <h4 class="card-header text-center">CONTROL ANALISIS INTRODUCCIONES</h4>
        <div class="card-body">
            <table class="table table-bordered" id="TableTickets">
                <thead>
                <tr class="thead-dark text-center">
                    <th>Identificador</th>
                    <th>Index</th>
                    <th>Screen</th>
                    <th>Agro Rhodo</th>
                    <th>Accion</th>
                </tr>
                </thead>
                <tbody>

                @foreach($IdendificadoresMuestras as $IdendificadorMuestra)
                    <tr>
                        <td>{{ $IdendificadorMuestra->Identificador }}</td>
                        <td class="text-center">

                            @php($EstadoIndex = \App\Http\Controllers\FitopatologiaController::EstadoIndex( $IdendificadorMuestra->Identificador))
                            @if($EstadoIndex === 0)
                                <button type="button" class="btn btn-tool btn btn-success btn-circle btn-sm">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-tool btn btn-danger btn-circle btn-sm">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </td>

                        <td class="text-center">
                            @php($EstadoScreen = \App\Http\Controllers\FitopatologiaController::EstadoScreen( $IdendificadorMuestra->Identificador))
                            @if($EstadoScreen===0 && $EstadoIndex === 0)

                                <button type="button" class="btn btn-tool btn btn-success btn-circle btn-sm">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-tool btn btn-danger btn-circle btn-sm">
                                    <i class="fas fa-times"></i>
                                </button>

                            @endif
                        </td>

                        <td class="text-center">
                            <button type="button" class="btn btn-tool btn btn-danger btn-circle btn-sm">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('viewmuestraslaboratorioDetallado',['Identificador'=>encrypt($IdendificadorMuestra->Identificador)]) }}" class="btn btn-success" data-placement="left" data-toggle="tooltip" data-html="true" title="Ver Detalles Aceptados" style="position: center"><i class="fa fa-check-circle"></i> </a>
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>


    <script>

        $('#TableTickets').DataTable({
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

