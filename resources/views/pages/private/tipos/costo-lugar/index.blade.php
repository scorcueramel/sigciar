@extends('layouts.private.private', ['activePage' => 'costos.lugares.index'])
@push('title', 'Costo por Lugar')
@section('content')
@include('components.private.messages-session')
<div class="row d-flex align-items-center">
    <div class="col-md">
        <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Costo Lugar /</span> Todas </h4>
    </div>
    <div class="col-md text-end">
        @can('crear.costo.lugar')
        <a href="{{ route('costos.lugares.create') }}" class="btn btn-sm btn-info"><i class="fa-regular fa-money-check-dollar-pen me-1"></i>Nuevo</a>
        @endcan
    </div>
</div>
@can('ver.costo.lugar')
@include('components.private.table', ['titleTable' => 'Lista de costo lugar registrados','searchable'=>false,'paginate'=>$sedesBody])
@endcan
@endsection
@include('components.private.modal',['withTitle'=>true,'withButtons'=>false])
@push('js')
<script>
    let headerSedes = @json($sedesHeader);
    let headerTable = $('#headertable');
    let bodySedes = @json($sedesBody);
    let bodyTable = $('#bodytable');
    headerTable.append(`
                <tr>
                    <th>${headerSedes[0] ?? 'ID'}</th>
                    <th>${headerSedes[1] ?? 'DESCRIPCIÓN'}</th>
                    <th>${headerSedes[2] ?? 'ABREVIATURA'}</th>
                    <th>${headerSedes[3] ?? 'COSTO HORA'}</th>
                    @can('estado.costo.lugar')
                    <th>${headerSedes[4] ?? 'ESTADO'}</th>
                    @endcan
                    <th>${headerSedes[5] ?? 'TIPO'}</th>
                    <th>${headerSedes[6] == 'lugars_id' ? 'LUGAR' : 'LUGAR'}</th>
                    <th>${headerSedes[7] == 'tiposervicios_id' ? 'TIPO SERVICIO':'TIPO SERVICIO'}</th>
                </tr>
        `);
    if (bodySedes != null) {
        bodySedes.data.forEach((e) => {
            bodyTable.append(`
                <tr>
                    <td>
                        <i class="bx bxs-circle text-primary me-3"></i>
                    </td>
                    <td>${e.descripcion}</td>
                    <td>${e.abreviatura}</td>
                    <td>S/. ${e.costohora}.00</td>
                    @can('estado.costo.lugar')
                    <td>
                    ${e.estado == "A" ? '<button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" data-id="'+e.id+'"><span class="badge bg-label-success me-1">PUBLICADO</span></button>' : '<button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" data-id="'+e.id+'"><span class="badge bg-label-danger me-1">BORRADOR</span></button>'}
                    </td>
                    @endcan
                    <td>
                    ${e.tipo == "V" ? '<span class="badge bg-label-warning me-1">VARIABLE</span>' : '<span class="badge bg-label-primary me-1">FIJO</span>'}
                    </td>
                    <td>${e.lugar}</td>
                    <td>${e.tiposervicio}</td>
                    @if (auth()->user()->can('editar.costo.lugar') || auth()->user()->can('eliminar.costo.lugar'))
                    <td>
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                    <a href="/admin/costo-lugar/editar/${e.id}" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                    <button class="dropdown-item delete" data-id="${e.id}"><i class="bx bx-trash me-1"></i> Eliminar</button>
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
            url: "{{route('costos.lugares.change.state')}}",
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
            text: "Vas a eliminar este costo lugar",
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
                    url: `{{route('costos.lugares.destroy')}}`,
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
