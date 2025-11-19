<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html lang="es">
<head>
    <title>Carnet</title>


</head>
<body>

<header>
    <?php
    use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator as BarcodeGeneratorAlias;
    ?>

    <div style="margin-left: -5px; margin-top: -50px">
        <table>
            @php($count =0)
            @foreach($DatosCar as $Datos)
                @if($Datos->id_tipocontratos !=3)
                    @if($count%3==0 || $count==0)
                        <tr class="">
                            @endif
                            <td style="width: 40mm;height: 90mm">
                                <div>
                                    <img src="{{ public_path('imagenes/hex0.jpg') }}"/>
                                </div>

                                <div style="margin-top: -255px; margin-left: 45px">
                                <span>
                                    @if( $Datos->img === null)
                                        <img src="{{ public_path('imagenes/Noimg.png') }} " class="card-img-top" width="117" height="154" alt="User Image">
                                    @else
                                        <img src="{{ public_path('imagenes/') }}/{{ $Datos->img }}" class="card-img-top" width="117" height="154" alt="User Image">
                                    @endif
                                </span>
                                </div>

                                <div style="text-align: center; left: -5px; width: 200px; position: relative">
                                <span style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif; font-size: 12px; ">
                                        <b>{{ $Datos->Primer_Nombre }} {{ $Datos->Primer_Apellido }}<br>
                                        {{ $Datos->Cargo }}<br>
                                        {{--{{ $Datos->Area }}--}}
                                    </b>
                                </span>


                                    <div>
                                        <?php
                                        // use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator as BarcodeGeneratorAlias;
                                        $barcode = new BarcodeGeneratorAlias();
                                        $barcode->setText($Datos->Codigo_Empleado);
                                        $barcode->setType(BarcodeGeneratorAlias::Code128);
                                        $barcode->setScale(2);
                                        $barcode->setThickness(15);
                                        $barcode->setFontSize(5);
                                        $code = $barcode->generate();
                                        echo '<img style="font-size:7px; display: inline-block"" src="data:image/png;base64,' . $code . '" />';
                                        ?>
                                    </div>

                                    <div style="position: absolute; margin-left:180px; margin-top: -50px">
                                <span style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif; font-size: 12px;">
                                    <b>COD</b>
                                    <b>{{ $Datos->Codigo_Empleado }}</b>
                                </span>
                                    </div>


                                </div>


                            </td>
                            @php($count++)
                            @if($count%3==0)
                        </tr>
                    @endif
                @else
                    @if($count%3==0 || $count==0)
                        <tr class="">
                            @endif
                            <td style="width: 40mm;height: 90mm">
                                <div>
                                    <img src="{{ public_path('imagenes/CarnetTemporal.jpg') }}"/>
                                </div>

                                <div style="margin-top: -225px; margin-left: 45px">
                                <span>
                                    <h2> <strong> EMPLEADO</strong> </h2>
                                    <h2><strong> TEMPORAL </strong></h2>
                                </span>
                                </div>

                            </td>
                            @php($count++)
                            @if($count%3==0)
                        </tr>
                    @endif

                @endif

            @endforeach
        </table>
    </div>
</header>


{{--<img src="{{ asset('imagenes/hex0.jpg') }} " class="img-circle" alt="User Image">--}}
</body>
</html>
