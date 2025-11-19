@extends('layouts.Principal')
@section('content')
{{--<style>
    [class^="col-"]{
        height: 50px;
        margin-bottom:1px;
        text-align:center;
        line-height:50px;
        color:black;
    }
    .col-center {
        background: #3c8dbc;
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        border: 0 solid #000000;
        padding: 10px;
        margin-top: 70px;
        -webkit-box-shadow: inset 3px 1px 45px 5px rgba(0,0,0,0.44);
        -moz-box-shadow: inset 3px 1px 45px 5px rgba(0,0,0,0.44);
        box-shadow: inset 3px 1px 45px 5px rgba(0,0,0,0.44);
    }


    .col-center{
        float: none;
        margin-left: auto;
        margin-right: auto;
    }

    .center-block{
        float: none;
    }
</style>

    <div class="row">
        <div class="col-md-7 col-center">
            .col-center
        </div>

    </div>--}}


    <script>
        @if(session()->has('Alert'))
        $(document).ready(function () {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-full-width",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["succes"]("Pilas virus");
        });
        @endif
    </script>
@endsection

