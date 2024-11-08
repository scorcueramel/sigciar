<!-- Modal -->
<?php
$codigo = Illuminate\Support\Str::random(10);
?>
<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalPago" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="modalPago">Detalles de tu reserva</h5>
                <button type="button" class="btn btn-sm btn-danger px-3 py-2" id="closeUp">X</button>
            </div>
            <form method="POST" action="{{url('/ciar/formulario/'.$codigo.'/pago')}}">
                <div class="modal-body">
                    <input type="hidden" value="{{$codigo}}" name="codigo">
                    {{ csrf_field() }}
                    @if (Auth::check())
                    <input type="hidden" value="{{ $personalInfo[0]->id }}" name="personaid" id="personaid">
                    @endif
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="fin">Fecha: </label>
                            <input type="text" class="form-control" id="fecha" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="inicio">Hora inicio:</label>
                            <input type="text" class="form-control" id="horaInicio" tabindex="-1" onfocus="this.blur()" readonly>
                            <input type="hidden" class="form-control" name="inicio" id="inicio" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="fin">Hora Final:</label>
                            <input type="text" class="form-control" id="horaFin" tabindex="-1" onfocus="this.blur()" readonly>
                            <input type="hidden" class="form-control" name="fin" id="fin" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label for="sedeModal">Sede:</label>
                            <input type="text" class="form-control" name="sede" id="sedeModal" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="lugarModal">Lugar:</label>
                            <input type="text" class="form-control" name="lugarModal" id="lugarModal" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="percioModal">Precio de Reserva:</label>
                            <input type="text" class="form-control" id="percioModalMostrar" tabindex="-1" onfocus="this.blur()" readonly>
                            <input type="hidden" class="form-control" name="precio" id="percioModal" tabindex="-1" onfocus="this.blur()" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" id="continuarReserva">Reservar Cancha</button>

                    <div class="text-center">
                        <div class="spinner-border text-primary d-none" id="boton-carga" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
