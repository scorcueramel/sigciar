@extends('layouts.private.private', ['activePage' => 'lugares.index'])
@push('title', 'Lugares')
@section('content')
@include('components.private.messages-session')
<div class="row d-flex align-items-center">
    <div class="col-md">
    <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Lugares /</span> Todos </h4>
    </div>
    <div class="col-md text-end">
        <a href="{{route('lugares.create')}}" class="btn btn-sm btn-info"><i class="fa-regular fa-court-sport me-1"></i>Nuevo</a>
    </div>
</div>

<div class="row p-3">
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Recuerda!</strong> Antes de agregar un nuevo lugar recuerda crear primero la sede, ello para asignar el lugar a la correspondiente sede
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @include('components.private.table', [
    'titleTable' => 'Lista de lugares',
    'searchable'=>false,
    'paginate' => $lugaresBody,
    ])
</div>

@endsection
@include('components.private.modal', ['withTitle' => true, 'withButtons' => false])
@push('js')
<script>
    // Ejecuta la acción de buscar de la barra de búsqueda.
    // $('#buscador').click(()=>{
    //     alert('The Watcher');
    // });
    let headerLugares = @json($lugaresHeader);
    let headerTable = $('#headertable');
    let bodyLugares = @json($lugaresBody);
    let bodyTable = $('#bodytable');
    headerTable.append(`
                <tr>
                    <th>${headerLugares[0]}</th>
                    <th>${headerLugares[1]}</th>
                    <th>${headerLugares[2]}</th>
                    <th>COSTO HORA</th>
                    <th>${headerLugares[4]}</th>
                    <th>${headerLugares[5]}</th>
                    <th class="text-center">SEDE</th>
                    <th>${headerLugares[7]}</th>
                </tr>
    `);
    bodyLugares.data.forEach((e) => {
        bodyTable.append(`
                <tr>
                    <td>
                        <i class="bx bxs-circle text-primary me-3"></i>
                    </td>
                    <td>${e.descripcion}</td>
                    <td>${e.abreviatura}</td>
                    <td>s/. ${e.costohora}.00</td>
                    <td>
                        ${e.estado == "A" ? '<button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" data-id="'+e.id+'"><span class="badge bg-label-success me-1">PUBLICADO</span></button>' : '<button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" data-id="'+e.id+'"><span class="badge bg-label-danger me-1">BORRADOR</span></button>'}
                    </td>
                    <td>${e.tipo == "V" ? 'VARIABLE' : 'FIJO'}</td>
                    <td class="text-center"><a href="{{ route('sedes.index') }}" data-toggle="tooltip" title="Ir a sedes"><span class="badge bg-label-primary me-1">${e.sede}</span></a></td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="/admin/lugares/editar/${e.id}" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Editar</a>
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
            url: `/admin/lugares/change/state`,
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
            text: "Vas a eliminar este lugar",
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
                    url: `{{ route('lugares.destroy') }}`,
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
