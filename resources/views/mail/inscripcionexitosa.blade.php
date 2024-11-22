<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <style>
        table, td, div, h1, p {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body style="margin:0;padding:0;">
<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
        <td align="center" style="padding:0;">
            <table role="presentation"
                   style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                <tr>
                    <td align="center" style="padding:40px 0 30px 0;background:#27326F;">
                        <img src="http://proyectos.munisurco.gob.pe:8095/assets/images/ciar-logo.svg" alt="Logo Ciar"
                             width="300"
                             style="height:auto;display:block;"/>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 30px 42px 30px;">
                        <table role="presentation"
                               style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                            <tr>
                                <td align="center" style="padding:0 0 20px 0;color:#153643;" colspan="2">
                                    <img src="https://img.icons8.com/ios-filled/100/40C057/ok--v1.png" alt="Logo Ciar"
                                         width="100" style="height:auto;display:block;"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 0 15px 0;color:#153643;" colspan="2">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;text-align: center">
                                        Inscripción Realizada con Exito
                                    </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Hola, <strong>{{$persona}}</strong>
                                    </p>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Tu <strong>Págo fue {{$response['dataMap']['ACTION_DESCRIPTION']}}</strong>, al
                                        igual que tu inscripción al programa
                                        <strong>{{$lastRegister[0]->nombre_programa}}</strong>, a
                                        continuacion te
                                        mostramos el detalle de tu inscripción y del pago realizado.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        <strong>DETALLES DE TU INSCRIPCIÓN</strong>
                                    </p>
                                </td>
                            </tr>
                            <tr>

                            <tr>
                                <td>CODIGO DE INSCRIPCIÓN:</td>
                                <td>INS-{{$lastRegister[0]->id}}</td>
                            </tr>
                            <tr>
                                <td>SEDE:</td>
                                <td>{{$sede}}</td>
                            </tr>
                            <tr>
                                <td>CANCHA:</td>
                                <td>{{$lugar}}</td>
                            </tr>
                            <tr>
                                <td>HORARIOS:</td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>DÍAS</td>
                                            <td>HORAS</td>
                                        </tr>
                                        @foreach(json_decode($lastRegister[0]->fechas_definidas) as $fd)
                                            <tr>
                                                <td>
                                                    {{$fd->dias}}
                                                </td>
                                                <td>
                                                    {{$fd->horarios}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                </tr>
                <tr>
                    <td style="padding:15px;background:tarsparent;"></td>
                </tr>
                <tr>
                    <td>
                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                            <strong>DETALLES DE TU PAGO</strong>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td>FECHA Y HORA DE PÁGO:</td>
                    <td>{{now()->createFromFormat('ymdHis',$response['dataMap']['TRANSACTION_DATE'])->format('d/m/Y H:i:s')}}</td>
                </tr>
                <tr>
                    <td>NO. DE TARJETA:</td>
                    <td>{{$response['dataMap']['CARD']}} ({{$response['dataMap']['BRAND']}})</td>
                </tr>
                <tr>
                    <td>IMPORTE PAGADO:</td>
                    <td>{{$response['dataMap']['AMOUNT']}}</td>
                </tr>
            </table>
        </td>
        </td>
    </tr>
    <tr>
        <td style="padding:30px;background:#27326F;">
            <table role="presentation"
                   style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                <tr>
                    <td style="padding:0;width:50%;" align="left">
                        <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                            &reg; Cair Sports, Todos los derechos reservados 2021<br/><br/>
                            <a href="https://ciarsports.com/" target="_blank"
                               style="color:#ffffff;text-decoration:underline">Visitano en www.ciarsports.com</a>
                        </p>
                    </td>
                    <td style="padding:0;width:50%;" align="right">
                        <table role="presentation"
                               style="border-collapse:collapse;border:0;border-spacing:0;">
                            <tr>
                                <td style="padding:0 0 0 10px;width:38px;">
                                    <a href="https://www.facebook.com/ciar.tenis" style="color:#ffffff;">
                                        <img
                                            src="http://proyectos.munisurco.gob.pe:8095/assets/images/facebook-app-round-white-icon.png"
                                            alt="Facebok">
                                    </a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                    <a href="https://www.instagram.com/ciar.tenis/" style="color:#ffffff;">
                                        <img
                                            src="http://proyectos.munisurco.gob.pe:8095/assets/images/instagram-white-icon.png"
                                            alt="Instagram">
                                    </a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                    <a href="https://www.tiktok.com/@ciar_tenis" style="color:#ffffff;">
                                        <img
                                            src="http://proyectos.munisurco.gob.pe:8095/assets/images/tiktok-round-white-icon.png"
                                            alt="Tik Tok">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</td>
</tr>
</table>
</body>
</html>
