@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura Descarte</h3>
        </div>
        <form id="LecturaDescartePropagacion" method="get" action="{{ route('VistaLecturaDescartePropagacion') }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

            <div class="box box-body col-lg-12">

                <div class="form-row">

                    <div class="col-lg-4 ">
                        <label>PlotId</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="PlotIdD" required name="PlotIdD">
                    </div>
                    <div class="col-lg-4">
                        <label>Tipo Descarte</label>
                        <select class="labelform form-control" name="idCausalDescarte">
                            <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                            @foreach($causaleSalidas as $causaleSalida)
                                <option value="{{ $causaleSalida->id }}"> {{ $causaleSalida->CausalDescarte }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 ">
                        <label>Plantas Descartadas</label>
                        <input type="number" min="0" class="labelform form-control" autocomplete="off" id="PlantasDescarte" required name="PlantasDescarte">
                    </div>
                </div>

            </div>
            <button style="display: none" type="submit">guardar</button>

        </form>
        <div id="OperarioEror" class="col-lg-12 " style="margin-top: 10px; display: none">
            <div class="col-lg-4 "></div>
            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                <label>PLOTID EN CERO</label>
            </div>
            <div class="col-lg-4 "></div>
        </div>
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

            {{-- <span id="count"></span>--}}
            <audio id="error">
                <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
            </audio>



        </div>


    </div>

    <script>

        $(document).ready(function () {
            $('#LecturaDescartePropagacion').submit(function (event) {
                event.preventDefault();
                let DatosEviados = $('#LecturaDescartePropagacion').serialize();//paso todos los datos del for a una variable
                let PlotId = $("#PlotIdD").val();//asigno input a una variable para validar
                let token = $('#token').val();//valido el token


                if (PlotId.length >= 4) { //valido ancho tanto minimo como maximo
                    $('#ErrorDiv').hide();//si es bien no muestre
                    $('#BarcodeYaleido').hide();
                    $('#OperarioEror').hide();

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},//toekn
                        data: DatosEviados,//datos que envio
                        //url: '/LoadInventoryEntry',//ruto post
                        url: '{{ route('LecturaDescartePropagacion') }}',//ruto post
                        type: 'post',
                        success: function (Result) {
                            //console.log(Result);
                            if (Result.data === 1) {
                                $('#OperarioEror').hide();
                                $('#Variedad').val(Result.consulta.Nombre_Variedad);
                                $('#PLotid').val(Result.consulta.PlotIDNuevo);
                                $('#CantPL').val(Result.consulta.CantidaPlantasPropagacionInventario);
                                $('#PlotIdD').val('').focus();
                                $('#PlantasDescarte').val('').focus();
                            }else if(Result.data === 3){
                                $('#error')[0].play();
                                $('#ErrorCant').show();
                            } else {
                                $('#BarcodeYaleido').show();
                                $('#ErrorDiv').hide();
                                $('#error')[0].play();
                                $('#OperarioEror').show();
                                $('#PlotIdD').val('').focus();
                                $('#PlantasDescarte').val('').focus();
                            }

                        }
                    });

                    return true;
                } else {
                    $(document).ready(function () {
                        $('#BarcodeYaleido').show();
                        $('#ErrorDiv').hide();
                        $('#OperarioEror').hide();
                        $('#error')[0].play();
                        $('#PlotIdD').val('').focus();
                        $('#PlantasDescarte').val('').focus();
                    });
                    return false;
                }
            });

            $("#PlotIdD").on('input',function(e){
                //alert("Handler for .change() called.");
                event.preventDefault();
                let PlotIdD = $("#PlotIdD").val();//asigno input a una variable para validar
                let token = $('#token').val();//valido el token
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: {PlotIdD:PlotIdD},//datos que envio
                    //url: '/LoadInventoryEntry',//ruto post
                    url: '{{ route('ConsultarBandeja') }}',//ruto post
                    type: 'post',
                    success: function (Result) {
                         console.log(Result);
                        if (Result.data === 1) {
                            $('#Variedad').val(Result.consulta.Nombre_Variedad);
                            $('#PLotid').val(Result.consulta.PlotIDNuevo);
                            $('#CantPL').val(Result.consulta.CantidaPlantasPropagacionInventario);

                        } else if (Result.data === 2) {
                            $('#Variedad').val(Result.consulta.Nombre_Variedad);
                            $('#PLotid').val(Result.consulta.PlotIDNuevo);
                            $('#CantPL').val(Result.consulta.CantidaPlantasPropagacionInventario);
                        }
                    }
                });
            });
        });


    </script>
@endsection
