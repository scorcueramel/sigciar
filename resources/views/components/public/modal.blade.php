<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                @if ($titulo ?? false)
                <h1 class="modal-title fs-5" id="modalLabel">{{ $titulo_modal}}</h1>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal_cuerpo">
            </div>
            @if ($botones ?? false)
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$boton_cerrar}}</button>
                <button type="button" class="btn btn-primary" id="btn-guardar">{{$boton_guardar}}</button>
            </div>
            @endif
        </div>
    </div>
</div>
