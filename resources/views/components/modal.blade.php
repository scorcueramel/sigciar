<!-- Modal -->
<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalle de reserva</h5>
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
                            <label for="sede">Sede:</label>
                            <select class="form-select" name="sede" id="sede" onfocus="this.blur()">
                                <option value="0" selected disabled>Seleccionar Sede</option>
                                <option value="CHO">CHORRILLOS</option>
                                <option value="CIE">CIENEGUILLA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="lugar">Lugar:</label>
                            <select class="form-select" name="lugar" id="lugar" onfocus="this.blur()" disabled>
                                <option value="0" selected disabled>Seleccionar Lugar</option>
                                <option value="CANCHA 1">CANCHA 1</option>
                                <option value="CANCHA 2">CANCHA 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="estado">Estado de reserva:</label>
                            <input type="text" class="form-control" name="estado" id="estado" placeholder="---------" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="capacidad">Capacidad de reserva:</label>
                            <input type="text" class="form-control" name="capacidad" id="capacidad" placeholder="---------" tabindex="-1" onfocus="this.blur()" readonly>
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
