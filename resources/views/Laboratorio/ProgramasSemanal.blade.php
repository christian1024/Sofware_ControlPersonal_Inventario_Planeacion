@extends('layouts.Principal')
@section('contenidoPrincipal')
    <style>
        ul.navega li {
            display: inline;
            padding-right: 0.5em;
        }
    </style>
    <div class="card">
        <div class="">
            @can('CargarProgramasImports')
                <div class="col-lg-12">
                    <h3>Cargar Programas</h3>
                    <form id="" method="POST" action="{{ route('CargarExceleProgramas') }}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <label>Cargar Programas</label>
                                <input type="file" required name="ImportPrograms">
                            </div>
                            <div class="col-lg-6">
                                <button type="submit" style="margin-top: 10px" class="btn btn-success"> {{ __('Cargar') }} </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endcan

            @can('vistaProgramasImports')
                <div class="col-lg-12">
                    <h3>Vista Porgramas</h3>
                    <div class="form-row">

                        <div class="col-lg-2">
                            <div class="col-lg-1" style="background-color: red;  border: black 1px solid;   height: 15px;    width: 3px;">
                            </div>
                            <div class=""><p>Sin Formar</p></div>
                        </div>
                        <div class="col-lg-3">
                            <div class="col-lg-1" style="background-color: #00ca6d;  border: black 1px solid;   height: 15px;    width: 3px;">
                            </div>
                            <div class=""><p>Cantidad Inferior Semana Correcta</p></div>
                        </div>
                        <div class="col-lg-3">
                            <div class="col-lg-1" style="background-color: #0b93d5;  border: black 1px solid; height: 15px;    width: 3px;">
                            </div>
                            <div class=""><p>Cantidad Inferior Semana Diferente</p></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="col-lg-1" style="background-color: white;  border: black 1px solid; height: 15px;    width: 3px;">
                            </div>
                            <div class=""><p>Ok</p></div>
                        </div>
                        <div class="col-lg-2">
                            <p><b>Total Cargados={{ $datosImport }}</b></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="table-responsive">
                            <table class="" id="TableLoadInventory" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Codigo Variedad</th>
                                    <th>Genero Variedad</th>
                                    <th>Nombre Variedad</th>
                                    <th>Semana Despacho</th>
                                    <th>Cantidad Programada</th>
                                    <th>Cantidad Ejecutada</th>
                                    <th>Cliente</th>
                                    <th>Fase</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($count=1)
                                @foreach($datas as $data)
                                    @if( $data->Estado==='1')
                                        <tr style="background-color: red">
                                            <td>{{ $count }}</td>
                                            <td>{{ $data->CodigoVariedad }}</td>
                                            <td>{{ $data->NombreGenero }}</td>
                                            <td>{{ $data->Nombre_Variedad }}</td>
                                            <td>{{ $data->SemanaDespacho }}</td>
                                            <td>{{ $data->CantidadSolicitada }}</td>
                                            <td>{{ $data->Ejecutado }}</td>
                                            <td>{{ $data->cliente }}</td>
                                            <td>{{ $data->FaseGenerada }}</td>
                                            @if($data->Estado==='1')
                                                <td>Sin Etiquetas</td>
                                            @elseif($data->Estado==='2')
                                                <td>Ejecutado semana Correcta</td>
                                            @elseif($data->Estado==='3')
                                                <td>Ejecutado en otra semana</td>
                                            @elseif($data->Estado==='5')
                                                <td>Invernadero</td>
                                            @endif
                                        </tr>

                                    @elseif($data->CantidadSolicitada > $data->Ejecutado && $data->Estado==='2')
                                        <tr style="background-color: #00ca6d">
                                            <td>{{ $count }}</td>
                                            <td>{{ $data->CodigoVariedad }}</td>
                                            <td>{{ $data->NombreGenero }}</td>
                                            <td>{{ $data->Nombre_Variedad }}</td>
                                            <td>{{ $data->SemanaDespacho }}</td>
                                            <td>{{ $data->CantidadSolicitada }}</td>
                                            <td>{{ $data->Ejecutado }}</td>
                                            <td>{{ $data->cliente }}</td>
                                            <td>{{ $data->FaseGenerada }}</td>
                                            @if($data->Estado==='1')
                                                <td>Sin Formar</td>
                                            @elseif($data->Estado==='2')
                                                <td>Ejecutado semana Correcta</td>
                                            @elseif($data->Estado==='3')
                                                <td>Ejecutado en otra semana</td>
                                            @elseif($data->Estado==='5')
                                                <td>Invernadero</td>
                                            @endif
                                        </tr>

                                    @elseif($data->CantidadSolicitada > $data->Ejecutado && $data->Estado==='3')
                                        <tr style="background-color: #0b93d5">
                                            <td>{{ $count }}</td>
                                            <td>{{ $data->CodigoVariedad }}</td>
                                            <td>{{ $data->NombreGenero }}</td>
                                            <td>{{ $data->Nombre_Variedad }}</td>
                                            <td>{{ $data->SemanaDespacho }}</td>
                                            <td>{{ $data->CantidadSolicitada }}</td>
                                            <td>{{ $data->Ejecutado }}</td>
                                            <td>{{ $data->cliente }}</td>
                                            <td>{{ $data->FaseGenerada }}</td>
                                            @if($data->Estado==='1')
                                                <td>Sin Formar</td>
                                            @elseif($data->Estado==='2')
                                                <td>Ejecutado semana Correcta</td>
                                            @elseif($data->Estado==='3')
                                                <td>Ejecutado en otra semana</td>
                                            @elseif($data->Estado==='5')
                                                <td>Invernadero</td>
                                            @endif
                                        </tr>

                                    @elseif($data->CantidadSolicitada > $data->Ejecutado && $data->Estado==='5')
                                        <tr style="background-color: red">
                                            <td>{{ $count }}</td>
                                            <td>{{ $data->CodigoVariedad }}</td>
                                            <td>{{ $data->NombreGenero }}</td>
                                            <td>{{ $data->Nombre_Variedad }}</td>
                                            <td>{{ $data->SemanaDespacho }}</td>
                                            <td>{{ $data->CantidadSolicitada }}</td>
                                            <td>{{ $data->Ejecutado }}</td>
                                            <td>{{ $data->cliente }}</td>
                                            <td>{{ $data->FaseGenerada }}</td>
                                            @if($data->Estado==='1')
                                                <td>Sin Formar</td>
                                            @elseif($data->Estado==='2')
                                                <td>Ejecutado semana Correcta</td>
                                            @elseif($data->Estado==='3')
                                                <td>Ejecutado en otra semana</td>
                                            @elseif($data->Estado==='5')
                                                <td>Invernadero</td>
                                            @endif
                                        </tr>

                                    @else
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $data->CodigoVariedad }}</td>
                                            <td>{{ $data->NombreGenero }}</td>
                                            <td>{{ $data->Nombre_Variedad }}</td>
                                            <td>{{ $data->SemanaDespacho }}</td>
                                            <td>{{ $data->CantidadSolicitada }}</td>
                                            <td>{{ $data->Ejecutado }}</td>
                                            <td>{{ $data->cliente }}</td>
                                            <td>{{ $data->FaseGenerada }}</td>
                                            @if($data->Estado==='1')
                                                <td>Sin Formar</td>
                                            @elseif($data->Estado==='2')
                                                <td>Ejecutado semana Correcta</td>
                                            @elseif($data->Estado==='3')
                                                <td>Ejecutado en otra semana</td>
                                            @elseif($data->Estado==='5')
                                                <td>Invernadero</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @php($count++)
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>



    <script>

        TableLoadInventory = $('#TableLoadInventory').DataTable({
            dom: "Bfrtip",
            paging: true,
            "language": {
                "search": "Buscar:",
                "info": 'Total Activos _TOTAL_',// "Mostrando Página False, Registros Inactivos _TOTAL_",
                "paginate": {
                    "first": 'Primero',
                    "last": 'Ultimo',
                    "next": 'Siguiente',
                    "previous": 'Anterior',
                }
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                    titleAttr: 'Excel',
                },
            ],

            orderCellsTop: true,
            scrollX: true,
            iDisplayLength: 100,
            fixedHeader: true,

        });


    </script>
@endsection
