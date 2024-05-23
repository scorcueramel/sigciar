// Formtear Fecha Para Mostrar
function formatearFecha(fecha) {
    var fecha = fecha;
    var fecha_date = fecha.split('T');
    fecha_date = fecha_date[0];
    var fecha_format = fecha_date.split('-');
    var fecha_salida = fecha_format[2] + '/' + fecha_format[1] + '/' + fecha_format[0]
    return fecha_salida;
}
// Formtear Hora Para Mostrar
function formatearHora(hora) {
    var fecha = hora;
    var fecha_date = fecha.split('T');
    var fecha_time = fecha_date[1].split(':');
    fecha_date = fecha_date[0];
    var horaSalida = fecha_time[0] + ':' + fecha_time[1];
    return horaSalida;
}

// Formtear Fecha y Hora Inicial Para Almacenar
function formatearFechaInicial(fechaHoraInicial) {
    var fecha = fechaHoraInicial;
    var fecha_date = fecha.split('T');
    var fecha_time = fecha_date[1].split(':');
    fecha_date = fecha_date[0];
    var fecha_format = fecha_date.split('-');
    var fecha_salida = fecha_format[2] + '/' + fecha_format[1] + '/' + fecha_format[0]
    var fechaHoraInicialFormat = fecha_salida + ' ' + fecha_time[0] + ':' + fecha_time[1];
    return fechaHoraInicialFormat;
}
// Formtear Fecha y Hora Final Para Almacenar
function formatearFechaFinal(fechaHoraFinal) {
    var fecha = fechaHoraFinal;
    var fecha_date = fecha.split('T');
    var fecha_time = fecha_date[1].split(':');
    fecha_date = fecha_date[0];
    var fecha_format = fecha_date.split('-');
    var fecha_salida = fecha_format[2] + '/' + fecha_format[1] + '/' + fecha_format[0]
    var fechaHoraFinalFormat = fecha_salida + ' ' + (parseInt(fecha_time[0]) + 1) + ':' + fecha_time[1];
    return fechaHoraFinalFormat;
}
// Validar hora actual
function validaHoraActual(hora) {
    let start = hora;
    let fechaHoraActual = new Date();
    let horaActual = fechaHoraActual.getHours();
    let horaSelecc = formatearFechaInicial(start);
    let horaSplit = horaSelecc.split(" ");
    let horaSeleccionada = horaSplit[1].slice(0, 2);
    let fechaActual = fechaHoraActual.getDate();
    let fechaSeleccionada = horaSplit[0].slice(0, 2);


    if (fechaSeleccionada == fechaActual) {
        if (horaSeleccionada > horaActual) {
            return false;
        } else {
            return true;
        }
    }
    if (fechaSeleccionada > fechaActual) {
        return false;
    }

    if (fechaSeleccionada < fechaActual) {
        return true;
    }
}

function obtenerSedeLugar(id) {

    let sedeTXT = $('#sede option:selected').text();
    let lugarTXT = $('#lugar option:selected').text();

    $('#sedeModal').val(sedeTXT);

    $.ajax({
        type: "GET",
        url: `/publico/ciar/obtener/${id}/lugares`,
        success: function (res) {
            let respuesta = res;
            respuesta.forEach((e) => {
                if (e.descripcion == lugarTXT.trim()) {
                    $('#lugarModal').val(e.descripcion);
                    $('#percioModal').val(e.costohora);
                    $('#percioModalMostrar').val(e.costohora + '.00');
                }
            });
        }
    });
}

export { formatearFecha, formatearHora, formatearFechaInicial, formatearFechaFinal, validaHoraActual, obtenerSedeLugar };
