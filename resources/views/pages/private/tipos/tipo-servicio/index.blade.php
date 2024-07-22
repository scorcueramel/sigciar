@extends('layouts.private.private', ['activePage' => 'tipo.servicio.index'])
@push('title', 'Tipos de Servicios')
@section('content')
@include('components.private.messages-session')
<div class="row d-flex align-items-center">
    <div class="col-md">
        <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Tipo Servicio /</span> Todas </h4>
    </div>
    <div class="col-md text-end">
        @can('crear.tipos.servicios')
        <a href="{{route('tipo.servicio.create')}}" class="btn btn-sm btn-info"><i class="fa-solid fa-box me-1"></i>Nuevo</a>
        @endcan
    </div>
</div>
@can('ver.tipos.servicios')
@include('components.private.table', ['titleTable' => 'Lista de servicios registrados','searchable'=>false,'paginate'=>$sedesBody])
@endcan
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
                    @can('estado.tipos.servicios')
                    <th>${headerSedes[3]}</th>
                    @endcan
                    @if(auth()->user()->can('editar.tipos.servicios') || auth()->user()->can('eliminar.tipos.servicios'))
                    <th>Acciones</th>
                    @endif
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
                    @can('estado.tipos.servicios')
                    <td>
                    ${e.estado == "A" ? '<button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" data-id="'+e.id+'"><span class="badge bg-label-success me-1">PUBLICADO</span></button>' : '<button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" data-id="'+e.id+'"><span class="badge bg-label-danger me-1">BORRADOR</span></button>'}
                    </td>
                    @endcan
                    @if(auth()->user()->can('editar.tipos.servicios') || auth()->user()->can('eliminar.tipos.servicios'))
                    <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            @can('editar.tipos.servicios')
                            <a href="/admin/tipos-servicio/editar/${e.id}" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                            @endcan
                            @can('eliminar.tipos.servicios')
                            <button class="dropdown-item delete" data-id="${e.id}"><i class="bx bx-trash me-1"></i> Eliminar</button>
                            @endcan
                        </div>
                    </div>
                    </td>
                    @endif
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
            text: "Vas a eliminar esta tipo servicio",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
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
