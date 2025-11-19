@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura Alistamiento</h3>
        </div>
        <form id="LecturaAlistamientoDespachoInvernadero" method="get" action="{{ route('VistaLecturaAlistamientoDespachoInvernadero') }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

            <div class="box box-body col-lg-12">

                <div class="form-row">
                   {{-- <div class="col-lg-4 ">
                        <label>Patinador</label>
                    </div>
                    <div class="" style="text-align: right">
                        <select class="labelform" required name="IdPatinador">
                            <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                            @foreach($patinadores as $patinadore)
                                <option value="{{ $patinadore->id }}">
                                    {{$patinadore->Primer_Nombre }}
                                    {{$patinadore->Segundo_Nombre }}
                                    {{$patinadore->Primer_Apellido}}
                                    {{$patinadore->Segundo_Apellido}}
                                </option>
                            @endforeach
                        </select>
                    </div>--}}
                    <div class="form-group col-lg-4 ">
                        <label>Operario</label>
                        <input type="number" maxlength="4" minlength="3" class="labelform form-control" autocomplete="off" id="Operario" required name="Operario">
                    </div>

                    <div class="form-group col-lg-4 ">
                        <label>Codigo de Barras</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="Barcode" required name="Barcode">
                    </div>

                    <div class="col-lg-4 form-group">

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

                <div id="BarcodeYaleido" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>BARCODE YA FUE LEIDO</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>


            </div>
            <button style="display: none" type="submit">guardar</button>

        </form>
    </div>

    <div class="">
        <div class="card card-primary card-outline form-row text-center" >
            <div>
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

            <div class="form-row ">

                <div class="col-lg-4 ">
                    <div class="col-lg-12">
                        <i class="fab fa-pagelines"> <label> Variedad</label></i>
                        <input id="VarLei" class="labelform form-group" disabled>

                    </div>
                </div>

                <div class="col-lg-4 ">
                    <div class="col-lg-12">
                        <i class="fa fa-list"><label> Cantidad</label></i>
                        <input id="Cantidalei" class="labelform form-group" disabled>
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

        $('#LecturaAlistamientoDespachoInvernadero').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#LecturaAlistamientoDespachoInvernadero').serialize();//paso todos los datos del for a una variable
            let barcode = $("#Barcode").val();//asigno input a una variable para validar
            let token = $('#token').val();//valido el token



            if (barcode.length === 9) { //valido ancho tanto minimo como maximo
                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $('#OperarioEror').hide();
                $("#Barcode").val('');//limpio campo

                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    //url: '/LoadInventoryEntry',//ruto post
                    url: '{{ route('LecturaAlistamientoDepachoInvernadero') }}',//ruto post
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
                            $('#Cantidalei').val(Result.consulta[2].Plantas);
                            $('#count').val(cout);
                            $('#Operario').val('').focus();
                            cout++;
                        } else if (Result.data === 2) {
                            $('#error')[0].play();
                            $('#ErrorDiv').show();
                            $('#BarcodeYaleido').hide();
                            $('#OperarioEror').hide();
                            $('#patinadorFinal').val('');
                            $('#EmpleadoL').val('');
                            $('#Cantidalei').val('');
                            $('#VarLei').val('');
                            $("#Barcode").css('border-color', 'red').val('');
                        } else {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#BarcodeYaleido').show();
                            $('#ErrorDiv').hide();
                            $('#OperarioEror').hide();
                            $('#error')[0].play();
                            $('#patinadorFinal').val('');
                            $('#EmpleadoL').val('');
                            $('#Cantidalei').val('');
                            $('#VarLei').val('');
                        }

                    }
                });

                return true;
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
        $("#Operario").change(function() {
            let dato = $("#Operario").val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data: {dato},
                url: '{{ route('ExisteOperario') }}',
                type: 'post',
                success: function (Result) {
                    if (Result.ok === 1) {
                        $('#error')[0].play();
                        $("#Operario").val('');
                        Swal.fire({
                            icon: 'error',
                            title:'Error',
                            text: 'Codigo Operario Erroneo',
                        });

                    }
                }
            });
        });

    </script>
@endsection
