<!-- Modal -->
<div class="modal fade" id="modal_pago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalPago" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="modalPago">Reservar espacio</h5>
                <button type="button" class="btn btn-sm btn-danger px-3 py-2" id="closeUpPago">X</button>
            </div>
            <div class="modal-body">
                <form id="reserva">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Número de tarjeta">
                        </div>
                        <div class="col-md-12 py-2">
                            <input type="text" class="form-control" placeholder="MM/AA">
                        </div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="CVV">
                        </div>

                        <div class="col-md-12 pt-2">
                            <div class="form-group">
                                <select class="form-select" placeholder="Sin cuotas">
                                    <option value="" selected disabled>Sin cuotas</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <input type="submit" class="btn btn-primary" id="btnPagar"/>
            </div>
        </div>
    </div>
</div>
