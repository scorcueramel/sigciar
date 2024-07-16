var checkLogin = $('#loginCheck').val();
// Obtener la fecha actual para bloquear los días pasados.
moment.locale('es'); //->colocar el idioma español.

var calendarEl = document.getElementById('calendario');

var calendar = new FullCalendar.Calendar(calendarEl, {
    themeSystem: 'bootstrap5',
    allDaySlot: false,
    contentHeight: 20,
    dayMaxEvents: 1,
    editable: true,
    eventOverlap: true,
    eventShortHeight: 'short',
    height: 500,
    initialView: 'dayGridMonth',
    locale: 'es-PE',
    selectable: true,
    timeZone: 'UTC',
    unselectAuto: true,
    headerToolbar: {
        left: 'title',
        center: '',
        right: 'today prev,next'
    },
    events: `/admin/carga/actividades`,
    eventClick: function (){
        alert('Clickeado');
    }
});
calendar.render();

