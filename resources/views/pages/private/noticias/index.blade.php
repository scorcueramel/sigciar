@extends('layouts.private.private', ['activePage' => 'noticias.index'])
@push('title', 'Noticias')
@push('css')
    <style>
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
            <a href="{{ route('noticias.create') }}" class="btn btn-sm btn-info"><i
                        class="fa-regular fa-newspaper me-1"></i>Nueva</a>
        </div>
    </div>
    <div class="row">
        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header">
                    <form action="{{ route('noticias.index') }}" method="GET"
                          class="row d-flex align-items-center justify-content-end mt-3">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Búscar por nombre de la nota"
                                       aria-label="Búscar por nombre de la nota" aria-describedby="buscador"
                                       name="buscar"
                                       value="{{ $buscar ?? '' }}">
                                <button type="submit" class="btn btn-sm btn-primary" id="buscador">Búscar</button>
                                <button type="button" class="btn btn-sm btn-warning" id="limpiar">Limpiar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (count($noticias) > 0)
        <div class="row">
            <div class="col-md-12">
                {{ $noticias->appends(['buscar' => $buscar]) }}
            </div>
        </div>
        <div class="row">
            @foreach ($noticias as $noticia)
                <div class="col-md-4 col-lg-4 mb-3">
                    @include('components.private.card',
                            [
                                'titulo'=>Str::title(Str::limit($noticia->titulo, 80)),
                                'imagen'=>true,
                                'imagenDestacada'=>asset('/storage/noticias/'.$noticia->imagen_destacada),
                                'muestraExtracto'=>true,
//                                'extracto'=>$noticia->extracto,
                                'botones'=>true,
                                'botonDetalle'=>true,
                                'detalleId'=>$noticia->noticia_id,
                                'botonEditar'=>true,
                                'ruta'=>route('noticias.edit', $noticia->noticia_id),
                                'botonEliminar'=>true,
                                'eliminarId'=>$noticia->noticia_id,
                                'estado'=>true,
                                'estadoActual'=>$noticia->estado,
                                'estadoId'=>$noticia->noticia_id
                            ])
                </div>
            @endforeach
        </div>
    @else
        <div class="row mb-2">
            <h5>No Existen Noticias para Mostrar</h5>
        </div>
    @endif
@endsection
@include('components.private.modal', [
    'withTitle' => true,
    'withButtons' => true,
    'cancelbutton' => true,
    'mcTextCancelButton' => 'Cerrar',
])
@push('js')
    <script>
        $('.change-state').on('click', function () {
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
                url: `{{ route('noticias.change.state') }}`,
                data: {
                    id: id
                },
                success: function (response) {
                    location.reload();
                }
            });
        });

        $('.delete').on('click', function () {
            let id = $(this).attr('data-id');
            Swal.fire({
                title: "Seguro de eliminar?",
                text: "Vas a eliminar esta noticia",
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
                        url: `{{ route('noticias.destroy') }}`,
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
        });

        $('.btn-detail').on('click', function () {
            var id = $(this).attr('data-id');
            console.log(id);
            $.ajax({
                type: "GET",
                url: `/admin/noticias/detalle/${id}/noticia`,
                success: function (response) {
                    let data = response[0];
                    $("#modalcomponent").modal("show");
                    $("#mcbody").html("");
                    $("#mcbody").append(`
                    <div class="row">
                        <div class="col-md-12">
                            ${data.cuerpo}
                        </div>
                    </div>
                `);
                }
            });

        });

        $("#limpiar").on('click', function () {
            window.location.href = "{{route('noticias.index')}}";
        });
    </script>
@endpush
