@php

$data = json_decode($jsonData, true);
#var_dump($data);
@endphp
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card plan-box text-center">
            <div class="card-body ">

                <div id="print-html">
                    <table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;" bgcolor="transparent">
                        <tbody>
                            <tr>
                                <td class="container" width="600" style="display: block !important; max-width: 600px !important; clear: both !important;" valign="top">
                                    <div class="content">
                                        <table class="main" width="100%" cellpadding="0" cellspacing="0" style="border: 1px dashed #4d79f6;">
                                            <tbody>
                                                <tr>
                                                    <td class="content-wrap aligncenter" style="padding: 20px; background-color: transparent;" align="center" valign="top">
                                                        <table width="100%" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <a href="#"><img src="{{ asset('assets/images/logo-dark.png') }}" alt="" style="height: 40px; margin-left: auto; margin-right: auto; display:block;"></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="content-block" style="padding: 0 0 20px;" valign="top">
                                                                        <h2 class="aligncenter" style="font-family: 'Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif;font-size: 24px; color:#50649c; line-height: 1.2em; font-weight: 600; text-align: center;" align="center">Gracias por usar <span style="color: #4d79f6; font-weight: 700;">Pagos en Línea</span>.</h2>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="content-block aligncenter" style="padding: 0 0 20px;background:#f2f3f4;" align="center" valign="top">
                                                                        <table class="invoice" style="width: 80%;">
                                                                            <tbody>

                                                                                <tr>
                                                                                    <td style="padding: 5px 0;" valign="top">
                                                                                        <table class="invoice-items" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td colspan="2">
                                                                                                        <p>Estimado(a) {{ \Session::get('SESS_PERS_NOMBRE') }},</p>
                                                                                                        <p>Gracias por su pago. A continuación, encontrará los detalles de la transacción:</p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Número de Operación</td>
                                                                                                    <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top">{{ $data['PURCHASENUMBER'] }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Pagado con:</td>
                                                                                                    <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top">{{ $data['CARD'] }} ({{ $data['BRAND'] }})</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Monto pagado:</td>
                                                                                                    <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top">S/. {{ number_format($data['AMOUNT'],2) }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Empresa o institución:</td>
                                                                                                    <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top">MUNICIPALIDAD DE ANCÓN</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" valign="top">Fecha y hora del pedido:</td>
                                                                                                    <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 10px 0;" align="right" valign="top">{{ $data['TRANSACTION_DATE'] }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="alignright" width="80%" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #50649c; border-top-style: solid; border-bottom-color: #50649c; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 10px 0;" align="right" valign="top">Total</td>
                                                                                                    <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #50649c; border-top-style: solid; border-bottom-color: #50649c; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 10px 0;" align="right" valign="top">S/. {{ number_format($data['AMOUNT'],2) }}</td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="content-block aligncenter" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="content-block aligncenter" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                                        MUNICIPALIDAD DE ANCÓN
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table><!--end table-->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table><!--end table-->
                                    </div><!--end content-->
                                </td>
                                <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="{{ route('pago-en-linea') }}" class="btn btn-success">Volver</a>
                        <button class="btn btn-primary waves-effect waves-light" type="button" id="btn_print"><i class="fas fa-print"></i>&nbsp;Imprimir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#btn_print').on('click', function() {
            printDiv('print-html');
        });
    });

    function printDiv(id) {
        var divToPrint = document.getElementById(id);
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body style="text-center" onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
        newWin.document.close();
        setTimeout(function() {
            newWin.close();
        }, 10);

    }
</script>