@extends('layouts.private.private', ['activePage' => 'tenis.index'])
@push('title', 'Tenis')
@push('css')
    <style>
        tbody > tr > td {
            font-size: 14px !important;
        }
        thead > tr > td {
            font-size: 13px !important;
            font-weight: 700;
        }
    </style>
@endpush
@section('content')
    @include('components.private.messages-session')
    <div class="row d-flex align-items-center">
        <div class="col-md">
            <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Tenis Actividades /</span> Todas </h4>
        </div>
        <div class="col-md text-end">
            <a href="{{ route('tenis.create') }}" class="btn btn-sm btn-info"><i class="fa-regular fa-newspaper"></i>
                Nueva</a>
        </div>
    </div>

    <div class="row p-3">
        <div class="card pt-2">
            <div class="card-body">
                <div class="text-nowrap table-responsive p-3">
                    <table class="table table-striped table-borderless table-hover nowrap" id="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ESTADO</th>
                                <th>TIPO SERVICIO</th>
                                <th>SEDE</th>
                                <th>DIRECCIÓN SEDE</th>
                                <th>LUGAR DESCRIPCIÓN</th>
                                <th>COSTO HORA</th>
                                <th>CAPACIDAD</th>
                                <th>INICIO</th>
                                <th>FIN</th>
                                <th>HORAS POR ACTIVIDAD</th>
                                <th>TURNO</th>
                                <th>RESPONSABLE</th>
                                <th>TÍTULO</th>
                                <th>SUBTÍTULO</th>
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
@endsection
@include('components.private.modal', [
    'tamanio'=>'modal-sm',
    'withTitle' => true,
    'withButtons' => true,
    'cancelbutton' => true,
    'mcTextCancelButton' => 'Cerrar',
])
@push('js')
    <script>
        $(document).ready(() => {
            $('#table').DataTable({
                paging: true,
                info: true,
                "order": [[0, "DESC"]],
                responsive: true,
                autoWidth: false,
                processing: true,
                "columnDefs": [{"targets": [15], "orderable": false}],
                "pageLength": 10,
                "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
                "ajax": "{{route('tabla.tenis')}}",
                "columns": [
                    { data: 'id' },
                    { data: 'estado' },
                    { data: 'tipo_servicio' },
                    { data: 'sede' },
                    { data: 'direccion_sede' },
                    { data: 'lugar_descripcion' },
                    { data: 'lugar_costo_hora' },
                    { data: 'capacidad' },
                    { data: 'inicio' },
                    { data: 'fin' },
                    { data: 'hora' },
                    { data: 'turno' },
                    { data: 'responsable' },
                    { data: 'titulo' },
                    { data: 'subtitulo' },
                    { data: 'acciones' }
                ],
                "language": {
                    "lengthMenu": "Mostrar " +
                        `<select class="custom-select custom-select-sm form-control form-control-sm">
                            <option value='10'>10</option>
                            <option value='15'>15</option>
                            <option value='20'>20</option>
                            <option value='-1'>Todos</option>
                        </select>` +
                        " registros por página",
                    "zeroRecords": "Sin Resultados Actualmente",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Sin Resultados",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar: ",
                    "paginate": {
                        "next": "›",
                        "previous": "‹"
                    }
                },
            });
        });

        function changeState(id) {
            var id = id;
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
                url: `/admin/actividades/change/state`,
                data: {
                    id: id
                },
                success: function (response) {
                    location.reload();
                }
            });
        }

        function deleteActivity(id) {
            var id = id;
            Swal.fire({
                title: "Seguro de eliminar?",
                text: "Vas a eliminar esta actividad",
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
                        url: `{{ route('tenis.actividad.eliminar') }}`,
                        data: {
                            id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                }
            });
        }

        function showDetail(id){
            $.ajax({
                method:'GET',
                url:`/admin/actividades/detalle/${id}/actividad`,
                success:function(resp){
                    let data = resp[0];
                    $("#mcLabel").html(`
                        ${data.titulo} <br>
                        <span style="font-size: 14px; font-weight: normal">${data.subtitulo}</span>
                    `)
                    $("#mcbody").html(`
                        <div class="row mb-2">
                            <div class="col-sm-auto" style="font-weight: bold">
                                Responsable
                            </div>
                            <div class="col-sm-auto">
                                ${data.responsable}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-auto" style="font-weight: bold">
                                Inicio
                            </div>
                            <div class="col-sm-auto">
                                ${new Date(data.inicio).toLocaleDateString("en-US")}
                            </div>
                            <div class="col-sm-auto" style="font-weight: bold">
                                Fin
                            </div>
                            <div class="col-sm-auto">
                                ${new Date(data.fin).toLocaleDateString("en-US")}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4" style="font-weight: bold">
                                Horas Act.
                            </div>
                            <div class="col-sm-auto">
                                ${data.hora} hrs.
                            </div>
                            <div class="col-sm-auto" style="font-weight: bold">
                                Cupos
                            </div>
                            <div class="col-sm-auto">
                                ${data.capacidad}
                            </div>
                        </div>
                    `);
                    console.log(resp);
                },
                error: function(err){
                    console.log(err)
                }
            });
        }

        $(".cancelButton").on('click',function (){
            $("#mcbody").html('');
            $("#mcLabel").html('');
        });

    </script>
@endpush
