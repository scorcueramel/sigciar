<!doctype html>
<html lang=es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title></title>
</head>
<body>
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
        Hola, <strong>{{$mailConfirmacion->nombre_miembro}}</strong>
      </p>
      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
        Tu <strong>Págo fue {{$mailConfirmacion->estado_pago}}</strong>, al igual que tu <strong>{{$mailConfirmacion->nombre_programa_actividad}}</strong>, a continuacion te mostramos el detalle de tu reserva y del pago
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
    <td>RES-{{$mailConfirmacion->registro_id}}</td>
  </tr>
  <tr>
    <td>SEDE:</td>
    <td>{{$mailConfirmacion->sede}}</td>
  </tr>
  <tr>
    <td>CANCHA:</td>
    <td>{{$mailConfirmacion->lugar}}</td>
  </tr>
  <tr>
    <td>HORA INICIO:</td>
    <td>{{$mailConfirmacion->hora_inicio}}</td>
  </tr>
  <tr>
    <td>HORA FIN:</td>
    <td>{{$mailConfirmacion->hora_fin}}</td>
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
    <td>{{$mailConfirmacion->fecha_pago}}</td>
  </tr>
  <tr>
    <td>NO. DE TARJETA:</td>
    <td>{{$mailConfirmacion->numero_tarjeta}} ({{$mailConfirmacion->brand_tarjeta}})</td>
  </tr>
  <tr>
    <td>IMPORTE PAGADO:</td>
    <td>{{$mailConfirmacion->importe_pagado}}</td>
  </tr>
</table>
</body>
</html>
