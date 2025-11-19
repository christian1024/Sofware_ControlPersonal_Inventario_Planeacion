@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura Traslado</h3>
        </div>
        <form id="LecturaTrasladoPropagacion" method="get" action="{{ route('VistaLecturaTraladoPropagacion') }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

            <div class="card-body col-lg-12">

                <div class="form-row">
                    <div class="col-lg-4 ">
                        <label>Ubicacion</label>
                        <select class="labelform form-control" required id="IdUbicacion" name="IdUbicacion">
                            <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id }}"> {{ $ubicacion->Ubicacion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4 ">
                        <label>PlotId</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="PlotId" required name="PlotId">
                    </div>

                </div>

                {{-- <div class="col-lg-12 ">
                 </div>--}}

                <div id="ErrorEspacio" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>UBICACION SIN ESPACIO</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>
                <div id="Error" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>ALGO SALIO MAL</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>

                <div id="OK" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-success col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>OK</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>

                <audio id="errorsonido">
                    <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
                </audio>


            </div>
            <button style="display: none" type="submit">guardar</button>

        </form>
    </div>

    <script>

        $('#LecturaTrasladoPropagacion').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#LecturaTrasladoPropagacion').serialize();//paso todos los datos del for a una variable
            let PlotId = $("#PlotId").val();//asigno input a una variable para validar
            let token = $('#token').val();//valido el token


            if (PlotId.length >= 4) { //valido ancho tanto minimo como maximo

                $('#ErrorEspacio').hide();//si es bien no muestre
                $('#Error').hide();
                $('#OK').hide();

                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    //url: '/LoadInventoryEntry',//ruto post
                    url: '{{ route('LecturatrasladoPropagacion') }}',//ruto post
                    type: 'post',
                    success: function (Result) {
                        //console.log(Result);
                        if (Result.data === 1) {
                            $('#ErrorEspacio').hide();//si es bien no muestre
                            $('#Error').hide();
                            $('#OK').show();
                            $('#PlotId').val('');
                        } else if (Result.data === 2) {
                            $('#errorsonido')[0].play();
                            $('#ErrorEspacio').show();//si es bien no muestre
                            $('#Error').hide();
                            $('#OK').hide();
                            $('#PlotId').val('');

                        } else {
                            $('#errorsonido')[0].play();
                            $('#ErrorEspacio').hide();//si es bien no muestre
                            $('#Error').show();
                            $('#OK').hide();
                            $('#PlotId').val('');
                        }
                    }
                });
                return true;


            } else {
                $(document).ready(function () {
                    $('#errorsonido')[0].play();
                    $('#ErrorEspacio').hide();//si es bien no muestre
                    $('#Error').show();
                    $('#OK').hide();
                    $('#PlotId').val('');
                });
                return false;
            }
        });
        $('#IdUbicacion').change(function () {
            let dato = $("#IdUbicacion").val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data: {dato},
                url: '{{ route('EspacioBancos') }}',
                type: 'post',
                success: function (Result) {
                    if (Result.ok === 1) {
                        $('#errorsonido')[0].play();
                        //$('#OperarioBan').disable();
                        $("#PlotId").prop('disabled', true);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Ubicación sin espacio',
                        });
                        //swal("Error!", "Ubicación sin espacio", "error");
                    } else if (Result.ok === 2) {
                        $("#PlotId").prop('disabled', false);
                    } else {
                        $('#errorsonido')[0].play();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo salio mal',
                        });
                        $("#PlotId").prop('disabled', true);
                    }
                }
            });
        });


    </script>
@endsection
