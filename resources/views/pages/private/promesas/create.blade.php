@extends('layouts.private.private', ['activePage' => 'promesas.create'])
@push('title', 'Nueva Promesa')
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Promesas /</span> Crear Nueva </h4>
<!-- Basic Layout & Basic with Icons -->
<div class="row mb-3">
    <!-- Basic with Icons -->
    <div class="col-xxl">
        <form method="post" action="{{route('promesas.store')}}" enctype="multipart/form-data" class="row g-3 needs-validation" id="form" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nombre">Nombres</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="nombre2" class="input-group-text"><i class="fa-light fa-input-text"></i></span>
                                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Nombres" aria-label="nombres" aria-describedby="nombre2" name="nombre" value="{{old('nombre')}}" maxlength="200" autofocus required />
                                @error('nombre')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="edad">Edad</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="edad2" class="input-group-text"><i class="fa-light fa-input-numeric"></i></span>
                                <input type="text" id="edad" class="form-control @error('edad') is-invalid @enderror" placeholder="edad" aria-label="edad" aria-describedby="edad2" name="edad" value="{{old('edad')}}" maxlength="200" autofocus required />
                                @error('edad')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="peso">Pesos</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="peso2" class="input-group-text"><i class="fa-light fa-weight-scale"></i></span>
                                <input type="text" id="peso" class="form-control @error('peso') is-invalid @enderror" placeholder="Pesos" aria-label="pesos" aria-describedby="peso2" name="peso" value="{{old('peso')}}" maxlength="200" autofocus required />
                                @error('peso')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="estatura">Estatura</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="estatura2" class="input-group-text"><i class="fa-light fa-ruler-vertical"></i></span>
                                <input type="text" id="estatura" class="form-control @error('estatura') is-invalid @enderror" placeholder="estaturas" aria-label="estaturas" aria-describedby="estatura2" name="estatura" value="{{old('estatura')}}" maxlength="200" autofocus required />
                                @error('estatura')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="mano">Mano</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="mano2" class="input-group-text"><i class="fa-light fa-hand"></i></span>
                                <input type="text" id="mano" class="form-control @error('mano') is-invalid @enderror" placeholder="manos" aria-label="manos" aria-describedby="mano2" name="mano" value="{{old('mano')}}" maxlength="200" autofocus required />
                                @error('mano')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="utr">UTR</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="utr2" class="input-group-text"><i class="fa-light fa-input-numeric"></i></span>
                                <input type="text" id="utr" class="form-control @error('utr') is-invalid @enderror" placeholder="utr" aria-label="utr" aria-describedby="utr2" name="utr" value="{{old('utr')}}" maxlength="5" autofocus required />
                                @error('utr')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="academia">Academia</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="academia2" class="input-group-text"><i class="fa-light fa-building-columns"></i></span>
                                <input type="text" id="academia" class="form-control @error('academia') is-invalid @enderror" placeholder="academia" aria-label="academia" aria-describedby="academia2" name="academia" value="{{old('academia')}}" maxlength="200" autofocus required />
                                @error('academia')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="preparador">Preparador Físico</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="preparador2" class="input-group-text"><i class="fa-light fa-person-chalkboard"></i></span>
                                <input type="text" id="preparador" class="form-control @error('preparador') is-invalid @enderror" placeholder="preparador" aria-label="preparador" aria-describedby="preparador2" name="preparador" value="{{old('preparador')}}" maxlength="200" autofocus required />
                                @error('preparador')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nutricionista">Nutricionista</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="nutricionista2" class="input-group-text"><i class="fa-light fa-salad"></i></span>
                                <input type="text" id="nutricionista" class="form-control @error('nutricionista') is-invalid @enderror" placeholder="nutricionista" aria-label="nutricionista" aria-describedby="nutricionista2" name="nutricionista" value="{{old('nutricionista')}}" maxlength="200" autofocus required />
                                @error('nutricionista')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 mt-2">
                        <label class="col-sm-2 form-label" for="extracto">Extracto</label>
                        <div class="col-sm-10">
                            <textarea id="extracto" class="form-control @error('extracto') is-invalid @enderror" placeholder="Agrega una descripción con formato" aria-label="Agrega una descripción con formato" aria-describedby="extracto2" rows="1" name="extracto">{{old('extracto')}}</textarea>
                            @error('extracto')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="imagen">Foto</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="imagen" class="input-group-text @error('imagen') @enderror"><i class="bx bx-image-add"></i></span>
                                <input class="form-control" type="file" id="cargarImagen" placeholder="Carga una Imagen" aria-label="Cargar Imagen" aria-describedby="imagen" name="imagen" value="{{old('imagen')}}" accept="image/*" max-size="2000" required />
                            </div>
                            <div class="form-text">Seleccionas imagenes en formato .PNG .JPG .JPEG</div>
                            @error('imagen')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-xxl">
                            <div class="card-body d-flex justify-content-center">
                                <img class="img-fluid" src="{{ asset('assets/images/default-img.gif') }}" id="imagenSeleccionada" style="max-height: 335px;">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Registrar Promesa</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#cargarImagen').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#extracto').summernote({
            placeholder: 'Agrega una descripción con formato',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
            ]
        });
    });

    $("#form").on('submit', function() {
        Swal.fire({
            icon: 'info',
            html: "Espere un momento porfavor ...",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

    // $("#nombre").on('keyup', function() {
    //     var str = $(this).val();
    //     str = str.replace(/\s+/g, '-').toLowerCase();
    //     $('#slug').val(str);
    // });
</script>
@endpush
