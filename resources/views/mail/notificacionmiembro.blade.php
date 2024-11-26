<h1>Inscripcion Exitosa</h1>
<h3>Hola, {{$nombre_miembro}}</h3>
<p>Tu págo fue {{$estado_pago}}</p>
<p>Te inscribiste al programa {{$nombre_programa}}</p>
<p>Código de tu registro {{$registro_id}}</p>
<p>La sede a la que te inscribiste es {{$sede}}</p>
<p>El número de cancha {{$lugar}}</p>
<p>Tu horario es</p>
<table>
    <tr>
        <td>DÍAS</td>
        <td>HORAS</td>
    </tr>
    @foreach(json_decode($fechasDefinidas) as $fd)
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
<p>Realizaste tu pago el {{$fecha_pago}}</p>
<p>No. de tarjeta utilizada {{$nro_tarjeta}} ({{$brand_tarjeta}})</p>
<p>Monto pagado {{$importe_pagado}}</p>
