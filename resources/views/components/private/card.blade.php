<div class="card h-100">
    <div class="card-body">
        @if($estado ?? false)
            @if ($estadoActual == 'A')
                <span class="estado">
                    <button class="btn btn-sm btn-primary change-state btn-estado mb-3" data-id="{{ $estadoId ?? '' }}">ACTIVO</button>
                </span>
            @else
                <span class="estado">
                    <button class="btn btn-sm btn-danger change-state btn-estado mb-3" data-id="{{ $estadoId ?? '' }}">INACTIVO</button>
                </span>
            @endif
        @endif
        @if($titulo ?? false)
            <h5 class="card-title">{{$titulo ?? ''}}</h5>
        @endif
        @if($subtitulo ?? false)
            <h6 class="card-subtitle text-muted">{{$subtitulo ?? ''}}</h6>
        @endif
        @if($imagen ?? false)
            <img
                class="img-fluid d-flex mx-auto my-6 rounded"
                src="{{$imagenDestacada ?? ''}}"
                alt="Card image cap"
            />
        @endif
        @if($muestraExtracto ?? false)
            {!! $extracto !!}
        @endif
        @if($botones ?? false)
            @if($botonDetalle ?? false)
                <a href="#" role="button" data-id="{{ $detalleId ?? '' }}" class="btn rounded-pill btn-outline-info btn-detail btn-sm">Detalle</a>
            @endif
            @if($botonEditar ?? false)
                <a href="{{ $ruta ?? '' }}" class="btn rounded-pill btn-outline-success btn-edit btn-sm">Editar</a>
            @endif
            @if($botonEliminar ?? false)
                <a href="#" role="button" class="btn rounded-pill btn-outline-danger delete btn-sm" data-id="{{ $eliminarId ?? '' }}">Eliminar</a>
            @endif
        @endif
    </div>
</div>
