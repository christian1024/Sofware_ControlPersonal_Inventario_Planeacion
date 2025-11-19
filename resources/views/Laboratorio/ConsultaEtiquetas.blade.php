@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="box-body">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 style="text-align: center">Consulta Etiqueta</h3>
            </div>
            <div class="panel-body">
                <div class="col-lg-12 ">
                    <a class="btn btn-success" target="_blank" href="{{ route('ImprimirEtq') }}">Imprimir</a>

                    <a class="btn btn-success" target="_blank" href="{{ route('ImprimirEtqSA') }}">Imprimir SA</a>
                   {{-- <form id="CargarProgramas" method="POST" action="{{ route('ImprimirEtq') }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        --}}{{--<div class="col-lg-2 ">
                            <label>Cuarto</label>
                            <select class="labelform form-control" id="IDCuarto2" name="IDCuarto2">
                                <option selected="true" value="" disabled="disabled">Seleccione Cuarto</option>
                                @foreach( $cuartosAc as $cuartosAcv)
                                    <option value=" {{ $cuartosAcv->id }}"> {{ __('Cuarto') }} {{ $cuartosAcv->N_Cuarto }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 ">
                            <label>Estante</label>
                            <select class="labelform form-control" id="IDEstante2" name="IDEstante2">

                            </select>
                        </div>

                        <div class="col-lg-2 ">
                            <label>Nivel</label>
                            <select class="labelform form-control" id="IDPiso2" name="IDPiso2">

                            </select>
                        </div>

                        <div class="col-lg-2 ">
                            <label for="Idetinficador" class="col-form-label text-md-right">{{ __('Idetinficador') }}</label>
                            <input id="Idetinficador" name="Idetinficador" class="form-control labelform">
                        </div>--}}{{--

                        <div class="col-lg-2">
                            <button class="btn btn-success"  type="submit">Imprimir</button>
                        </div>
                    </form>
--}}

                </div>
            </div>
        </div>


    </div>
    {{--<input type="hidden" value="{{ csrf_token() }}" name="token" id="token">--}}
    <script>
        $(document).ready(function () {

            $('#IDCuarto2').change(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: '/Cuarto/' + this.value + '/Cuarto',
                    success: function (Result) {

                        $("#IDEstante2").empty().selectpicker('destroy');
                        $("#IDEstante2").append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
                        $.each(Result.Data, function (i, item) {
                            $("#IDEstante2").append('<option value="' + item.id + '">' + item.N_Estante + '</option>');
                        });
                        $('#IDEstante2').selectpicker({
                            size: 4,
                            liveSearch: true,
                        });
                    },
                    error: function (e) {
                        //console.log(e);
                        $.each(error.responseJSON.errors, function (i, item) {
                            alertify.error(item)
                        });
                    }
                });
            });

            $('#IDEstante2').change(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: '/Estante/' + this.value + '/Estante',
                    success: function (Result) {

                        $("#IDPiso2").empty().selectpicker('destroy');
                        $("#IDPiso2").append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
                        $.each(Result.Data, function (i, item) {
                            $("#IDPiso2").append('<option value="' + item.id + '">' + item.N_Nivel + '</option>');
                        });
                        $('#IDPiso2').selectpicker({
                            size: 4,
                            liveSearch: true,
                        });
                    },
                    error: function (e) {
                        //console.log(e);
                        $.each(error.responseJSON.errors, function (i, item) {
                            alertify.error(item)
                        });
                    }
                });
            });
        });
    </script>
@endsection

