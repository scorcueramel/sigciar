$("#sedes").on('change', function () {
    let id = $(this).val();
    $("#programas").html("");
    $("#programas").append(`<option selected value="" disabled>SELECCIONAR PROGRAMA</option>`);
    $("#programas").attr('disabled', 'disabled');
    $("#btnLimpiar").removeClass('disabled');

    $.ajax({
        method: 'GET',
        url: `/admin/membresias/${id}/lugares`,
        success: function (res) {
            $('#lugares').removeAttr('disabled');
            $('#lugares').html('');
            $('#lugares').append('<option value="" selected>SELECCIONAR LUGAR</option>');
            res.map((e) => {
                $('#lugares').append(`
                    <option value="${e.id}">${e.descripcion}</option>
                `);
            });
        }, error: function (error) {
            console.log(error);
        }
    });
});

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

$("#programas").on('change', function () {
    $("#estados").removeAttr('disabled');
    $("#btnBuscar").removeClass('disabled');
});

$("#btnBuscar").on('click', function () {
    let sedeid = $("#sedes").val();
    let lugarid = $("#lugares").val();
    let programaid = $("#programas").val();
    let estadoid = $("#estados").val();
    $.ajax({
        method: 'GET',
        url: `/admin/sede/${sedeid}/lugar/${lugarid}/programa/${programaid}/estado/${estadoid}`,
        success: function (resp) {

            $("#table-section").removeClass('d-none');
            $('#table').DataTable({
                "bDestroy": true,
                paging: true,
                info: true,
                "order": [
                    [0, "DESC"]
                ],
                responsive: true,
                autoWidth: false,
                processing: true,
                "columnDefs": [{
                    "targets": [6],
                    "orderable": false
                }],
                "pageLength": 10,
                "aLengthMenu": [
                    [10, 15, 20, -1],
                    [10, 15, 20, "Todos"]
                ],
                data: resp.data,
                "columns": [
                    {
                        data: 'id'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'documento'
                    },
                    {
                        data: 'programa'
                    },
                    {
                        data: 'sede'
                    },
                    {
                        data: 'lugar'
                    },
                    {
                        data: 'cancelado'
                    },
                    {
                        data: 'pendiente'
                    },
                    {
                        data: 'retirado'
                    },
                    {
                        data: 'acciones'
                    },
                ],
                "language": {
                    "lengthMenu": "Mostrar " +
                        `<select class="custom-select custom-select-sm form-control form-control-sm">
                            <option value='10'>10</option>
                            <option value='15'>15</option>
                            <option value='20'>20</option>
                            <option value='-1'>Todos</option>
                        </select>` +
                        " Registros Por Página",
                    "zeroRecords": "Sin Resultados",
                    "info": "Mostrando Página _PAGE_ de _PAGES_",
                    "infoEmpty": "Sin Resultados",
                    "infoFiltered": "(Filtro de _MAX_ Registros Totales)",
                    "search": "Búscar ",
                    "paginate": {
                        "next": "›",
                        "previous": "‹"
                    }
                },
            });

        },
        error: function (err) {
            console.log(err)
        }
    });
});

function showDetails(id){

    $.ajax({
        method:'GET',
        url:'',
        success:function (resp){
            console.log(resp)
        },
        error:function(error){
            console.log(error)
        }
    });


    $("#modalcomponent").modal('show');

    $("#mcbody").append('DATA MEMBER ' + id)
}

$("#btnLimpiar").on('click',function (){

    $("#sedes option:first").attr('selected','selected');

    $("#lugares").html("");
    $("#lugares").append(`<option selected value="" disabled>SELECCIONAR LUGAR</option>`);
    $("#lugares").attr('disabled', 'disabled');

    $("#estados option:first").attr('selected','selected');
    $("#estados").attr('disabled', 'disabled');

    $("#programas").html("");
    $("#programas").append(`<option selected value="" disabled>SELECCIONAR PROGRAMA</option>`);
    $("#programas").attr('disabled', 'disabled');
});