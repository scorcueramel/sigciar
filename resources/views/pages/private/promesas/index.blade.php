@extends('layouts.private.private', ['activePage' => 'promesas.index'])
@push('title', 'Promesas')
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
            <h4 class="fw-bold mt-3"><span class="text-muted fw-light">Promesas /</span> Todas </h4>
        </div>
        <div class="col-md text-end">
            <a href="{{ route('promesas.create') }}" class="btn btn-sm btn-info"><i class="fa-solid fa-hands-holding-child me-2"></i>Nueva</a>
        </div>
    </div>
    <div class="row">
        {{-- Basic with Icons --}}
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header">
                    <form action="{{ route('promesas.index') }}" method="GET"
                          class="row d-flex align-items-center justify-content-end mt-3">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Búscar por nombre"
                                       aria-label="Búscar por nombre" aria-describedby="buscador"
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

    @if (count($promesas) > 0)
        <div class="row">
            <div class="col-md-12">
                {{ $promesas->appends(['buscar' => $buscar]) }}
            </div>
        </div>
        <div class="row">
            @foreach ($promesas as $promesa)
                <div class="col-md-6 col-lg-4">
                    @include('components.private.card',
                            [
                                'titulo'=>Str::title(Str::limit($promesa->nombre, 80)),
                                'subtitulo'=>$promesa->edad,
                                'imagen'=>true,
                                'imagenDestacada'=>asset('/storage/promesas/'.$promesa->foto),
                                'botones'=>true,
                                'botonDetalle'=>true,
                                'detalleId'=>$promesa->id,
                                'botonEditar'=>true,
                                'ruta'=>route('promesas.edit', $promesa->id),
                                'botonEliminar'=>true,
                                'eliminarId'=>$promesa->id,
                            ])
                </div>
            @endforeach
        </div>
    @else
        <div class="row mb-2">
            <h5>No Existen promesa para Mostrar</h5>
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
        // $('.change-state').on('click', function () {
        //     let id = $(this).attr('data-id');
        //     console.log(id);
        //     Swal.fire({
        //         icon: 'info',
        //         html: "Espere un momento porfavor ...",
        //         timerProgressBar: true,
        //         didOpen: () => {
        //             Swal.showLoading();
        //         }
        //     });
        //     $.ajax({
        //         type: "POST",
        //         url: `{{ route('promesas.change.state') }}`,
        //         data: {
        //             id: id
        //         },
        //         success: function (response) {
        //             location.reload();
        //         }
        //     });
        // });

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
                        url: `{{ route('promesas.destroy') }}`,
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
                url: `/admin/promesas/detalle/${id}/noticia`,
                success: function (response) {
                    let data = response[0];
                    $("#modalcomponent").modal("show");
                    $("#mcbody").html("");
                    $("#mcbody").append(`
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2>${data.nombre}</h2>
                        </div>
                        <div class="col-md-12">
                            <img src="{{ asset('/storage/promesas/${data.foto}') }}" alt="foto de nuestras promesas" class="img-fluid d-flex mx-auto my-4"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <td>Edad</td>
                                    <td>${data.edad}</td>
                                </tr>
                                <tr>
                                    <td>Estatura</td>
                                    <td>${data.estatura.includes('cm') || data.estatura.includes('CM') ? data.estatura : data.estatura +'cm'}</td>
                                </tr>
                                <tr>
                                    <td>Peso</td>
                                    <td>${data.peso.includes('kg') || data.peso.includes('KG') ? data.peso : data.peso + 'kg'}</td>
                                </tr>
                                <tr>
                                    <td>Mano</td>
                                    <td>${data.mano}</td>
                                </tr>
                                <tr>
                                    <td>Preparador Físico</td>
                                    <td>${data.preparador}</td>
                                </tr>
                                <tr>
                                    <td>Nutricionista</td>
                                    <td>${data.nutricionista}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `);
                }
            });

        });

        $("#limpiar").on('click', function () {
            window.location.href = "{{route('promesas.index')}}";
        });
    </script>
@endpush
