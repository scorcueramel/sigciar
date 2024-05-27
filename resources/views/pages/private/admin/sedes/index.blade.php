@extends('layouts.private.private', ['activePage' => 'sedes.index'])
@push('title', 'Sedes')
@section('content')
<h4 class="fw-bold mt-3"><span class="text-muted fw-light">Sedes /</span> Todas </h4>
<div class="row p-3">
    @include('components.private.table', ['titleTable' => 'Lista General de las Sedes'])
</div>
@endsection
@include('components.private.modal',['withTitle'=>true,'withButtons'=>false])
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
                    <th>${headerSedes[5]}</th>
                    <th>${headerSedes[6]}</th>
                </tr>
        `);

    // <strong>${e.id}</strong>

    bodySedes.forEach((e) => {
        bodyTable.append(`
                <tr>
                    <td>
                        <i class="bx bxs-circle text-primary me-3"></i>
                    </td>
                    <td>${e.descripcion}</td>
                    <td>${e.abreviatura}</td>
                    <td>${e.direccion ?? 'sin dirección'}</td>
                    <td>${e.imagen == null ? 'sin imagen' : '<button type="button" class="bg-transparent text-primary border-0 btn-modal-image" data-bs-toggle="modal" data-bs-target="#modalcomponent" data-imagen="'+e.imagen+'" data-descripcion="'+e.descripcion+'"><i class="fa-solid fa-panorama"></i></button>' }</td>
                    <td>
                        ${e.estado == "A" ? '<span class="badge bg-label-success me-1">ACTIVO</span>' : '<span class="badge bg-label-danger me-1">INACTIVO</span>'}
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item change-state" href="javascript:void(0);" data-id="${e.id}"><i class="fa-solid fa-rotate-reverse me-1"></i> Cambiar Estado</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Eliminar</a>
                            </div>
                        </div>
                    </td>
                </tr>
        `);
    });

    @if(Session::has('success'))
    let icon = "success";
    let message = "{{Session::get('success')}}";
    messageToast(icon, message);
    @endif
    @if(Session::has('error'))
    let icon = "error";
    let message = "{{Session::get('error')}}";

    messageToast(icon, message);
    @endif

    function messageToast(icon, message) {
        const Toast = Swal.mixin({
            toast: true,
            position: "bottom",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: `${icon}`,
            title: `${message}`
        });
    }

    $('.btn-modal-image').on('click', function() {
        var imagen = $(this).attr('data-imagen');
        var descripcion = $(this).attr('data-descripcion');
        let uriImg = "{{ asset('/storage/sedes/{image}') }}";
        uriImg = uriImg.replace('{image}', imagen);

        $('#mcbody').html('<img src="" class="img-fluid mx-auto d-block" id="mostrarImagen" alt="imagen">');
        $('#mcbody').find('#mostrarImagen').attr('src', `${uriImg}`);
        $('#mcLabel').html(`Sede / ${descripcion}`);
    })

    $('.change-state').on('click', function() {

        let id = $(this).attr('data-id');
        $.ajax({
            type: "GET",
            url: `/admin/sedes/change/${id}/state`,
            success: function(response) {
                window.location.reload();
            }
        });
    });
</script>
@endpush
