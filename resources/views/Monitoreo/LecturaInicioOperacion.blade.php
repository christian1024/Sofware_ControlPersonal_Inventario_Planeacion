@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura Entrada Empleado</h3>
        </div>

        <div class="card border-secondary text-center">

            <div class="card-body">
                <form id="ViewLecturaEntradaCuartoOperario" method="get" action="{{ route('ViewLecturaEntradaCuartoOperario') }}">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

                    <div class="">

                        <div class="form-row">


                            <div class="col-lg-4 ">
                                <label>Codigo de Operario</label>
                                <input type="text" class="labelform form-control" autocomplete="off" id="CodOperario" required name="CodOperario">
                            </div>

                            <div class="col-lg-4 ">

                                <i class="fa fa-calculator"><label> Contador</label></i>
                                <input style="position: center; text-align: center;" placeholder="0" class="labelform form-control" id="count" disabled>

                            </div>
                            <div id="ErrorDiv" class="col-lg-12 " style="margin-top: 10px; display: none">
                                <div class="col-lg-4 "></div>
                                <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                                    <label>ERROR CODIGO</label>
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

                    </div>
                    <button style="display: none" type="submit">guardar</button>
                </form>
            </div>
        </div>

    </div>

    <div class="">
        <div class="card card-primary card-outline form-row text-center">
            <div style="display: flex; justify-content:center; align-items: center;">
                <h4>Ultima Lectura</h4>
            </div>
            <hr>

            <div class="row">

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-barcode"><label> Empleado</label></i>
                        <input id="Empleado" class="labelform form-group" disabled>
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

        $('#ViewLecturaEntradaCuartoOperario').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#ViewLecturaEntradaCuartoOperario').serialize();//paso todos los datos del for a una variable
            let CodOperario = $("#CodOperario").val();//asigno input a una variable para validar
            let token = $('#token').val();//valido el token

            if (CodOperario.length >= 3) { //valido ancho tanto minimo como maximo

                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    url: '{{ route('LecturaEntradaCuartoOperario') }}',//ruto post
                    type: 'post',
                    success: function (Result) {
                        //console.log(Result.consulta);
                        if (Result.data === 1) {
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#Empleado').val(Result.consulta.Primer_Nombre +' ' +Result.consulta.Primer_Apellido);
                            $('#count').val(cout);
                            $('#CodOperario').val('').focus();
                            $('#ErrorDiv').hide();
                            cout++;
                        }  else {
                            $('#error')[0].play();
                            $('#ErrorDiv').show();
                            $('#BarcodeYaleido').hide();
                            $('#OperarioEror').hide();
                            $("#CodOperario").val('').css('border-color', 'red');
                            $('#CodOperario').val('').focus();
                            $('#Empleado').val('');
                        }

                    }
                });
                return true;
            } else {
                // console.log('no entro');
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeYaleido').hide();
                    $('#OperarioEror').hide();
                    $("#Barcode").val('').css('border-color', 'red');
                    $('#Barcode').val('').focus();
                    $('#VarLei').val('');
                });
                return false;
            }

        });


    </script>
@endsection
