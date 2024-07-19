@extends('layouts.private.private', ['activePage' => 'inscripciones.index'])
@push('title', 'Inscripciones')
@section('content')
<div class="row">
    <div class="col-md">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Inscripciones /</span> Todas</h4>
    </div>
    <div class="col-md d-flex align-items-center justify-content-end">
        <a href="{{route('inscripciones.create')}}" class="btn btn-sm btn-info"><i class="fa-solid fa-file me-1"></i>Nuevo</a>
    </div>
</div>
<!-- Basic Layout & Basic with Icons -->
<div class="row mb-3">
    <!-- Basic with Icons -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Lista General de Inscripciones</h5>
            </div>
            <div class="card-body mt-3">
                <div class="container">
                    <div class="text-nowrap table-responsive">
                        <table class="table table-striped table-borderless table-hover nowrap" id="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>DOCUMENTO</th>
                                    <th>NOMBRES DEL MIEMBRO</th>
                                    <th>TIPO DE SERVICIO</th>
                                    <th>HORARIOS</th>
                                    <th>MONTO A PAGAR</th>
                                    <th>ESTADO DE INSCRIPCIÓN</th>
                                    <th>ESTADO DE PAGO</th>
                                    <th>FECHA DE PAGO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(() => {
        $('#table').DataTable({
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
            "ajax": "{{route('tabla.inscripciones')}}",
            "columns": [{
                    data: 'documento'
                },
                {
                    data: 'apeynom'
                },
                {
                    data: 'descripcion'
                },
                {
                    data: 'horario_inscripcion'
                },
                {
                    data: 'pago'
                },
                {
                    data: 'estado_inscripcion'
                },
                {
                    data: 'estado_pago'
                },
                {
                    data: 'fechapago'
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
    });

    function deleteInscripcion(id) {
        var id = id;
        Swal.fire({
            title: "Eliminar Programa?",
            text: "Seguro de eliminar este programa",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si eliminar",
            cancelButtonText: "No eliminar",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'info',
                    html: "Espere un momento porfavor ...",
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    type: "POST",
                    url: `{{ route('nutricion.eliminar') }}`,
                    data: {
                        id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
    }

    $(".cancelButton").on('click', function() {
        $("#mcbody").html('');
        $("#mcLabel").html('');
    });
</script>
@endpush
