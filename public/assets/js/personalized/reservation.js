import { validPastDateTime, sedeLugarSelection, dateNotAvailability, notRegisterUser, registeredSuccess } from './messages_reservation.js';
import { formatearFecha, formatearHora, formatearHoraMobil, formatearFechaInicial, formatearFechaFinal, validaHoraActual, obtenerSedeLugar } from './all_in_date.js';

document.addEventListener('DOMContentLoaded', function () {
    // var sede = $("#sede").val();
    $('#sede').select2({
        theme: 'bootstrap-5',
        minimumResultsForSearch: -1,
        placeholder: "Seleccionar Sede",
    });

    $('#lugar').select2({
        theme: 'bootstrap-5',
        minimumResultsForSearch: -1,
        placeholder: "Seleccionar Cancha",
    });

    setTimeout(() => {
        var sede = $('#sede').val();
        var lugar = $('#lugar').val();
        chargeCalendar(sede, lugar);
    }, 2500);

});

$('#sede').change(() => {
    var sede = $('#sede').val();
    var lugar = $('#lugar').val();
    chargeSelects(sede);
    chargeCalendar(sede, lugar);
});

$('#lugar').change(() => {
    var sede = $('#sede').val();
    var lugar = $('#lugar').val();
    chargeCalendar(sede, lugar);
});

$('#btnPagar').click(() => {
    payPlace();
});

function chargeSelects(sede) {
    axios
        .get(`/ciar/obtener/${sede}/lugares`)
        .then((resp) => {
            var lugares = resp.data;
            if (lugares.length > 0) {
                $('#lugar').html("");
                $('#lugar').append('<option value="" disabled selected>Seleccionar cancha</option>');
                lugares.forEach((e) => {
                    if (e.descripcion.includes("CAMPO")) {
                        $('#lugar').append(
                            `
                            <option value="${e.id}">${e.descripcion}</opttion>
                        `
                        );
                    }
                });
            }
        })
        .catch((err) => {
            console.log(err)
        });
}

function chargeCalendar(sede, lugar) {
    var checkLogin = $('#loginCheck').val();
    // var formulario = document.getElementById('reserva');
    // Obtener la fecha actual para bloquear los días pasados.
    moment.locale('es'); //->colocar el idioma español.
    var now = moment();  //formato pedido por el OP (los meses en español empiezan por minúscula).
    var fechaActual = now.format('YYYY-MM-DD');
    var feclimit = now.add(2, 'days');
    var fechaLimite = feclimit.format("YYYY-MM-DD");
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
        //         startTime: '10:00',
        //         endTime: '19:00',
        //         daysOfWeek: [1], //Días activos de lunes a sábado
        //         //daysOfWeek: [1, 2, 3, 4, 5, 6], //Días activos de lunes a sábado
        //     }
        // ],
        events: `/ciar/servicios/${sede}/${lugar}`,
        select: function (infoSelect) {
            var fecha = infoSelect.startStr;
            var start = infoSelect.startStr;
            var end = infoSelect.endStr;
            var valHora = validaHoraActual(start);
            var sede = $('#sede').val();
            var lugar = $('#lugar').val();

            if (valHora) {
                validPastDateTime();
            } else {
                if (checkLogin === "1") {
                    axios
                        .post("/ciar/conuslta/fecha", { start, end, sede, lugar })
                        .then((resp) => {
                            var respuesta = resp.data.msg;

                            if (respuesta == 'disponible') {
                                // formulario.reset();
                                var sedeID = $('#sede').val();

                                $('#inicio').val(start);
                                $('#fin').val(end);
                                $('#fecha').val(formatearFecha(fecha));
                                $('#horaInicio').val(formatearHora(start));
                                $('#horaFin').val(formatearHora(end));
                                obtenerSedeLugar(sedeID);
                                if (sede != null && lugar != null) {
                                    $('#modal').modal('show');
                                } else {
                                    sedeLugarSelection();
                                }
                            } else {
                                dateNotAvailability(respuesta);
                            }
                        })
                        .catch((err) => {
                            console.log(err)
                        });
                } else {
                    notRegisterUser();
                }
            }
        },
        dateClick: function (infoClick) {
            var fecha = infoClick.dateStr;
            var start = infoClick.dateStr;
            var end = formatearFechaFinal(start);
            var valHora = validaHoraActual(start);
            var sede = $('#sede').val();
            var lugar = $('#lugar').val();

            if (valHora) {
                validPastDateTime();
            } else {
                if (checkLogin == "1") {
                    if (sede != null && lugar != null) {
                        axios
                            .post("/ciar/conuslta/fecha", { start, end, sede, lugar })
                            .then((resp) => {
                                var respuesta = resp.data.msg;
                                var fecStart = formatearFechaInicial(start);
                                if (respuesta == 'disponible') {

                                    // formulario.reset();
                                    var sedeID = $('#sede').val();

                                    $('#inicio').val(fecStart);
                                    $('#fin').val(end);
                                    $('#fecha').val(formatearFecha(fecha))
                                    $('#horaInicio').val(formatearHora(start));
                                    $('#horaFin').val(formatearHoraMobil(start));
                                    obtenerSedeLugar(sedeID);
                                    if (sede != null && lugar != null) {
                                        $('#modal').modal('show');

                                    } else {
                                        sedeLugarSelection();
                                    }
                                } else {
                                    dateNotAvailability(respuesta);
                                }
                            })
                            .catch((err) => {
                                console.log(err)
                            });
                    } else {
                        sedeLugarSelection();
                    }
                } else {
                    notRegisterUser();
                }
            }
        },
    });

    calendar.render();
}

function payPlace() {
    var inicio = $('#inicio').val();
    var fin = $('#fin').val();
    var personaId = $('#personaid').val();
    var sede = $('#sede').val();
    var lugar = $('#lugar').val();
    var precio = $('#percioModal').val();
    var conluz = "";

    $('#conluz').is(':checked') ? conluz = 'ON' : conluz = 'OFF';

    const datos =
    {
        'inicio': inicio,
        'fin': fin,
        'persona_id': personaId,
        'sede': sede,
        'lugar': lugar,
        'precio': precio,
        'conluz': conluz
    }
    axios
        .post("/ciar/nueva", datos)
        .then(
            (resp) => {
                var respuesta = resp.data.msg;
                var sede = $('#sede').val();
                var lugar = $('#lugar').val();
                cleanInpust();
                $('#modal_pago').modal('hide');
                registeredSuccess(respuesta);
                chargeCalendar(sede, lugar);
            }
        )
        .catch(
            (err) => {
                console.log(err);
            });
}
