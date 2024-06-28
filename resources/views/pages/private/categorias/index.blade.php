@extends('layouts.private.private', ['activePage' => 'categorias.index'])
@push('title', 'Categorías')
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
            <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Categorías Noticias /</span> Todas </h4>
        </div>
        <div class="col-md text-end">
            <a href="{{route('categorias.create')}}" class="btn btn-sm btn-info"><i class="fa-regular fa-newspaper"></i>
                Nueva</a>
        </div>
    </div>

    <div class="row p-3">
        <div class="card pt-2">
            <div class="card-body">
                <div class="text-nowrap table-responsive-sm table-responsive-md table-responsive-lg">
                    <table class="table table-striped table-borderless" id="table" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <td>NOMBRE</td>
                            <td>SLUG</td>
                            <td>ESTADO</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(() => {
            $('#table').DataTable({
                "order": [[0, "DESC"]],
                responsive: true,
                autoWidth: false,
                processing: true,
                info: true,
                "columnDefs": [{"targets": [4], "orderable": false}],
                "pageLength": 10,
                "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Todos"]],
                "ajax": "{{route('tabla.categorias')}}",
                "columns": [
                    {
                        data: 'id'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'slug'
                    },
                    {
                        data: 'estado'
                    },
                    {
                        data: 'acciones'
                    }
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
                url: `/admin/categorias/change/state`,
                data: {
                    id: id
                },
                success: function (response) {
                    location.reload();
                }
            });
        }

        function deleteCategory(id) {
            var id = id;
            Swal.fire({
                title: "Eliminar Categoría?",
                text: "Vas a eliminar esta categoría",
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
                        url: `{{ route('categorias.destroy') }}`,
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


    </script>
@endpush
