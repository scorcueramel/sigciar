import swalmessage from "./Swal.js";

function validPastDateTime() {
    swalmessage("warning", "Ups!", "No se puede seleccionar una <strong>fecha u hora anterior a la actual.</strong>", true, true, false, "", "Cerrar", "", "", false);
}
function sedeLugarSelection() {
    swalmessage("warning", "Ups!", "Recuerda seleccionar una <strong>SEDE</strong> y posteriormente una <strong>CANCHA</strong> para realizar tu reserva", true, true, false, "", "Cerrar", "", "", false
    );
}
function dateNotAvailability(respuesta) {
    swalmessage("warning", "Ups!", `${respuesta}`, true, true, false, "", "Cerrar", "", "", false);
}
function notRegisterUser() {
    swalmessage("warning", "¿No estás registrado?",
        `
            <div class="text-center">
                <p>Debes estar registrado para realizar tu reserva, da click en el botón <strong>Registrate</strong>.</p>
                <p>Si ya cuentas con usuario por favor <a href="/login">Inicia sesión.</a></p>
            </div>
            `, true, true, true,
        `<a href="/registro/cliente" class="text-decoration-none text-white">Registrate</a>`,
        "Cerrar", "", "", true, false
    );
}
function registeredSuccess(respuesta) {
    swalmessage(
        "success",
        "Reserva Realizada",
        `
            <div class="text-center">
                <p>${respuesta}</p>
            </div>
        `,
        true,
        true,
        false,
        "",
        "Cerrar",
        "",
        "",
        false,
        false
    );
}

function duranteCarga() {
    Swal.fire({
        allowOutsideClick: false,
        icon: 'info',
        iconColor: '#005ea5',
        text: 'Espere un momento por favor...',
        timerProgressBar: true,
        showConfirmButton: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading()
        }
    });
}

export { validPastDateTime, sedeLugarSelection, dateNotAvailability, notRegisterUser, registeredSuccess, duranteCarga }
