@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura Arqueo</h3>
        </div>
        <form id="LecturaArqueoPropagacion" method="get" action="{{ route('VistaLecturaArqueoPropagacion') }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

            <div class="card-body col-lg-12">

                <div class="form-row">

                    <div class="col-lg-4 ">
                        <label>Ubicacion</label>
                        <select class="labelform form-control" required id="idUbicacion" name="idUbicacion">
                            <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id }}"> {{ $ubicacion->Ubicacion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4 ">
                        <label>Cantidad Plantas</label>
                        <input type="text" class="labelform form-control" minlength="1" autocomplete="off" id="CantidadPlantas" required name="CantidadPlantas">
                    </div>

                    <div class="col-lg-4 ">
                        <label>Plotid</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="PlotIdD" required name="PlotIdD">
                    </div>
                </div>


                <div id="BarcodeYaleido" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>CODIGO YA FUE LEIDO</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>

                <div id="Error" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>ERROR</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>


            </div>
            <button style="display: none" type="submit">guardar</button>

        </form>
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
                        <i class="fa fa-user-circle"><label> Cantidad Bandejas</label></i>
                        <input id="CantBan" class="labelform form-group" disabled>
                    </div>
                </div>

            </div>

            {{-- <span id="count"></span>--}}
            <audio id="error">
                <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
            </audio>


        </div>


    </div>

    <script>


        $('#LecturaArqueoPropagacion').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#LecturaArqueoPropagacion').serialize();//paso todos los datos del for a una variable
            let PlotId = $('#PlotIdD').val();//asigno input a una variable para validar
            let token = $('#token').val();//valido el token


            if (PlotId.length >= 4) { //valido ancho tanto minimo como maximo
                $('#BarcodeYaleido').hide();//si es bien no muestre
                $('#Error').hide();

                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    //url: '/LoadInventoryEntry',//ruto post
                    url: '{{ route('LecturaArqueoProgpagacion') }}',//ruto post
                    type: 'post',
                    success: function (Result) {
                        //console.log(Result);
                        if (Result.data === 1) {
                            $('#Variedad').val(Result.consulta.Nombre_Variedad);
                            $('#PLotid').val(Result.consulta.PlotIDNuevo);
                            $('#CantBan').val(Result.consulta.CantidadBandejas);
                            $('#PlotIdD').val('');
                            $('#CantidadPlantas').val('').focus();
                        }else if(Result.data === 2){
                            $('#BarcodeYaleido').show();//si es bien no muestre
                            $('#Error').hide();
                            $('#error')[0].play();
                            $('#PlotIdD').val('');
                            $('#CantidadPlantas').val('').focus();
                        } else {
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#Error').show();
                            $('#error')[0].play();
                            $('#PlotIdD').val('');
                            $('#CantidadPlantas').val('').focus();
                        }

                    }
                });

                return true;
            } else {
                $(document).ready(function () {
                    $('#BarcodeYaleido').hide();//si es bien no muestre
                    $('#Error').show();
                    $('#error')[0].play();
                });
                return false;
            }
        });


    </script>
@endsection
