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
        Nuevo Miembro Inscrito
      </h1>
      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
        Hola, <strong>{{$mailConfirmacion->nombre_encargado}}</strong>
      </p>
      <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
        Tienes un nuevo miembro inscrito al progrma que te fue designado,
        <strong>{{$mailConfirmacion->nombre_miembro}} (Nuevo Miembro)</strong>
        te recomendamos verificar la información del miembro inscrito.
      </p>
    </td>
  </tr>
</table>
</body>
</html>
