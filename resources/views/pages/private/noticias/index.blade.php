@extends('layouts.private.private', ['activePage' => 'noticias.index'])
@push('title', 'Categorías')
@push('css')
<style>
    .estado {
        margin-bottom: -40px;
        margin-left: 15px;
        z-index: 1000;
    }

    .btn-estado {
        border-radius: 50px;
    }
</style>
@endpush
@section('content')
@include('components.private.messages-session')
<div class="row d-flex align-items-center">
    <div class="col-md">
        <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Noticias /</span> Todas </h4>
    </div>
    <div class="col-md text-end">
        <a href="{{route('noticias.create')}}" class="btn btn-sm btn-info"><i class="fa-regular fa-newspaper me-1"></i>Nueva</a>
    </div>
</div>
<div class="row mb-3">
    <!-- Basic with Icons -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header">
                <form action="{{route('noticias.index')}}" method="GET" class="row d-flex align-items-center justify-content-end mt-3">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Búscador" aria-label="Búscador" aria-describedby="buscador" name="buscar" value="{{$buscar ?? ""}}">
                            <button type="submit" class="btn btn-sm btn-primary" id="buscador">Búscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (count($noticias) > 0)
<div class="row mb-2">
    <div class="col-md-12 mb-4">
        {{ $noticias->appends(['buscar'=>$buscar]) }}
    </div>
</div>
<div class="row mb-2">
    @foreach ($noticias as $noticia)
    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4 mb-5">
        <div class="card" style="width: 28rem;">
            @if ($noticia->estado == 'A')
            <span class="estado">
                <button class="btn btn-sm btn-primary change-state btn-estado" data-id="{{ $noticia->noticia_id }}">ACTIVO</button>
            </span>
            @else
            <span class="estado">
                <button class="btn btn-sm btn-danger change-state btn-estado" data-id="{{ $noticia->noticia_id }}">INACTIVO</button>
            </span>
            @endif
            <img src="{{ asset('/storage/noticias/'.$noticia->imagen_destacada)}}" class="card-img-top" alt="Imagen destacada" style="width: 28rem;">
            <div class="card-body">
                <h5 class="card-title">{{Str::ucfirst(Str::limit($noticia->titulo, 80))}}</h5>
                <p class="card-text">{!! $noticia->extracto !!}</p>
            </div>
            <div class="card-footer text-end">
                <a href="#" class="btn btn-sm btn-info">Detalle</a>
                <a href="#" class="btn btn-sm btn-success">Editar</a>
                <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="row mb-2">
    <h5>No Existen Noticias para Mostrar</h5>
</div>
@endif
<div class="row">
    <div class="col-sm-12">

    </div>
</div>
@endsection
@include('components.private.modal', ['withTitle' => true, 'withButtons' => false])
@push('js')
<script>
    $('.change-state').on('click', function() {
        let id = $(this).attr('data-id');
        console.log(id);
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
            url: `/admin/noticias/change/state`,
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
