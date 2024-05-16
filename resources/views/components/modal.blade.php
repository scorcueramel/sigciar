<!-- Modal -->
<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalReserva" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReserva">Detalle de reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeUp"></button>
            </div>
            <div class="modal-body">
                <form id="reserva">
                    {{ csrf_field() }}
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="inicio">Fecha y Hora inicio:</label>
                            <input type="text" class="form-control" name="inicio" id="inicio" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="fin">Fecha y Hora Final:</label>
                            <input type="text" class="form-control" name="fin" id="fin" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="sedeModal">Sede:</label>
                            <input type="text" class="form-control" name="sede" id="sedeModal" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="lugar">Lugar:</label>
                            <input type="text" class="form-control" name="lugar" id="lugar" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="precio">Precio de reserva:</label>
                            <input type="text" class="form-control" name="precio" id="precio" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnClose">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardar">Reservar</button>
            </div>
        </div>
    </div>
</div>
