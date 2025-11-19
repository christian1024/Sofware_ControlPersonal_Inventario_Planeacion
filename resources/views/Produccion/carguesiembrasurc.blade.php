@extends('layouts.Principal')
@section('contenidoPrincipal')


    <div class="card">
        <h4 class="card-header text-center">Cargue Siembras Confirmadas</h4>


        <div class="card-body">
            @can('FormCargueConfirmacionessiembras')
                <div>
                    <div class="card-header">
                        <form id="" method="POST" action="{{ route('Carguesiembrasurc') }}" enctype="multipart/form-data">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <div class="box box-default form-row">
                                <div class="col-lg-4">
                                    <label>Importar Siembras</label>
                                    <input type="file" required name="cargueconfirmaciones">
                                </div>
                                <button type="submit" class="btn btn-success"> {{ __('Cargar') }} </button>
                            </div>
                            <hr>
                        </form>
                    </div>
                </div>
            @endcan

            @can('TablaConfirmacionesSiembras')
                <table class="table table-bordered" id="Tableconfirmaciones">
                    <thead>
                    <tr class="thead-dark">
                        <th>plotid</th>
                        <th>codigo</th>
                        <th>genero</th>
                        <th>variedad</th>
                        <th>especie</th>
                        <th>plantas</th>
                        <th>canastillas</th>
                        <th>semana siembra</th>
                        <th>semana siembra inicial</th>
                        <th>procedencia</th>
                        <th>densidad</th>
                        <th>hora luz</th>
                        <th>ubicacion</th>
                        <th>bandeja</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datos as $siembra)
                        <tr>
                            <td>{{ $siembra->PlotID }}</td>
                            <td>{{ $siembra->Codigo }}</td>
                            <td>{{ $siembra->Genero }}</td>
                            <td>{{ $siembra->Variedad }}</td>
                            <td>{{ $siembra->Especie }}</td>
                            <td>{{ $siembra->PlantasSembrar }}</td>
                            <td>{{ $siembra->CantidadCanastillas }}</td>
                            <td>{{ $siembra->SemanaSiembra }}</td>
                            <td>{{ $siembra->SemanaCosecha }}</td>
                            <td>{{ $siembra->Procedencia }}</td>
                            <td>{{ $siembra->DensidadSiembra }}</td>
                            <td>{{ $siembra->HoraLuz }}</td>
                            <td>{{ $siembra->BloqueSiembra }}</td>
                            <td>{{ $siembra->TipoBandeja }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endcan
        </div>
    </div>

    <script>
        $('#Tableconfirmaciones').DataTable({
            dom: "Bfrtip",
            "paging": true,
            "order": [[12, "asc"]],
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

