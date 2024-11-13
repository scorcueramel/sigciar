<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-{{$tamanio_modal ?? 'lg'}}">
        <div class="modal-content">
            @if ($titulo ?? false)
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel">{{ $titulo_modal ?? 'Modal Title'}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif
            <div class="modal-body modal_cuerpo">
            </div>
            @if ($botones ?? false)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="boton-cerrar">{{$boton_cerrar ?? 'Cancelar'}}</button>
                    <button type="button" class="btn btn-primary"
                            id="btn-guardar">{{$boton_guardar ?? 'Guardar'}}</button>
                </div>
            @endif
        </div>
    </div>
</div>
