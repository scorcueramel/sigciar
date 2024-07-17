@extends('layouts.private.private', ['activePage' => 'tipo.servicio.index'])
@push('title', 'Tipos de Servicios')
@section('content')
@include('components.private.messages-session')
<div class="row d-flex align-items-center">
    <div class="col-md">
        <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Tipo Servicio /</span> Todas </h4>
    </div>
    <div class="col-md text-end">
        <a href="{{route('tipo.servicio.create')}}" class="btn btn-sm btn-info"><i class="fa-solid fa-box me-1"></i>Nuevo</a>
    </div>
</div>
@include('components.private.table', ['titleTable' => 'Lista de servicios registrados','searchable'=>false,'paginate'=>$sedesBody])
@endsection
@push('js')
<script>
    let headerSedes = @json($sedesHeader);
    let headerTable = $('#headertable');
    let bodySedes = @json($sedesBody);
    let bodyTable = $('#bodytable');
    headerTable.append(`
                <tr>
                    <th>${headerSedes[0]}</th>
                    <th>${headerSedes[1]}</th>
                    <th>${headerSedes[2]}</th>
                    <th>${headerSedes[3]}</th>
                    <th>Acciones</th>
                </tr>
        `);

    bodySedes.data.forEach((e) => {
        bodyTable.append(`
                <tr>
                    <td>
                        <i class="bx bxs-circle text-primary me-3"></i>
                    </td>
                    <td>${e.descripcion}</td>
                    <td>${e.abreviatura}</td>
                    <td>
                        ${e.estado == "A" ? '<button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" data-id="'+e.id+'"><span class="badge bg-label-success me-1">PUBLICADO</span></button>' : '<button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" data-id="'+e.id+'"><span class="badge bg-label-danger me-1">BORRADOR</span></button>'}
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="/admin/tipos-servicio/editar/${e.id}" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                                <button class="dropdown-item delete" data-id="${e.id}"><i class="bx bx-trash me-1"></i> Eliminar</button>
                            </div>
                        </div>
                    </td>
                </tr>
        `);
    });

    $('.change-state').on('click', function() {
        let id = $(this).attr('data-id');
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
            url: "{{route('tipo.servicio.change.state')}}",
            data: {
                id: id
            },
            success: function(response) {
                location.reload();
            }
        });
    });

    $('.delete').on('click', function() {
        let id = $(this).attr('data-id');
        Swal.fire({
            title: "Seguro de eliminar?",
            text: "Vas a eliminar esta sede",
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
                    url: `{{route('tipo.servicio.destroy')}}`,
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
    });
</script>
@endpush
