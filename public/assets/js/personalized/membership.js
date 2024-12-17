$("#sedes").on('change', function () {
    let id = $(this).val();

    $.ajax({
        method: 'GET',
        url: `/admin/membresoa/${id}/lugares`,
        success: function (res) {
            $('#lugares').removeAttr('disabled');
            $('#lugares').html('');
            $('#lugares').append('<option value="" selected>SELECCIONA UN LUGAR</option>');
            res.map((e) => {
                $('#lugares').append(`
                <option value="${e.id}">${e.descripcion}</option>
                `);
            });
        }, error: function (error) {
            console.log(error);
        }
    })
})