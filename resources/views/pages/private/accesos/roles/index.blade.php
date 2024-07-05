@extends('layouts.private.private', ['activePage' => 'roles.index'])
@push('title', 'Roles')
@section('content')
    @include('components.private.messages-session')
    <div class="row d-flex align-items-center">
        <div class="col-md">
            <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Roles /</span> Todos </h4>
        </div>
        <div class="col-md text-end">
            <a href="#" class="btn btn-sm btn-info"><i class="fa-solid fa-user-plus me-1"></i>Nuevo</a>
        </div>
    </div>
@endsection
@push('js')
    <script>
        // Ejecuta la acción de buscar de la barra de búsqueda.
        // $('#buscador').click(()=>{
        //     alert('The Watcher');
        // });
    </script>
@endpush
