@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura entrada</h3>
        </div>
        <form id="LecturaEntradaCuartoFrio" method="get" action="{{ route('VistaLecturaEntradaCuarto') }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

            <div class="card-body col-lg-12">
                <div class="form-row text-center">

                    <div class="col-lg-4 ">
                        <label>Codigo de Barras</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="CodigoBarras" required name="CodigoBarras">
                    </div>

                    <div class="col-lg-4 ">

                        <i class="fa fa-calculator"><label> Contador</label></i>
                        <input style="position: center; text-align: center;" placeholder="0" class="labelform form-control" id="count" disabled>

                    </div>

                </div>


                <div id="ErrorDiv" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>ERROR DE CODIGO</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>

                <div id="BarcodeYaleido" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>CODIGO YA FUE LEIDO</label>
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
                        <i class="fa fa-barcode"><label> Codigo Barras</label></i>
                        <input id="BarcodeLeido" class="labelform form-group" disabled>
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
        let cout = 1;

        $('#LecturaEntradaCuartoFrio').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#LecturaEntradaCuartoFrio').serialize();//paso todos los datos del for a una variable
            let barcode = $('#CodigoBarras').val();//asigno input a una variable para validar
            let token = $('#token').val();//valido el token


            if (barcode.length === 9) { //valido ancho tanto minimo como maximo
                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $('#OperarioEror').hide();
                $("#CodigoBarras").val('');//limpio campo

                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    //url: '/LoadInventoryEntry',//ruto post
                    url: '{{ route('LecturaEntradaCuarto') }}',//ruto post
                    type: 'post',
                    success: function (Result) {
                        // console.log(Result);
                        if (Result.data === 1) {
                            $('#BarcodeLeido').val(Result.CodigoBarras);//si es bien no muestre
                            $('#count').val(cout);//si es bien no muestre
                            cout++;
                        } else if (Result.data === 2) {
                            $('#error')[0].play();
                            $('#ErrorDiv').show();
                            $('#BarcodeYaleido').hide();
                            $("#Barcode").val('').css('border-color', 'red');
                            $('#CodigoBarras').val('').focus();
                        } else if (Result.data === 3) {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#BarcodeYaleido').show();
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                        }
                    }
                });
                return true;
            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeYaleido').hide();

                });
                return false;
            }
        });


    </script>
@endsection
