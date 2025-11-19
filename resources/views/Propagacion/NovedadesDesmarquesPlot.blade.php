@extends('layouts.Principal')
@section('contenidoPrincipal')


    <div class="card">
        <h4 class="card-header text-center">Novedades Semana Actual</h4>

        <div class="card-body">
            @can('NewNovedadPropagacion')
                <div>
                    <div class="card-header">
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">Nueva Novedad</button>
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
                        <th>Causal Desmarque</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($plotNovedades as $plotNovedad)
                        <tr>
                            <th>{{ $plotNovedad->PlotID }}</th>
                            <th>{{ $plotNovedad->Codigo }}</th>
                            <th>{{ $plotNovedad->NombreGenero }}</th>
                            <th>{{ $plotNovedad->Nombre_Variedad }}</th>
                            <th>{{ $plotNovedad->NombreEspecie }}</th>
                            <th>{{ $plotNovedad->CantidadPlantas }}</th>
                            <th>5</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endcan
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="newNovedadRenewall" method="POST" action="{{ route('newNovedadRenewall') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header text-center" style="background-color:#1fc8e3">
                        <h5 class="modal-title" id="exampleModalLabel">Nueva Novedad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">PlotID</label>
                            </div>
                            <select class="custom-select" id="Plot" name="plot" required>
                                <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                @foreach($plots as $plot)
                                    <option value="{{ $plot->PlotId }}">{{$plot->PlotId  }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Desmarcado Por</label>
                            </div>
                            <select class="custom-select" id="causalDesmarque" name="causalDesmarque" required>
                                <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                               @foreach($causalesFito as $causalesFit)
                                   <option value="{{ $causalesFit->id }}">{{ $causalesFit->Causal }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Cantidad Entregar</label>
                            <input type="number" class="form-control" id="CantidadPlantas" name="CantidadPlantas" required aria-describedby="emailHelp" placeholder="Cantidad Plantas">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>

        @if(session()->has('Exitoso'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Perfecto',
                position: 'center',
                message: 'Guardado Exitosamente',
            });
        });
        @endif

        @if(session()->has('error'))
        $(document).ready(function () {
            iziToast.error({
                //timeout: 20000,
                title: 'Error',
                position: 'center',
                message: 'Ha ocurrio algo',
            });
        });
        @endif
        $('#Tableconfirmaciones').DataTable({
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

