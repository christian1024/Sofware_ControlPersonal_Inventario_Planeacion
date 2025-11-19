@extends('layouts.Principal')
@section('contenidoPrincipal')


    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura Despute</h3>
        </div>
        <form id="LecturaEntradaDespunte" method="get" action="{{ route('LecturaDespunte') }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-lg-4 ">
                        <label>Operario</label>
                        <input type="number" maxlength="4" minlength="3" class="labelform form-control" autocomplete="off" id="Operario" required name="Operario">
                    </div>


                    <div class="col-lg-4 ">
                        <label>Codigo de Barras</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="Barcode" required name="Barcode">
                    </div>

                    <div class="col-lg-4 ">
                        <i class="fa fa-calculator"><label> Contador</label></i>
                        <input style="position: center; text-align: center;" placeholder="0" class="labelform form-control" id="count" disabled>

                    </div>

                </div>


                <div id="ErrorDiv" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>ERROR BARCODE</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>


                <div id="OperarioEror" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>OPERARIO NO EXISTE</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>
            </div>
            <button style="display: none" type="submit">guardar</button>

        </form>
    </div>

    <div class="text-center">
        <div class="card card-primary card-outline">
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

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Empleado</label></i>
                        <input id="EmpleadoL" class="labelform form-group" disabled>
                    </div>
                </div>

                <div class="col-lg-4 ">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Patinador</label></i>
                        <input class="labelform form-group" id="patinadorFinal" disabled>
                    </div>
                </div>
            </div>

            <div class="form-row">

                <div class="col-lg-4 ">
                    <div class="col-lg-12">
                        <i class="fab fa-pagelines"> <label> Variedad</label></i>
                        <input class="labelform form-group" id="VarLei" disabled>
                    </div>
                </div>

                <div class="col-lg-4 ">
                    <div class="col-lg-12">
                        <i class="fa fa-list"><label> Cantidad</label></i>
                        <input id="Cantidalei" class="labelform form-group" disabled>
                    </div>
                </div>

                {{-- <div class="col-lg-4 ">
                     <div class="col-lg-12">
                         <img src="{{ asset('img/counter.png') }}" height="25" width="25">
                         <label>Contador</label>
                         <input style="position: center; text-align: center;" placeholder="0" class="labelform form-group" id="count" disabled>
                     </div>
                 </div>--}}
            </div>

            {{-- <span id="count"></span>--}}
            <audio id="error">
                <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
            </audio>


        </div>


    </div>

    <script>
        let cout = 1;
        $('#LecturaEntradaDespunte').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#LecturaEntradaDespunte').serialize();//paso todos los datos del for a una variable
            let barcode = $("#Barcode").val();//asigno input a una variable para validar
            let token = $('#token').val();//valido el token
            let Operario = $('#Operario').val();//valido el token


            if (barcode.length === 9) { //valido ancho tanto minimo como maximo
                if (Operario.length === 4) {
                    $('#ErrorDiv').hide();//si es bien no muestre
                    $('#BarcodeYaleido').hide();
                    $('#OperarioEror').hide();
                    $("#Barcode").val('');//limpio campo

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},//toekn
                        data: DatosEviados,//datos que envio
                        //url: '/LoadInventoryEntry',//ruto post
                        url: '{{ route('LecturaEntradaDespunte') }}',//ruto post
                        type: 'post',
                        success: function (Result) {
                            //console.log(Result);
                            if (Result.data === 1) {
                                $('#BarcodeYaleido').hide();//si es bien no muestre
                                $('#OperarioEror').hide();
                                $('#BarcodeLeido').css('border-color', '').val(Result.barcode);
                                $('#patinadorFinal').val(Result.consulta[0].Primer_Nombre + ' ' + Result.consulta[0].Segundo_Nombre + ' ' + Result.consulta[0].Primer_Apellido + ' ' + Result.consulta[0].Segundo_Apellido);
                                $('#EmpleadoL').val(Result.consulta[1].Primer_Nombre + ' ' + Result.consulta[1].Segundo_Nombre + ' ' + Result.consulta[1].Primer_Apellido + ' ' + Result.consulta[1].Segundo_Apellido);
                                $('#VarLei').val(Result.consulta[2].Nombre_Variedad);
                                $('#Cantidalei').val(Result.consulta[2].CantContenedor);
                                $('#count').val(cout);
                                cout++;
                            } else if (Result.data === 0) {
                                $('#error')[0].play();
                                $('#ErrorDiv').show();
                                $('#BarcodeYaleido').hide();
                                $('#OperarioEror').hide();
                                $('#patinadorFinal').val('');
                                $('#EmpleadoL').val('');
                                $('#Cantidalei').val('');
                                $('#VarLei').val('');
                                $("#Barcode").val('').css('border-color', 'red');
                            }
                        }
                    });
                    return true;
                } else {
                    $(document).ready(function () {
                        $('#error')[0].play();
                        $('#OperarioEror').show();
                        $('#ErrorDiv').hide();
                        $('#BarcodeYaleido').hide();
                        $("#Barcode").val('').css('border-color', 'red');
                        $('#patinadorFinal').val('');
                        $('#EmpleadoL').val('');
                        $('#Cantidalei').val('');
                        $('#VarLei').val('');
                    });
                }

            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeYaleido').hide();
                    $('#OperarioEror').hide();
                    $("#Barcode").val('').css('border-color', 'red');
                    $('#patinadorFinal').val('');
                    $('#EmpleadoL').val('');
                    $('#Cantidalei').val('');
                    $('#VarLei').val('');
                });
                return false;
            }
        });

        $("#Operario").change(function () {
            let dato = $("#Operario").val();
            //alert('entro');
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data: {dato},
                url: '{{ route('ExisteOperarioLab') }}',
                type: 'post',
                success: function (Result) {
                    if (Result.ok === 1) {
                        $('#error')[0].play();
                        $("#Operario").val('');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Codigo Operario Erroneo',
                        });

                    }
                }
            });
        });


    </script>
@endsection
