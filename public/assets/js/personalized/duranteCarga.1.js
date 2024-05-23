function duranteCarga(active) {
    if (active != false) {

        Swal.fire({
            allowOutsideClick: false,
            icon: 'info',
            iconColor: '#005ea5',
            text: 'Espere un momento por favor...',
            timerProgressBar: true,
            showConfirmButton: false,
        });
        Swal.showLoading();
    }
}
