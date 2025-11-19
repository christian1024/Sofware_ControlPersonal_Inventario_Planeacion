@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="panel panel-primary">
            <div class="card-header text-center" style="background-color: #1a8cff">
                <h3>ESTADO PLOTID PROPAGACIÓN</h3>
            </div>
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="card-primary">
                        <div class="card card-body">
                            <table id="tablaplot" class="table table-hover display nowrap col-md-12 col-lg-12 col-xl-12 cell-border">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Nombre variedad</th>
                                    <th>Genero</th>
                                    <th>PlotID</th>
                                    <th>Codigo</th>
                                    <th>Cantidad Minima</th>
                                    <th>Cantidad Entregada</th>
                                    <th>Cantidad Inventario</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($estradoplotsids as $estradoplotsid)
                                    @if($estradoplotsid->actuales+ $estradoplotsid->CantidadEntregada <= $estradoplotsid->Legalizar)
                                        <tr style="background-color: red">
                                            <th> {{ $estradoplotsid->Nombre_Variedad }}</th>
                                            <th> {{ $estradoplotsid->NombreGenero }}</th>
                                            <th> {{ $estradoplotsid->PlotIDNuevo }}</th>
                                            <th> {{ $estradoplotsid->Codigo }}</th>

                                            <th> {{ $estradoplotsid->Legalizar }}</th>
                                            <th> {{ $estradoplotsid->CantidadEntregada }}</th>
                                            <th> {{ $estradoplotsid->actuales }}</th>

                                        </tr>
                                    @else
                                        <tr>
                                            <th> {{ $estradoplotsid->Nombre_Variedad }}</th>
                                            <th> {{ $estradoplotsid->NombreGenero }}</th>
                                            <th> {{ $estradoplotsid->PlotIDNuevo }}</th>
                                            <th> {{ $estradoplotsid->Codigo }}</th>

                                            @if( $estradoplotsid->Legalizar === null)
                                                <th style="background-color: #148ea1"> Sin legalizar</th>
                                            @else
                                                <th> {{ $estradoplotsid->Legalizar }}</th>
                                            @endif
                                            <th>{{ $estradoplotsid->CantidadEntregada}}</th>
                                            <th> {{ $estradoplotsid->actuales }}</th>
                                        </tr>
                                    @endif


                                @endforeach
                                {{--
                                @foreach()
                                @endforeach
--}}
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('#tablaplot').DataTable({
            "info": true,
            dom: "Bfrtip",
            paging: true,
            buttons: [
                'excel'
            ],
            "language": {
                "search": "Buscar:",
                "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });


    </script>
@endsection

