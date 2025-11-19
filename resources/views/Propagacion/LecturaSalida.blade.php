@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura Salida</h3>
        </div>
        <form id="VistaLecturaSalidaPropagacion" method="get" action="{{ route('VistaLecturaSalidaPropagacion') }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

            <div class="card col-lg-12">

                <div class="form-row">
                    <div class="col-lg-4 ">
                        <label>PlotID</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="PlotIdD" required name="PlotIdD">
                    </div>
                    <div class="col-lg-4 ">
                        <label>Cantidad Plantas Despachar</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="CantPlantas" required name="CantPlantas">
                    </div>
                </div>
            </div>
            <button style="display: none" type="submit">guardar</button>

        </form>
        <div id="ErrorCant" class="col-lg-12 " style="margin-top: 10px; display: none">
            <div class="col-lg-4 "></div>
            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                <label>ERROR DE CANTIDAD</label>
            </div>
            <div class="col-lg-4 "></div>
        </div>
    </div>

    <div class="">
        <div class="card card-primary card-outline form-row text-center">
            <div style="display: flex; justify-content:center; align-items: center;">
                <h4>Ultima Lectura</h4>
            </div>
            <hr>
            <div class="form-row">

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Variedad</label></i>
                        <input id="Variedad" class="labelform form-group" disabled>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> PlotId</label></i>
                        <input id="PLotid" class="labelform form-group" disabled>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Cantidad Plantas</label></i>
                        <input id="CantPL" class="labelform form-group" disabled>
                    </div>
                </div>
            </div>
            <audio id="error">
                <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
            </audio>


        </div>


    </div>

    <script>
        let cout = 1;

        $(document).ready(function () {
            $('#PlotIdD').change(function (event) {
                event.preventDefault();
                let PlotID = $('#PlotIdD').val();
                let token = $('#token').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {PlotIdD: PlotID},
                    url: '{{ route('PropagacionConfirmacionesSalidas') }}',
                    type: 'post',

                    success: function (Result) {
                        if (Result.data === 1) {
                            $('#CantPlantas').prop('disabled', false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Plot sin confirmacion esta semana',
                            });
                            $('#PlotID').val('');
                            $('#CantPlantas').prop('disabled', true);
                            //$('#CantPlantas').val('');
                        }
                    },
                });

            });

            $('#VistaLecturaSalidaPropagacion').submit(function (event) {
                event.preventDefault();
                let PlotIdD = $("#PlotIdD").val();//asigno input a una variable para validar
                let PlotID = $('#PlotIdD').val();
                let token = $('#token').val();

                if (PlotIdD.length >= 4) { //valido ancho tanto minimo como maximo
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: {PlotIdD: PlotID},
                        url: '{{ route('PropagacionConfirmacionesSalidas') }}',
                        type: 'post',
                        success: function (Result) {
                            if (Result.data === 1) {
                                let DatosEviados = $('#VistaLecturaSalidaPropagacion').serialize();//paso todos los datos del for a una variable

                                let token = $('#token').val();//valido el token
                                $('#ErrorCant').hide();//si es bien no muestre
                                $('#BarcodeYaleido').hide();
                                $('#OperarioEror').hide();
                                $("#CodigoBarras").val('');//limpio campo

                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': token},//toekn
                                    data: DatosEviados,//datos que envio
                                    //url: '/LoadInventoryEntry',//ruto post
                                    url: '{{ route('LecturaSalidaDespachoPropagacion') }}',//ruto post
                                    type: 'post',
                                    success: function (Result) {
                                        //console.log(Result);
                                        if (Result.data === 1) {
                                            $('#OperarioEror').hide();
                                            $('#Variedad').val(Result.consulta.Nombre_Variedad);
                                            $('#PLotid').val(Result.consulta.PlotIDNuevo);
                                            $('#CantPL').val(Result.consulta.CantidaPlantasPropagacionInventario);
                                            $('#PlotIdD').val('').focus();
                                            $('#CantPlantas').val('');
                                        }else if(Result.data === 2){
                                            $('#error')[0].play();
                                            $('#ErrorCant').show();
                                            $('#PlotIdD').val('').focus();
                                            $('#CantPlantas').val('');
                                        } else {
                                            $('#BarcodeYaleido').show();
                                            $('#ErrorCant').hide();
                                            $('#ErrorDiv').hide();
                                            $('#error')[0].play();
                                            $('#OperarioEror').show();
                                            $('#PlotIdD').val('').focus();
                                            $('#CantPlantas').val('');
                                        }
                                    }
                                });
                                return true;
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Solicite revisión del plot',
                                });
                                $('#PlotID').val('').focus();
                                $('#CantPlantas').prop('disabled', true);
                            }
                        },
                    });



                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo salio Mal',
                    });
                    $('#PlotID').val('');
                    $('#CantPlantas').prop('disabled', true);
                }
            });

        });


    </script>
@endsection
