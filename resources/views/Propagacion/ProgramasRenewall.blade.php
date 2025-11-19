@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="row">

        <div class="card card-body">
            <div class="card card-primary">
                <div class="card-header text-center">
                    <h3>Programas Confirmados</h3>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <a class="btn btn-success" id="btnSalidasEstandar" href="{{ route('ExportConfirmacionesEntregadas')}}">
                            <i data-toggle="tooltip" title="Exportar Inventario"> Descargar Plots Entregados</i>
                        </a>
                    </div>
                    <div class="col-lg-12 ">
                        <div id="TablaDetalles">
                            <div class="card card-body col-lg-12">
                                <div class="col-lg-12">
                                    <div class="table">
                                        <table class="table" id="TableLoadInventory">
                                            <thead>
                                            <tr>
                                                <th>PlotID</th>
                                                <th>Codigo</th>
                                                <th>Variedad</th>
                                                <th>Genero</th>
                                                <th>Semana Confirmacion</th>
                                                <th>Plantas Confirmadas</th>
                                                <th>Accion</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($confirmaciones as $confirmacion)

                                                <tr>
                                                    <td>{{ $confirmacion->PlotIDNuevo }}</td>
                                                    <td>{{ $confirmacion->Codigo }}</td>
                                                    <td>{{ $confirmacion->Nombre_Variedad }}</td>
                                                    <td>{{ $confirmacion->NombreGenero }}</td>
                                                    <td>{{ $confirmacion->semanaConfirmacionModificada }}</td>
                                                    <td>{{ $confirmacion->plantasconfirmadas }}</td>
                                                    @if($confirmacion->Flag_Activo === '1')
                                                        <td>
                                                            <button class="btn btn-success btn-circle btn-sm" type="button" data-toggle="modal" data-target="#UpdateItem" data-whatever="{{ json_encode($confirmacion) }}" style="position: center">
                                                                <i class="fas fa-external-link-alt" title="Modificar"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-circle btn-sm" type="button" data-toggle="modal" data-target="#DeleteItem" data-whatever="{{ json_encode($confirmacion) }}" style="position: center">
                                                                <i class="fas fa-trash" title="Cancelar"></i>
                                                            </button>
                                                        </td>
                                                    @else
                                                        <td>N/A</td>
                                                    @endif

                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

    <div class="modal fade" id="UpdateItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modificar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateItem" method="POST" action="{{route('ModificarConfirmacion') }}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <input type="hidden" id="idItem" name="idItem">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Variedad</label>
                            <input disabled class="form-control" id="Nombre_Variedad" name="Nombre_Variedad">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Semana Actual</label>
                            <input disabled class="form-control" id="SemanaActual" name="SemanaActual">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Causal Movimiento </label>
                            <select class="form-control" name="CausalMovimiento" required="required" id="CausalMovimiento">
                                <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                                <option value="1">Drop</option>
                                <option value="2">Cambio en Desired CAP</option>
                                <option value="3">Espacio</option>
                                <option value="4">Fitosanidad</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Semana Nueva</label>
                            <input type="week" class="form-control" required id="semanaEntregaUpdate" name="semanaEntregaUpdate">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="DeleteItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-danger">
                    <i class="text-center fa fa-exclamation-triangle fa-5x">
                    </i>
                    <h1 class="text-danger modal-title" id="exampleModalLabel">Eliminar Confirmacion </h1>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="CancelarConfirmacion" method="POST" action="{{route('CancelarConfirmacion') }}">
                        @csrf <input type="hidden" id="idItemDelete" name="idItemDelete">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Causal cancelación </label>
                                <select class="form-control" name="CausalCancelar" required="required" id="CausalCancelar">
                                    <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                                    <option value="1">Fitosanidad</option>
                                    <option value="2">Descarte</option>
                                    <option value="3">Solicitud Cliente</option>
                                    <option value="3">Mezcla</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Cancelar Pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        $('#UpdateItem').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#Nombre_Variedad').val(data.Nombre_Variedad);
            modal.find('#idItem').val(data.id);
            modal.find('#SemanaActual').val(data.semanaConfirmacionModificada);
        });

        $('#DeleteItem').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#idItemDelete').val(data.id);

        });
        @if(session()->has('Modificado'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Perfecto',
                position: 'center',
                message: 'Modificado Correctamente',
            });
        });
        @endif

        iziToast.info({
            title: 'Recuerda',
            message: 'Confirmaciones de semana actual y dos semanas futuras',
        });
        $(document).ready(function () {

            $('#TableLoadInventory').DataTable({
                "info": true,
                dom: "Bfrtip",
                paging: true,
                buttons: [
                    'excel'
                ],
                "language": {
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
        });

    </script>
@endsection

