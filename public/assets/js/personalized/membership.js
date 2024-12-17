$("#sedes").on('change', function () {
    let id = $(this).val();

    $.ajax({
        method: 'GET',
        url: `/admin/membresias/${id}/lugares`,
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
    });
})

$("#lugares").on('change', function () {
    let sedeid = $("#sedes").val();
    let lugarid = $(this).val();

    $.ajax({
        method: 'GET',
        url: `/admin/membresias/1/2/programas`,
        success: function (res) {
            console.log(res)
            // $("#programas").removeAttr('disabled');
            // $('#programas').html('');
            // $('#programas').append('<option value="" selected>SELECCIONA UN LUGAR</option>');
            // res.map((e) => {
            //     $('#programas').append(`
            //         <option value="${e.id}">${e.descripcion}</option>
            //     `);
            // });
        }, error: function (error) {
            console.log(error);
        }
    });
});