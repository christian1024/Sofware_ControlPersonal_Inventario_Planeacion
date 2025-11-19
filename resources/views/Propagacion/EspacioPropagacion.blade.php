@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="panel panel-primary">
            <div class="card-header text-center" style="background-color: #1a8cff">
                <h3>Espacio Propagación</h3>
            </div>
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="card-primary">
                        <div class="card card-body">
                            <table id="TablaDetallesPrograma" class="table table-hover display nowrap col-md-12 col-lg-12 col-xl-12 cell-border">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Ubicación</th>
                                    <th>Total Bandejas</th>
                                    <th>Bandejas en Ubicacion</th>
                                    <th>Disponibilidad Bandejas</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($espacios as $espacio)
                                    @if($espacio->Disponibilida<='15')
                                        <tr style="background-color: #ff9999">
                                            <th> {{ $espacio->Ubicacion }}</th>
                                            <th> {{ $espacio->CapacidadBandejas }}</th>
                                            <th> {{ $espacio->cantidadBandejas }}</th>
                                            <th> {{ $espacio->Disponibilida }}</th>
                                        </tr>
                                    @else
                                        <tr>
                                            <th> {{ $espacio->Ubicacion }}</th>
                                            <th> {{ $espacio->CapacidadBandejas }}</th>
                                            <th> {{ $espacio->cantidadBandejas }}</th>
                                            <th> {{ $espacio->Disponibilida }}</th>
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


    </script>
@endsection

