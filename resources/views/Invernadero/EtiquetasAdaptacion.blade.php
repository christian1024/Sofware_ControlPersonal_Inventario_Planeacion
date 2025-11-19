<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<html>
<head>

</head>
<style>
    .id {
        border: 1px solid black;

    }

    .letra {
        font-size: 10px;
        margin-top: 0.3em;
        margin-left: 0.6em;
    }
</style>
<body>

<header>
    <?php
    use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

    ?>

    <div style="margin-left: -5px; margin-top: -100px">
        <table>
            @php($count =0)
            @foreach($impresion as $impresiones)
                @if($count%3==0 || $count==0)
                    <tr class="">
                        @endif
                        <td style="width: 34mm;height: 29mm">
                            <span style="border: 1px solid #0a0a0a;padding:3px; font-size: 10px">{{ $impresiones-> SemanUltimoMovimiento }}M</span>
                            @if($impresiones-> SemanaDespacho=='')
                                <span style="border: 1px solid #0a0a0a;padding:3px; font-size: 10px"></span><br>
                            @else
                                <span style="border: 1px solid #0a0a0a;padding:3px; font-size: 10px">{{ $impresiones-> SemanaDespacho }}D</span><br>
                            @endif
                            <span colspan="3" style="font-size:9px; display: inline-block">{{ $impresiones->NombreGenero }} <span style="padding:3px; font-size: 9px; margin-left: 10px">{{ $impresiones->cliente }}</span> <br/>
                                {{ $impresiones->Nombre_Variedad }} {{ $impresiones->CodigoInterno }}</span><br>
                            <span colspan="4" style="font-size:13px; display: inline-block">{{ $impresiones-> Indentificador }}</span><br>
                            <div><span align="center" style="margin-top: 100%" colspan="4" id="BarCode">
                        <?php
                                    $barcode = new BarcodeGenerator();
                                    $barcode->setText($impresiones->BarCode);
                                    $barcode->setType(BarcodeGenerator::Code128);
                                    $barcode->setScale(0);
                                    $barcode->setThickness(15);
                                    $barcode->setFontSize(10);
                                    $code = $barcode->generate();
                                    echo '<img style="font-size:5px; display: inline-block"" src="data:image/png;base64,' . $code . '" />';
                                    ?>
                    </span>

                                <label style="margin-left:-28px; font-size:12px">-SA</label>

                            </div>

                        </td>
                        @php($count++)
                        @if($count%3==0)
                    </tr>

                    <tr class="">
                        @endif
                        <td style="width: 34mm;height: 29mm">
                            <span style="border: 1px solid #0a0a0a;padding:3px; font-size: 10px">{{ $impresiones-> SemanUltimoMovimiento }}M</span>
                            @if($impresiones-> SemanaDespacho=='')
                                <span style="border: 1px solid #0a0a0a;padding:3px; font-size: 10px"></span><br>
                            @else
                                <span style="border: 1px solid #0a0a0a;padding:3px; font-size: 10px">{{ $impresiones-> SemanaDespacho }}D</span><br>
                            @endif
                            <span colspan="3" style="font-size:9px; display: inline-block">{{ $impresiones->NombreGenero }} <span style="padding:3px; font-size: 9px; margin-left: 10px">{{ $impresiones->cliente }}</span> <br/>
                                {{ $impresiones->Nombre_Variedad }} {{ $impresiones->CodigoInterno }}</span><br>
                            <span colspan="4" style="font-size:13px; display: inline-block">{{ $impresiones-> Indentificador }}</span><br>
                            <div><span align="center" style="margin-top: 100%" colspan="4" id="BarCode">
                        <?php
                                    $barcode = new BarcodeGenerator();
                                    $barcode->setText($impresiones->BarCode);
                                    $barcode->setType(BarcodeGenerator::Code128);
                                    $barcode->setScale(0);
                                    $barcode->setThickness(15);
                                    $barcode->setFontSize(10);
                                    $code = $barcode->generate();
                                    echo '<img style="font-size:5px; display: inline-block"" src="data:image/png;base64,' . $code . '" />';
                                    ?>
                    </span>

                                <label style="margin-left:-28px; font-size:12px">-SA</label>

                            </div>

                        </td>
                        @php($count++)
                        @if($count%3==0)
                    </tr>
                @endif
            @endforeach

        </table>
    </div>
</header>


</body>

</html>
