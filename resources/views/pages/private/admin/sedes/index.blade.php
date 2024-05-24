@extends('layouts.private.layout_private', ['activePage' => 'sedes.index'])
@push('title', 'Sedes')
@section('content')
    <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Sedes /</span> Todas </h4>
    <div class="row p-3">
        {{-- @include('components.private.table',['headerTable'=>$sedesHeader,'bodyTable'=>$sedesBody]) --}}
        @include('components.private.table', ['titleTable' => 'Lista General de las Sedes'])
    </div>
@endsection
@push('js')
    <script>
        // Ejecuta la acción de buscar de la barra de búsqueda.
        // $('#buscador').click(()=>{
        //     alert('The Watcher');
        // });
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
                    <th>${headerSedes[4]}</th>
                </tr>
        `);

        bodySedes.forEach((e) => {
            bodyTable.append(`
                <tr>
                    <td>
                        <i class="bx bxs-circle text-primary me-3"></i> <strong>${e.id}</strong>
                    </td>
                    <td>${e.descripcion}</td>
                    <td>${e.abreviatura}</td>
                    <td>
                        ${e.estado == "A" ? '<span class="badge bg-label-success me-1">ACTIVO</span>' : '<span class="badge bg-label-danger me-1">INACTIVO</span>'}
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
        `);
        });
    </script>
@endpush
