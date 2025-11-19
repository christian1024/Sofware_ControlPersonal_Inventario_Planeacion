@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="row">
        <div class="card card-body">
            <div class="card card-primary">
                <div class="card-header text-center">
                    <h3>Confirmación</h3>
                </div>
                <div class="card-body">
                    <div class="col-lg-12 row">
                        <div class="col-lg-2 ">
                            <label>PlotId</label>
                            <input type="text" class="labelform form-control" autocomplete="off" id="PlotIdD" required name="PlotIdD">
                        </div>

                        <div class="col-lg-2 ">
                            <label>PLantas Disponibles</label>
                            <input type="text" class="labelform form-control" autocomplete="off" id="Plantas" disabled name="Plantas">
                        </div>
                    </div>
                    <div style="display: none" id="divConfirmacion">
                        <form id="ConfirmarPedidosForm" method="POST" class="form-group col-lg-9" action="{{ route('GuardaConfirmacionesPropagacion') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <input type="hidden" id="PlotId" required name="PlotId">
                            <input type="hidden" id="PlantasDispinibles" required name="PlantasDisponibles">
                            <div>
                                <label>Cantidad Confirmaciones</label>
                                <select class="labelform form-control" name="CantConfirmaciones" id="CantConfirmaciones">
                                    <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>

                            <div class="table-responsive">
                                <div>
                                    <div class="col-lg-2 ">
                                        <label>Total Plantas</label>
                                        <input type="text" class="labelform form-control" autocomplete="off" id="TotalPlantas" disabled name="TotalPlantas">
                                    </div>
                                </div>
                                <table class="table">
                                    <thead class="text-center thead-dark">
                                    <tr>
                                        <th scope="col">Plantas</th>
                                        <th scope="col">Semana</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr id="Confirmacion1" style="display: none">
                                        <td><input name="CantidadAdicional-{{ 1 }}" id="CantidadAdicional-{{ 1 }}" CLASS="form-control labelform monto" onkeyup="sumar();"></td>
                                        <td><input type="week" name="SemanaConfirmacion-{{ 1 }}" id="SemanaConfirmacion-{{ 1 }}" autocomplete="off" CLASS="form-control labelform"></td>
                                    </tr>
                                    <tr id="Confirmacion2" style="display: none">
                                        <td><input name="CantidadAdicional-{{ 2 }}" id="CantidadAdicional-{{ 2 }}" CLASS="form-control labelform monto" onkeyup="sumar();"></td>
                                        <td><input type="week" name="SemanaConfirmacion-{{2}}" id="SemanaConfirmacion-{{2}}" autocomplete="off" CLASS="form-control labelform"></td>
                                    </tr>
                                    <tr id="Confirmacion3" style="display: none">
                                        <td><input name="CantidadAdicional-{{ 3 }}" id="CantidadAdicional-{{ 3 }}" CLASS="form-control labelform monto" onkeyup="sumar();"></td>
                                        <td><input type="week" name="SemanaConfirmacion-{{3}}" id="SemanaConfirmacion-{{3}}" autocomplete="off" CLASS="form-control labelform"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <button class="btn btn-success" type="button" id="Guardar">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
    </div>

    <script>

        function sumar() {
            var total = 0;
            $(".monto").each(function () {
                if (isNaN(parseFloat($(this).val()))) {
                    total += 0;
                } else {
                    total += parseFloat($(this).val());
                }
            });
            $('#TotalPlantas').val(total);
        }

        $(document).ready(function () {

            $('#PlotIdD').change(function (event) {
                event.preventDefault();
                let PlotIdD = $('#PlotIdD').val();
                let token = $('#token').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {PlotIdD: PlotIdD},
                    url: '{{ route('ConsultarPlotConfiracion') }}',
                    type: 'post',

                    success: function (Result) {
                        if (Result.data === 1) {
                            $('#Plantas').val(Result.consulta.CantidaPlantasPropagacionInventario);
                            $('#divConfirmacion').show();
                            $('#PlotId').val(Result.consulta.PlotIDNuevo);
                            $('#PlantasDispinibles').val(Result.consulta.CantidaPlantasPropagacionInventario);
                        } else if (Result.data === 2) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Plot ya confirmado',
                            });
                            $('#PlotIdD').val('');
                        } else if (Result.data === 3) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Sin inventario',
                            });
                            $('#PlotIdD').val('');
                        }
                    },
                });

            });

            $('#CantConfirmaciones').change(function () {
                let cant = $(this).val();
                $('#divConfirmacion').show();
                if (cant === '1') {
                    $('#Confirmacion1').show();
                    $('#Confirmacion2').hide();
                    $('#Confirmacion3').hide();
                } else if (cant === '2') {
                    $('#Confirmacion1').show();
                    $('#Confirmacion2').show();
                    $('#Confirmacion3').hide();
                } else if (cant === '3') {
                    $('#Confirmacion1').show();
                    $('#Confirmacion2').show();
                    $('#Confirmacion3').show();
                }
            });

            $('#Guardar').click(function () {
                let divConfirmacion = $('#divConfirmacion').val()
                let token = $('#token').val();
                let plantasTotalConfirmar = parseInt($('#TotalPlantas').val());
                let PlantasDisponibles = parseInt($('#PlantasDispinibles').val());
                let CantiSelect = $('#CantConfirmaciones').val()

                if (CantiSelect === '1') {
                    if ($('#CantidadAdicional-1').val() === '' || $('#SemanaConfirmacion-1').val() === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Digite Tota la Informacion',
                        });
                    }
                } else if (CantiSelect === '2') {
                    if ($('#CantidadAdicional-1').val() === '' || $('#SemanaConfirmacion-1').val() === '' ||
                        $('#CantidadAdicional-2').val() === '' || $('#SemanaConfirmacion-2').val() === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Digite Tota la Informacion',
                        });
                    }
                } else if (CantiSelect === '3') {
                    if ($('#CantidadAdicional-1').val() === '' || $('#SemanaConfirmacion-1').val() === '' ||
                        $('#CantidadAdicional-2').val() === '' || $('#SemanaConfirmacion-2').val() === '' ||
                        $('#CantidadAdicional-3').val() === '' || $('#SemanaConfirmacion-3').val() === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Digite Tota la Informacion',
                        });
                    }
                }


                if (plantasTotalConfirmar > PlantasDisponibles) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Total Confirmacion Mayor a lo disponible',
                    });
                } else {
                    let DatosEviados = $('#ConfirmarPedidosForm').serialize();
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        dataType: 'json',
                        data: DatosEviados,
                        url: '{{route('GuardaConfirmacionesPropagacion')}}',
                        type: 'post',

                        success: function (Result) {
                            if (Result.data === 1) {
                                iziToast.success({
                                    //timeout: 20000,
                                    title: 'Perfecto',
                                    position: 'center',
                                    message: 'Guardado Exitosamente',
                                });
                                window.location.href = '/Propagacion/ViewConfirmacionesPropagacion';
                            } else if (Result.data === 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'confirmando sobre la misma semana',
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Llamar a sistemas',
                                });
                            }
                        }
                    });
                }
            });

        });
    </script>
@endsection


