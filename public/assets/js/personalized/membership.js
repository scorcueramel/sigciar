$("#sedes").on('change', function () {
    let id = $(this).val();
    $("#programas").html("");
    $("#programas").append(`<option selected value="" disabled>SELECCIONAR PROGRAMA</option>`);
    $("#programas").attr('disabled', 'disabled');

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

    $(".program-validate").addClass('d-nonde');
    $(".program-validate").html('');

    $("#programas").html("");
    $("#programas").append(`<option selected value="" disabled>SELECCIONAR PROGRAMA</option>`);
    $("#programas").attr('disabled', 'disabled');

    $.ajax({
        method: 'GET',
        url: `/admin/membresias/${sedeid}/${lugarid}/programas`,
        success: function (res) {
            if (res.length > 0) {
                $("#programas").removeAttr('disabled');
                $('#programas').html('');
                $('#programas').append('<option value="" selected>SELECCIONAR PROGRAMA</option>');
                res.map((e) => {
                    $('#programas').append(`
                        <option value="${e.id}">${e.programa}</option>
                    `);
                });
            } else {
                $(".program-validate").removeClass('d-none');
                $(".program-validate").append(`
                <small class="text-danger">No se encontraron resultados para tu búsqueda.</small>
                `);
            }
        }, error: function (error) {
            console.log(error);
        }
    });
});

$("#btnBuscar").on('click', function () {
    let sedeid = $("#sedes").val();
    let lugarid = $("#lugares").val();
    let programaid = $("#programas").val();

    $.ajax({
        method:'GET',
        url:`/admin/membresias/${sedeid}/${lugarid}/${programaid}/programas`,
        success:function(resp){
            console.log(resp)
        },
        error:function(err){
            console.log(err)
        }
    });
});