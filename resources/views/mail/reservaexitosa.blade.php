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
                        <img src="http://127.0.0.1:8000/assets/images/ciar-logo.svg" alt="Logo Ciar" width="300"
                             style="height:auto;display:block;"/>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 30px 42px 30px;">
                        <table role="presentation"
                               style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                            <tr>
                                <td align="center" style="padding:0 0 20px 0;color:#153643;">
                                    <img src="https://img.icons8.com/ios-filled/100/40C057/ok--v1.png" alt="Logo Ciar"
                                         width="100" style="height:auto;display:block;"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 0 15px 0;color:#153643;">
                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;text-align: center">
                                        Reserva Realizada con Exito
                                    </h1>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Hola, <strong>{{$persona}}</strong>
                                    </p>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Tu <strong>Págo fue {{$response['dataMap']['ACTION_DESCRIPTION']}}</strong>, al igual que tu reserva de cancha, a continuacion te mostramos el detalle de tu reserva y del pago
                                        realizado.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        <strong>DETALLES DE TU RESERVA</strong>
                                    </p>
                                </td>
                            </tr>
                            <tr>

                            <tr>
                                <td>CODIGO DE RESERVA:</td>
                                <td>RES-{{$lastRegister[0]->id}}</td>
                            </tr>
                            <tr>
                                <td>SEDE:</td>
                                <td>{{$lastRegister[0]->sede}}</td>
                            </tr>
                            <tr>
                                <td>CANCHA:</td>
                                <td>{{$lastRegister[0]->lugar}}</td>
                            </tr>
                            <tr>
                                <td>HORA INICIO:</td>
                                <td>{{Str::of($lastRegister[0]->inicio)->explode(' ')[1]}}</td>
                            </tr>
                            <tr>
                                <td>HORA FIN:</td>
                                <td>{{Str::of($lastRegister[0]->fin)->explode(' ')[1]}}</td>
                            </tr>
                            <tr><td style="padding:15px;background:tarsparent;"></td></tr>
                            <tr >
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
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             shape-rendering="geometricPrecision"
                                             text-rendering="geometricPrecision"
                                             image-rendering="optimizeQuality" fill-rule="evenodd"
                                             clip-rule="evenodd" viewBox="0 0 512 510.125">
                                            <path fill="#fff" fill-rule="nonzero"
                                                  d="M512 256C512 114.615 397.385 0 256 0S0 114.615 0 256c0 120.059 82.652 220.797 194.157 248.461V334.229h-52.79V256h52.79v-33.709c0-87.134 39.432-127.521 124.977-127.521 16.218 0 44.202 3.18 55.651 6.36v70.916c-6.042-.635-16.537-.954-29.575-.954-41.977 0-58.196 15.901-58.196 57.241V256h83.619l-14.365 78.229h-69.254v175.896C413.771 494.815 512 386.885 512 256z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                    <a href="https://www.instagram.com/ciar.tenis/" style="color:#ffffff;">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             shape-rendering="geometricPrecision"
                                             text-rendering="geometricPrecision"
                                             image-rendering="optimizeQuality" fill-rule="evenodd"
                                             clip-rule="evenodd" viewBox="0 0 512 512">
                                            <path fill="#fff" fill-rule="nonzero"
                                                  d="M170.663 256.157c-.083-47.121 38.055-85.4 85.167-85.483 47.121-.092 85.407 38.03 85.499 85.16.091 47.129-38.047 85.4-85.176 85.492-47.112.09-85.399-38.039-85.49-85.169zm-46.108.091c.141 72.602 59.106 131.327 131.69 131.186 72.592-.141 131.35-59.09 131.209-131.692-.141-72.577-59.114-131.335-131.715-131.194-72.585.141-131.325 59.115-131.184 131.7zm237.104-137.091c.033 16.953 13.817 30.681 30.772 30.648 16.961-.033 30.689-13.811 30.664-30.764-.033-16.954-13.818-30.69-30.78-30.657-16.962.033-30.689 13.818-30.656 30.773zm-208.696 345.4c-24.958-1.087-38.511-5.234-47.543-8.709-11.961-4.629-20.496-10.178-29.479-19.094-8.966-8.95-14.532-17.46-19.202-29.397-3.508-9.032-7.73-22.569-8.9-47.527-1.269-26.982-1.559-35.077-1.683-103.432-.133-68.339.116-76.434 1.294-103.441 1.069-24.942 5.242-38.512 8.709-47.536 4.628-11.977 10.161-20.496 19.094-29.479 8.949-8.982 17.459-14.532 29.403-19.202 9.025-3.525 22.561-7.714 47.511-8.9 26.998-1.277 35.085-1.551 103.423-1.684 68.353-.132 76.448.108 103.456 1.295 24.94 1.086 38.51 5.217 47.527 8.709 11.968 4.628 20.503 10.144 29.478 19.094 8.974 8.95 14.54 17.443 19.21 29.412 3.524 9 7.714 22.553 8.892 47.494 1.285 26.999 1.576 35.095 1.7 103.433.132 68.355-.117 76.451-1.302 103.441-1.087 24.958-5.226 38.52-8.709 47.561-4.629 11.952-10.161 20.487-19.103 29.471-8.941 8.949-17.451 14.531-29.403 19.201-9.009 3.517-22.561 7.714-47.494 8.9-26.998 1.269-35.086 1.559-103.448 1.684-68.338.132-76.424-.125-103.431-1.294zM149.977 1.773c-27.239 1.285-45.843 5.648-62.101 12.018-16.829 6.561-31.095 15.354-45.286 29.604C28.381 57.653 19.655 71.944 13.144 88.79c-6.303 16.299-10.575 34.912-11.778 62.168C.172 178.264-.102 186.973.031 256.489c.133 69.508.439 78.234 1.741 105.547 1.302 27.231 5.649 45.828 12.019 62.093 6.569 16.83 15.353 31.088 29.611 45.288 14.25 14.201 28.55 22.918 45.404 29.438 16.282 6.295 34.902 10.583 62.15 11.778 27.305 1.203 36.022 1.468 105.521 1.335 69.532-.132 78.25-.439 105.555-1.733 27.239-1.303 45.826-5.665 62.1-12.019 16.829-6.586 31.095-15.353 45.288-29.611 14.191-14.251 22.917-28.55 29.428-45.405 6.304-16.282 10.592-34.903 11.777-62.134 1.195-27.322 1.478-36.048 1.344-105.556-.133-69.516-.447-78.225-1.741-105.523-1.294-27.255-5.657-45.844-12.019-62.118-6.577-16.829-15.352-31.079-29.602-45.287-14.25-14.192-28.55-22.935-45.404-29.429-16.29-6.305-34.903-10.601-62.15-11.779C333.747.164 325.03-.102 255.506.031c-69.507.133-78.224.431-105.529 1.742z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td style="padding:0 0 0 10px;width:38px;">
                                    <a href="https://www.tiktok.com/@ciar_tenis" style="color:#ffffff;">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             shape-rendering="geometricPrecision"
                                             text-rendering="geometricPrecision"
                                             image-rendering="optimizeQuality" fill-rule="evenodd"
                                             clip-rule="evenodd" viewBox="0 0 512 512">
                                            <path fill="#fff"
                                                  d="M256 0c141.384 0 256 114.616 256 256 0 141.384-114.616 256-256 256C114.616 512 0 397.384 0 256 0 114.616 114.616 0 256 0zm82.937 174.75c-14.614-9.524-25.152-24.771-28.445-42.535a65.235 65.235 0 01-1.102-11.831h-46.631l-.075 186.877c-.783 20.928-18.009 37.724-39.119 37.724a38.912 38.912 0 01-18.186-4.503c-12.478-6.565-21.016-19.641-21.016-34.691 0-21.614 17.588-39.201 39.194-39.201 4.035 0 7.907.667 11.566 1.809v-47.603c-3.789-.517-7.64-.836-11.566-.836-47.323-.001-85.824 38.499-85.824 85.831 0 29.037 14.504 54.733 36.643 70.272 13.94 9.791 30.901 15.553 49.189 15.553 47.324 0 85.825-38.5 85.825-85.825v-94.765c18.288 13.124 40.698 20.859 64.877 20.859v-46.631c-13.022 0-25.152-3.87-35.33-10.504z"/>
                                        </svg>
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
