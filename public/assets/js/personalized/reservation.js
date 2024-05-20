import swalmessage from "./Swal.js";
import { formatearFecha, formatearHora, formatearFechaInicial, formatearFechaFinal, validaHoraActual, obtenerSedeLugar } from './all_in_date.js';

document.addEventListener('DOMContentLoaded', function () {
    let checkLogin = $('#loginCheck').val();
    let formulario = document.getElementById('reserva');
    var sede = $("#sede").val();
    var lugar = $("#lugar").val();

    $('#sede').change(() => {
        sede = $('#sede').val();
        $('#lugar').change(() => {
            lugar = $('#lugar').val();
        });
        axios
            .get(`/ciar/obtener/${sede}/lugares`)
            .then((resp) => {
                let lugares = resp.data;
                if (lugares.length > 0) {
                    $('#lugar').html("");
                    $('#lugar').append('<option value="" disabled selected>Seleccionar cancha</option>');
                    lugares.forEach((e) => {
                        $('#lugar').append(
                            `
                            <option value="${e.id}">${e.descripcion}</opttion>
                            `
                        );
                    });
                }
            })
            .catch((err) => {
                console.log(err)
            });
    });
    // Obtener la fecha actual para bloquear los días pasados.
    moment.locale('es'); //->colocar el idioma español.
    let now = moment();  //formato pedido por el OP (los meses en español empiezan por minúscula).
    let fechaActual = now.format('YYYY-MM-DD');
    let feclimit = now.add(2, 'days');
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
        events: '/ciar/obtener',
        dateClick: function (info) {
            let fecha = info.dateStr;
            let start = info.dateStr;
            let end = null;
            let valHora = validaHoraActual(start);
            let lugar = $('#lugar').val();

            if (valHora) {
                swalmessage("warning", "Ups!", "No se puede seleccionar una <strong>fecha u hora anterior a la actual.</strong>", true, true, false, "", "Cerrar", "", "", false);
            } else {
                if (checkLogin === "1") {
                    axios
                        .post("/ciar/reservations/conuslta/fecha", { start, end })
                        .then((resp) => {
                            let respuesta = resp.data.msg;
                            let start = formatearFechaInicial(start);
                            if (respuesta == 'ok') {
                                formulario.reset();
                                let sedeID = $('#sede').val();
                                $('#inicio').val(formatearFechaInicial(start));
                                $('#fin').val(formatearFechaFinal(start));
                                $('#fecha').val(formatearFecha(fecha))
                                $('#horaInicio').val(horaSalida(start));
                                $('#horaFin').val(horaSalida(start));
                                obtenerSedeLugar(sedeID);
                                if (sede != null && lugar != null) {
                                    $('#modal').modal('show');
                                } else {
                                    swalmessage(
                                        "warning",
                                        "Ups!",
                                        "Recuerda seleccionar una <strong>SEDE</strong> y posteriormente una <strong>CANCHA</strong> para realizar tu reserva",
                                        true,
                                        true,
                                        false,
                                        "",
                                        "Cerrar",
                                        "",
                                        "",
                                        false
                                    );
                                }
                            } else {

                            }
                        })
                        .catch((err) => {
                            console.log(err)
                        });
                } else {
                    swalmessage(
                        "warning",
                        "¿No estás registrado?",
                        `
                            <div class="text-center">
                                <p>Debes estar registrado para realizar tu reserva, da click en el botón <strong>Registrate</strong>.</p>
                                <p>Si ya cuentas con usuario por favor <a href="/login">Inicia sesión.</a></p>
                            </div>
                            `,
                        true,
                        true,
                        true,
                        `<a href="/register" class="text-decoration-none text-white">Registrate</a>`,
                        "Cerrar",
                        "",
                        "",
                        true,
                        false
                    );
                }
            }
        },
        select: function (info) {
            let fecha = info.startStr;
            let start = info.startStr;
            let end = info.endStr;
            let valHora = validaHoraActual(start);
            let lugar = $('#lugar').val();

            if (valHora) {
                swalmessage(
                    "warning",
                    "Ups!",
                    "No se puede seleccionar una <strong>fecha u hora anterior a la actual.</strong>",
                    true,
                    true,
                    false,
                    "",
                    "Cerrar",
                    "",
                    "",
                    false
                );
            } else {
                if (checkLogin === "1") {
                    axios
                        .post("/ciar/reservations/conuslta/fecha", { start, end })
                        .then((resp) => {
                            let respuesta = resp.data.msg;

                            if (respuesta == 'ok') {
                                formulario.reset();
                                let sedeID = $('#sede').val();
                                $('#inicio').val(formatearFechaInicial(start));
                                $('#fin').val(formatearFechaInicial(end));
                                $('#fecha').val(formatearFecha(fecha));
                                $('#horaInicio').val(formatearHora(start));
                                $('#horaFin').val(formatearHora(end));
                                obtenerSedeLugar(sedeID);
                                if (sede != null && lugar != null) {
                                    $('#modal').modal('show');
                                } else {
                                    swalmessage(
                                        "warning",
                                        "Ups!",
                                        "Recuerda seleccionar una <strong>SEDE</strong> y posteriormente una <strong>CANCHA</strong> para realizar tu reserva",
                                        true,
                                        true,
                                        false,
                                        "",
                                        "Cerrar",
                                        "",
                                        "",
                                        false
                                    );
                                }
                            } else {
                                // $('.mensaje').html(respuesta);
                            }
                        })
                        .catch((err) => {
                            console.log(err)
                        });
                } else {
                    swalmessage(
                        "warning",
                        "¿No estás registrado?",
                        `
                            <div class="text-center">
                                <p>Debes estar registrado para realizar tu reserva.</p>
                                <p>Si ya cuentas con usuario por favor <a href="/login">Inicia sesión.</a></p>
                            </div>
                        `,
                        true,
                        true,
                        true,
                        `<a href="/register" class="text-decoration-none text-white">Registrate</a>`,
                        "Cerrar",
                        "",
                        "",
                        true,
                        false
                    );
                }
            }
        }
    });

    document.getElementById('btnPagar').addEventListener('click', function () {
        const datos = new FormData(formulario);
        axios
            .post("/reserva/agregar", datos)
            .then(
                (resp) => {
                    cleanInpust();
                    $('#modal').modal('hide');
                    calendar.refetchEvents();
                    swalmessage(
                        "success",
                        "Reserva Realizada",
                        `
                            <div class="text-center">
                                <p>Tu reserva se realizó con exito</p>
                            </div>
                        `,
                        true,
                        true,
                        true,
                        "",
                        "Cerrar",
                        "",
                        "",
                        true,
                        false
                    );
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
