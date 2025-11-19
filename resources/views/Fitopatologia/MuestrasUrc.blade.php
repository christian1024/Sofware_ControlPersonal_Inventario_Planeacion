@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <div style="margin-top:10px; display: flex; justify-content:center; align-items: center;">
                <h3>DETALLE DE PROGRAMA </h3>
            </div>
            <hr>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col">
                    <div class="col">
                        <label class="col">Identificador</label>
                        <div class="col">
                            <input class="labelform  form-control" value="{{ $IdentificadorC }}" disabled/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <div class="card card-body col-lg-12">
                <div class="table table-responsive ">
                    <table class="table table-hover" id="TablaDetallesPedido">
                        <thead>
                        <tr>
                            <th>Codigo de Barras</th>
                            <th>Index</th>
                            <th>Screen</th>
                            <th>Agro Rhodo</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($DetallesIntro as $DetalleIntro)
                            <tr>

                                <td>{{ $DetalleIntro->CodigoBarras }}</td>

                                <td>
                                    @if($DetalleIntro->ResultadoIndex === null)
                                        <a href="{{ route('IndexPositivo',['id'=>encrypt($DetalleIntro->CodigoBarras)]) }}" class="btn btn-danger" data-placement="left" data-toggle="tooltip" data-html="true" style="position: center"><i class="fa fa-plus-circle"></i> </a>
                                        <a href="{{ route('IndexNegativo',['id'=>encrypt($DetalleIntro->CodigoBarras)]) }}" class="btn btn-success" data-placement="left" data-toggle="tooltip" title="Ver Detalles Aceptados" style="position: center"><i class="fa fa-minus-circle"></i> </a>
                                    @else
                                        @if($DetalleIntro->ResultadoIndex === 'NEGATIVO' || $DetalleIntro->ResultadoIndex === 'OK')
                                            NEGATIVO
                                        @else
                                            POSITIVO
                                        @endif
                                    @endif
                                </td>

                                <td>
                                    @if($DetalleIntro->MuestrasScreen === null)

                                        <button class="btn btn-success btn-circle btn-sm" type="button" data-toggle="modal" data-target="#Resultadoscreen" data-whatever="{{ json_encode($DetalleIntro) }}" style="position: center">
                                            <i class="fas fa-external-link-alt" title="Modificar"></i>
                                        </button>

                                    @else
                                        @if($DetalleIntro->MuestrasScreen === 'N/A' )
                                            {{$DetalleIntro->MuestrasScreen}}
                                        @else
                                            @if($DetalleIntro->PositivosMuestrasScreen=== null)
                                                NEGATIVO
                                            @else
                                                POSITIVO
                                            @endif
                                        @endif
                                    @endif
                                </td>

                                <td>
                                    {{$DetalleIntro->AgroRhodoPruebaUno}}
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
                {{--<a id="GuardarPlaneacion" class="btn btn-success btn-block">Guardar Planeación</a>--}}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Resultadoscreen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('ResultadoScreen') }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">RESULTADO SCREEN</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        @csrf
                        <input type="hidden" id="CodigoBarras" name="CodigoBarras">


                        <div class="form-group">
                            <label>Muestras Realizadas</label>
                            <br>
                            <select class="selectpicker" data-show-subtext="true" name="MuestraRealizadas[]" id="MuestraRealizadas" data-live-search="true" multiple data-actions-box="true" data-selected-text-format="count > 10" required="required">

                                @foreach( $virus as $viru)
                                    <option value=" {{ $viru->Siglas }}">{{ $viru->NombreVirus }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="">
                            <label>Resultados Positivos</label>
                            <br>

                            <select class="selectpicker" data-show-subtext="true" name="MuestraRealizadasPositivas[]" id="MuestraRealizadasPositivas" data-live-search="true" multiple data-actions-box="true" data-selected-text-format="count > 10">

                                @foreach( $virus as $viru)
                                    <option value=" {{ $viru->Siglas }}"> {{ $viru->NombreVirus }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="">
                            <label>Resultados Positivos Restrictivos</label><br>

                            <select class="selectpicker" data-show-subtext="true" name="MuestraRealizadasPositivasRestringidos[]" id="MuestraRealizadasPositivasRestringidos" data-live-search="true" multiple data-actions-box="true" data-selected-text-format="count > 10">


                            </select>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" value="{{ csrf_token() }}" name="token" id="token">
    <script>
        let token = $('#token').val();
        $('#Resultadoscreen').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#CodigoBarras').val(data.CodigoBarras);

        });

        $('#MuestraRealizadasPositivas').change(function () {
            let Muestra = $('#MuestraRealizadasPositivas').val();
            console.log(Muestra);
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                data: {Muestra},
                url: '{{ route('SelectRestingidos') }}',
                type: 'post',
                success: function (Result) {
                    //  console.log(Result);
                    $("#MuestraRealizadasPositivasRestringidos").empty().selectpicker('destroy');
                    $("#MuestraRealizadasPositivasRestringidos").append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
                    $.each(Result.Data, function (i, item) {
                        $("#MuestraRealizadasPositivasRestringidos").append('<option value="' + item.Siglas + '">' + item.NombreVirus + '</option>');
                    });
                    $('#MuestraRealizadasPositivasRestringidos').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    // console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });


    </script>
@endsection

