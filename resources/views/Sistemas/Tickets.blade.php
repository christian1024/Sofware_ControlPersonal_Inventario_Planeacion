@extends('layouts.Principal')
@section('contenidoPrincipal')


    <div class="card">
        <h4 class="card-header text-center">Reporte Tickets</h4>
        <div class="card-body">
            <table class="table table-bordered" id="TableTickets">
                <thead>
                <tr class="thead-dark">
                    <th>usuario</th>
                    <th>Descripción</th>
                    <th>Tipo Solicitud</th>
                    <th>Justificación</th>
                    <th>Fecha/Hora Creación</th>
                    <th>Estado</th>
                    <th>Fecha/Hora Atendido</th>
                    <th>Atendido Por</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tickest  as $tickes)
                    <tr>
                        <td>{{ $tickes->usuario }}</td>
                        <td>{{ $tickes->Descripcion }}</td>
                        <td>{{ $tickes->TipoSolicitud }}</td>
                        <td>{{ $tickes->Jusificacion }}</td>
                        <td>
                            {{ $tickes->Fechacreacion }}
                        </td>


                        @if($tickes->Flag_Activo=== '1')
                            <td style="color: red">Pendiente</td>
                        @else
                            <td>Realizado</td>
                        @endif

                        @if($tickes->Flag_Activo=== '0')
                            <td>{{ $tickes->fechaatendido }}</td>
                        @else
                            <td></td>
                        @endif


                        @if($tickes->Flag_Activo=== '0')
                            <td>{{ $tickes->usuarioit }}</td>
                        @else
                            <td></td>
                        @endif

                        @can('BtnCumplidoTicket')
                            @if($tickes->Flag_Activo=== '1')
                                <td>
                                    <a href="{{ route('ticketsCumplido',['id'=>encrypt($tickes->id)]) }}" class="btn btn-success btn-circle btn-sm" data-placement="left" data-toggle="tooltip" data-html="true" title="Cumplido" style="position: center"><i class="fa fa-check"></i> </a>
                                </td>
                            @else
                                <td></td>
                            @endif
                        @endcan


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

