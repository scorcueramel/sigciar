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
    $("#table-section").removeClass('d-none');
    $("#loading-data").removeClass('d-none');
    $(".table-responsive").addClass('d-none');

    let sedeid = $("#sedes").val();
    let lugarid = $("#lugares").val();
    let programaid = $("#programas").val();
    let estadoid = $("#estados").val();

    $.ajax({
        method: 'GET',
        url: `/admin/sede/${sedeid}/lugar/${lugarid}/programa/${programaid}/estado/${estadoid}`,
        success: function (resp) {
            $("#loading-data").addClass('d-none');
            $(".table-responsive").removeClass('d-none');
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
                    },
                    "emptyTable": "No hay datos disponibles en la tabla"
                },
            });

        },
        error: function (err) {
            console.log(err)
        }
    });
});

function showDetails(id, nombre) {
    $("#modalcomponent").modal('show');
    $("#mcbody").append(`
    <div class="text-center" id="loading-data">
        <div class="spinner-border text-primary h2" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="h5">
            Cargando ...
        </div>
    </div>
    `);

    $.ajax({
        method: 'GET',
        url: `/admin/detalles/${id}/membresia`,
        success: function (resp) {
            $("#loading-data").addClass('d-none');
            $("#mcLabel").html('');
            $("#mcLabel").html(`${nombre}`);
            $("#mcbody").html('');
            $("#mcbody").append(`
                <table class="table table-sm table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Fechas de inscripcion</th>
                      <th scope="col">Próximo pago</th>
                      <th scope="col">Monto a pagar</th>
                      <th scope="col">Estado de pago</th>
                      <th scope="col">NOTIFICACIÓN PRÓXIMO PAGO</th>
                    </tr>
                  </thead>
                  <tbody id="tableDetails">                      
                  </tbody>
                </table>
            `);
            resp.map((e, index) => {
                $("#tableDetails").append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${formatearFechas(e.fechainscripcion)}</td>
                        <td>${formatearFechas(e.fechapago)}</td>
                        <td>S/.${e.valorpago}</td>
                        <td><span class="badge rounded-pill ${e.estado == 'CANCELADO' ? 'bg-success' : 'bg-danger'}">${e.estado}</span></td>
                        <td class="text-center">${e.notificado ? '<span class="badge rounded-pill bg-success"><i class="fa-duotone fa-solid fa-money-check-pen"></i> NOTIFICADO</span>' : '<button class="ms-3 btn btn-sm btn-primary" onclick="sendNotification(' + e.id +','+ nombre +'\')">Notificar</button>'} </td>
                    </tr>
                `)
            });
        },
        error: function (error) {
            console.log(error)
        }
    });
}

$("#btnLimpiar").on('click', function () {

    $("#lugares").attr('disabled', 'disabled');
    $("#sedes option:first").attr('selected', 'selected');

    $("#lugares").html("");
    $("#lugares").append(`<option selected value="" disabled>SELECCIONAR LUGAR</option>`);
    $("#lugares").attr('disabled', 'disabled');

    $("#estados option:first").attr('selected', 'selected');
    $("#estados").attr('disabled', 'disabled');

    $("#programas").html("");
    $("#programas").append(`<option selected value="" disabled>SELECCIONAR PROGRAMA</option>`);
    $("#programas").attr('disabled', 'disabled');
});

function formatearFechas(fecha) {
    let splitFecha = fecha.split(" ")[0];
    let divideFecha = splitFecha.split("-");
    return divideFecha[2] + "/" + divideFecha[1] + "/" + divideFecha[0];
}

const sendNotification = (id, nombre) => {
    $.ajax({
        method: 'GET',
        url: `/admin/notificar/${id}/membresia`,
        success: function (res) {
            if (res.code == 'ok') {
                $("#modalcomponent").modal('show');
                $("#mcbody").html('');
                $("#mcbody").append(`
                    <div class="text-center" id="loading-data">
                        <div class="spinner-border text-primary h2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="h5">
                            Cargando ...
                        </div>
                    </div>
                `);

                $.ajax({
                    method: 'GET',
                    url: `/admin/detalles/${id}/membresia`,
                    success: function (resp) {
                        console.log(id);
                        $("#loading-data").addClass('d-none');
                        $("#mcLabel").html('');
                        $("#mcLabel").html(`${res.nombre}`);
                        $("#mcbody").html('');
                        $("#mcbody").append(`
                            <table class="table table-sm table-bordered">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Fechas de inscripcion</th>
                                  <th scope="col">Próximo pago</th>
                                  <th scope="col">Monto a pagar</th>
                                  <th scope="col">Estado de pago</th>
                                  <th scope="col">NOTIFICACIÓN PRÓXIMO PAGO</th>
                                </tr>
                              </thead>
                              <tbody class="tableDetails">                      
                              </tbody>
                            </table>
                        `);
                        resp.map((e, index) => {
                            $(".tableDetails").append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${formatearFechas(e.fechainscripcion)}</td>
                                    <td>${formatearFechas(e.fechapago)}</td>
                                    <td>S/.${e.valorpago}</td>
                                    <td><span class="badge rounded-pill ${e.estado == 'CANCELADO' ? 'bg-success' : 'bg-danger'}">${e.estado}</span></td>
                                    <td class="text-center">${e.notificado ? '<span class="badge rounded-pill bg-success"><i class="fa-duotone fa-solid fa-money-check-pen"></i> NOTIFICADO</span>' : '<button class="ms-3 btn btn-sm btn-primary" onclick="sendNotification(' + e.id + ',+ res.nombre +)">Notificar</button>'} </td>
                                </tr>
                            `)
                        });
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            } else {
                alert('Hubo un problema al procesar los datos, comunicate con soporte')
            }
        },
        error: function (error) {
            console.log(error)
        }
    });
}