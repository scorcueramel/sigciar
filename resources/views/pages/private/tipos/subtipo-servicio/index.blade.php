@extends('layouts.private.private', ['activePage' => 'subtipos.servicio.index'])
@push('title', 'Subtipos de Servicios')
@section('content')
@include('components.private.messages-session')
<div class="row d-flex align-items-center">
    <div class="col-md">
        <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Subtipo Servicio /</span> Todas </h4>
    </div>
    <div class="col-md text-end">
        @can('crear.subtipo.servicios')
        <a href="{{route('subtipos.servicio.create')}}" class="btn btn-sm btn-info"><i class="fa-solid fa-box-open-full me-1"></i>Nuevo</a>
        @endcan
    </div>
</div>
@can('ver.subtipo.servicios')
@include('components.private.table', ['titleTable' => 'Lista de servicios registrados','searchable'=>false,'paginate'=>$sedesBody])
@endcan
@include('components.private.modal',['withTitle'=>true,'withButtons'=>false])
@endsection
@push('js')
<script>
    let headerSedes = @json($sedesHeader);
    let headerTable = $('#headertable');
    let bodySedes = @json($sedesBody);
    let bodyTable = $('#bodytable');
    headerTable.append(`
                <tr>
                    <th>${headerSedes[0] ?? 'ID'}</th>
                    <th>${headerSedes[1] ?? 'TITULO'}</th>
                    <th>${headerSedes[2] ?? 'SUBTITULO'}</th>
                    @can('estado.subtipo.servicio')
                    <th>${headerSedes[3] ?? 'ESTADO'}</th>
                    @endcan
                    <th>${headerSedes[4] ?? 'IMAGEN'}</th>
                    <th>${headerSedes[5] ?? 'MEDICIÓN'}</th>
                    <th>TIPO DE SERVICIO</th>
                    @if (auth()->user()->can('editar.subtipo.servicios') || auth()->user()->can('eliminar.subtipo.servicios'))
                    <th>Acciones</th>
                    @endif
                </tr>
        `);

    if (bodySedes != null) {
        bodySedes.data.forEach((e) => {
            bodyTable.append(`
                <tr>
                    <td>
                        <i class="bx bxs-circle text-primary me-3"></i>
                    </td>
                    <td>${e.titulo}</td>
                    <td>${e.subtitulo == '' ? 'SIN SUBTITULO' : e.subtitulo}</td>
                    @can('estado.subtipo.servicio')
                    <td>
                    ${e.estado == "A" ? '<button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" data-id="'+e.id+'"><span class="badge bg-label-success me-1">PUBLICADO</span></button>' : '<button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" data-id="'+e.id+'"><span class="badge bg-label-danger me-1">BORRADOR</span></button>'}
                    </td>
                    @endcan
                    <td class="text-center">
                    ${e.imagen == null ? 'sin imagen' : '<button type="button" class="bg-transparent text-primary border-0 btn-modal-image" data-bs-toggle="modal" data-bs-target="#modalcomponent" data-imagen="'+e.imagen+'" data-descripcion="'+e.titulo+'"><i class="fa-solid fa-panorama"></i></button>' }
                    </td>
                    <td>${e.medicion}</td>
                    <td>${e.descripciontiposervicio}</td>
                    @if (auth()->user()->can('editar.subtipo.servicios') || auth()->user()->can('eliminar.subtipo.servicios'))
                    <td>
                        <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                            <div class="dropdown-menu">
                                @can('editar.subtipo.servicios')
                                <a href="/admin/subtipos-servicio/editar/${e.id}" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                                @endcan
                                @can('eliminar.subtipo.servicios')
                                <button class="dropdown-item delete" data-id="${e.id}"><i class="bx bx-trash me-1"></i> Eliminar</button>
                                @endcan
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
            `);
        });
    } else {
        bodyTable.append(`
            <tr>
                <td colspan="8" class="text-center">
                    SIN DATOS
                </td>
            </tr>
        `);
    }
    // cambiar la ruta de donde mostrara la imagen
    $('.btn-modal-image').on('click', function() {
        var imagen = $(this).attr('data-imagen');
        var descripcion = $(this).attr('data-descripcion');
        let uriImg = "{{ asset('/storage/subtipos/{image}') }}";
        uriImg = uriImg.replace('{image}', imagen);

        $('#mcbody').html('<img src="" class="img-fluid mx-auto d-block" id="mostrarImagen" alt="imagen">');
        $('#mcbody').find('#mostrarImagen').attr('src', `${uriImg}`);
        $('#mcLabel').html(`${descripcion}`);
    })

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
            url: "{{route('subtipos.servicio.change.state')}}",
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
            text: "Vas a eliminar este subtipo",
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
                    url: `{{route('subtipos.servicio.destroy')}}`,
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
