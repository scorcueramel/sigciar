export default function defaultMessage(
    icon = "",
    title = "",
    message = "",
    btnClose = false,
    btnCancel = false,
    btnConfirm = false,
    btnTxtConfirm = "",
    btnTxtCancel = "",
    btnArLaConfirm = "",
    btnArLaCancel = "",
    focusConfirm = false,
    focusCancel = false,
) {
    Swal.fire({
        title: `${title}`,
        icon: `${icon}`,
        html: `${message}`,
        showCloseButton: btnClose,
        showCancelButton: btnCancel,
        showConfirmButton: btnConfirm,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        focusConfirm: focusConfirm,
        focusCancel: focusCancel,
        confirmButtonText: `${btnTxtConfirm}`,
        confirmButtonAriaLabel: `${btnArLaConfirm}`,
        cancelButtonText: `${btnTxtCancel}`,
        cancelButtonAriaLabel: `${btnArLaCancel}`
    });
}
