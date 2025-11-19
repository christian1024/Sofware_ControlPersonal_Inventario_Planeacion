@extends('layouts.Principal')
@section('contenidoPrincipal')


    <div class="card">
        <h4 class="card-header text-center">Virus Fitopatógenos</h4>
        <div class="card-body">
            <table class="table table-bordered" id="TableTickets">
                <thead>
                <tr class="thead-dark">
                    <th>Virus</th>
                    <th>Siglas</th>
                    <th>Permitido</th>
                </tr>
                </thead>
                <tbody>
                @foreach($virus as $viru)
                    <tr>
                        <td>{{ $viru->NombreVirus }}</td>
                        <td>{{ $viru->Siglas }}</td>

                        @if($viru->Permitido==='1')
                            <td>SI</td>
                        @else
                            <td>NO</td>
                        @endif


                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="UpdateItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="text-center fa fa-wrench fa-3x">
                    </i>
                    <h1 class="modal-title" id="exampleModalLabel">Modificar Genero </h1>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateInformacionTecnicageneros" method="POST" action="{{route('updateInformacionTecnicageneros') }}">
                        @csrf
                        <input type="hidden" name="idGenero" id="idGenero">
                        <div class="modal-body">
                            <div class="form-group">
                                <table>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <label for="recipient-name" class="col-form-label">Genero </label>
                                        </td>
                                        <td>
                                            <input class="" name="Genero" id="Genero" disabled>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="recipient-name" class="col-form-label">Index </label></td>
                                        <td>
                                            <select id="Index" class="form-control labelform" name="Index" required>
                                                <option selected="true" value="" disabled="disabled">Seleccione Uno.....</option>
                                                <option value="1">Si</option>
                                                <option value="0">N/A</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label for="recipient-name" class="col-form-label">Agro Rhodo </label></td>
                                        <td>
                                            <select id="AgroRhodo" class="form-control labelform" name="AgroRhodo" required>
                                                <option selected="true" value="" disabled="disabled">Seleccione Uno.....</option>
                                                <option value="1">Si</option>
                                                <option value="0">N/A</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label for="recipient-name" class="col-form-label">Screen </label></td>
                                        <td>
                                            <select id="Screen" class="form-control labelform" name="Screen" required>
                                                <option selected="true" value="" disabled="disabled">Seleccione Uno.....</option>
                                                <option value="1">Si</option>
                                                <option value="0">N/A</option>
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Guardar</button>
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
            console.log(data);
            modal.find('#idGenero').val(data.id);
            modal.find('#Index').val(data.Index);
            modal.find('#AgroRhodo').val(data.AgroRhodo);
            modal.find('#Screen').val(data.Screen);
            modal.find('#Genero').val(data.NombreGenero);
        });

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
    </script>
@endsection

