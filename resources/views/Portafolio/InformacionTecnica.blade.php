@extends('layouts.Principal')
@section('contenidoPrincipal')
    <style>
        hr {
            margin-top: -2px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #3c8dbc;
        }
    </style>
    <div class="card">
        <div class="card-header text-center">
            <h3>Cargar Información Tecnica</h3>
        </div>
        <div class="card-body">

            <div class="col-12 form-group row">
                <div class="col-6">
                    <form id="" method="POST" action="{{ route('CargueInformacionTecnicaurc') }}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <div class="box box-body col-lg-12">
                            <div class="col-lg-12">
                                <label>Importar Archivo</label>
                                <input type="file" required name="LoadInformacionTecnica">
                                <button type="submit" style="margin-top: 10px" class="btn btn-success"> {{ __('Cargar') }} </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>


    </div>

    <script>


        @if(session()->has('Bien'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Bien',
                position: 'center',
                message: 'Se cargo la información correctamente',
            });
        });
        @endif


    </script>
@endsection
