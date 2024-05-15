// Obtener dia actual restar uno y colotar a start date, sumar uno y colocar en end
document.addEventListener('DOMContentLoaded', function () {
    let checkLogin = $('#loginCheck').val();

    let formulario = document.getElementById('reserva');
    // Obtener la fecha actual para bloquear los días pasados.
    moment.locale('es'); //->colocar el idioma español.
    let now = moment();  //formato pedido por el OP (los meses en español empiezan por minúscula).
    let fechaActual = now.format('YYYY-MM-DD');
    let feclimit = now.add(3, 'days');
    let fechaLimite = feclimit.format("YYYY-MM-DD");

    var calendarEl = document.getElementById('reservation');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        allDaySlot: false,
        contentHeight: 20,
        dayMaxEvents: 1,
        editable: false,
        eventOverlap: false,
        eventShortHeight: 'short',
        height: 750,
        initialView: 'timeGridDay',
        locale: 'es-PE',
        selectable: true,
        slotMinTime: '08:00',
        slotMaxTime: '22:00',
        slotDuration: '01:00',
        timeZone: 'UTC',
        unselectAuto: true,
        eventBackgroundColor: '#ff6347',
        eventBorderColor: '#ff6347',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'today' // user can switch between the two
        },
        slotLabelFormat: { //se visualizara de esta manera 01:00 AM en la columna de horas
            hour: '2-digit',
            minute: '2-digit',
            hour12: true,
            meridiem: 'short'
        },
        eventTimeFormat: { //y este código se visualizara de la misma manera pero en el titulo del evento creado en fullcalendar
            hour: '2-digit',
            minute: '2-digit',
            hour12: true,
            meridiem: 'short'
        },
        validRange: {
            start: fechaActual,
            end: fechaLimite
        },
        // businessHours: [ //Horas de inactividad de las canchas
        //     {
        //         startTime: '09:00',
        //         endTime: '21:00',
        //         daysOfWeek: [1, 2, 3, 4, 5, 6], //Días activos de lunes a sábado
        //     },
        // ],
        // events: '/reservas/obtener',
        dateClick: function (info) {
            let start = info.dateStr;
            let end = null;
            let valHora = validaHoraActual(start);

            // Falta validar el controlador

            if (checkLogin === "1") {
                $('#modal').modal('show');
            } else {
                $('#modal_message').modal('show');
                $('#title_modal').html('¿No estás registrado?');
                $('#messageModal').html(
                    `
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p>Debes estar registrado para realizar tu reserva</p>
                            <p>Si ya cuentas con usuaario por favor <a href="/login">Inicia sesión.</a></p>
                        </div>
                    </div>
                    `
                );
            }

            if (valHora) {
                $('.mensaje').html('No se puede seleccionar una fecha anterior a la fecha actual.');
                $('.toast').toast('show');
            } else {
                axios
                    .post("/reserva/conuslta/fecha", { start, end })
                    .then((resp) => {
                        let respuesta = resp.data.msg;
                        console.log(start);
                        let start = formatearFechaInicial(start);
                        if (respuesta == 'ok') {
                            formulario.reset();
                            $('#modal').modal('show');
                            $('#inicio').val(formatearFechaInicial(start));
                            $('#fin').val(formatearFechaFinal(start));
                        } else {
                            $('.mensaje').html(respuesta);
                            $('.toast').toast('show');
                        }
                    })
                    .catch((err) => {
                        console.log(err)
                    });
            }
        },
        select: function (info) {
            let start = info.startStr;
            let end = info.endStr;
            let valHora = validaHoraActual(start);

            if (valHora) {
                $('.mensaje').html('No se puede seleccionar una hora anterior a la hora actual.');
                $('.toast').toast('show');
            } else {
                axios
                    .post("/reserva/conuslta/fecha", { start, end })
                    .then((resp) => {
                        let respuesta = resp.data.msg;
                        if (respuesta == 'ok') {
                            formulario.reset();
                            $('#modal').modal('show');
                            $('#inicio').val(formatearFechaInicial(start));
                            $('#fin').val(formatearFechaInicial(end));
                        } else {
                            $('.mensaje').html(respuesta);
                            $('.toast').toast('show');
                        }
                    })
                    .catch((err) => {
                        console.log(err)
                    });
            }
        }
    });

    document.getElementById('btnGuardar').addEventListener('click', function () {
        const datos = new FormData(formulario);
        axios
            .post("/reserva/agregar", datos)
            .then(
                (resp) => {
                    cleanInpust();
                    $('#modal').modal('hide');
                    calendar.refetchEvents();
                    $('.mensaje').html(resp.data.msg);
                    $('.toast').toast('show');
                }
            )
            .catch(
                (err) => {
                    console.log(err);
                }
            );
    });

    calendar.render();
});


// Formtear Fecha y Hora Inicial
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
// Formtear Fecha y Hora Final
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
