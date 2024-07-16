<section class="sedes padding" id="sedes">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h2 class="titulo mainColor altas fw-bold" data-aos="fade-up" data-aos-duration="1000">Sedes</h2>
            </div>
        </div>
        <div class="row padding3">
            <div class="col-12 col-md-6 py-4">
                <div class="item-sede position-relative" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="700">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            @if (is_null($sedes[0]->imagen))
                            <img src="{{asset('assets/images/sede-ciar-chorrillos.webp')}}" class="w-100 imagen-sede1" />
                            @else
                            <img src="{{asset('/storage/sedes/'.$sedes[0]->imagen)}}" class="w-100 imagen-sede1" />
                            @endif
                        </figure>
                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0 ms-5">
                                    {{ $sedes[0]->descripcion }}
                                </h3>
                                <div class="edades ms-5">{{$sedes[0]->direccion}}</div>
                            </div>
                        </div>
                        <div class="como-llegar text-start">
                            <a class="boton altas me-4 ms-5" id="Gmaps" href="https://maps.app.goo.gl/9PgUDDJawkrqYVUq6" target="_blank">
                                <img src="{{asset('assets/images/ic-maps.svg')}}" class="icon me-2 me-lg-1">
                                Ir con Maps</a>
                            <a class="boton altas" id="Waze" href="https://ul.waze.com/ul?place=ChIJS7Z7wW25BZERoDIXEau1ZQY&ll=-12.17061850%2C-76.99375260&navigate=yes&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location" target="_blank">
                                <img src="{{asset('assets/images/ic-waze.svg')}}" class="icon me-2 me-lg-1">
                                Ir con Waze</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 py-4 mt-5">
                <div class="item-sede position-relative" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="700">
                    <div class="contenedor-item">
                        <figure class="imagen-item">
                            @if (is_null($sedes[1]->imagen))
                            <img src="{{asset('assets/images/sede-ciar-cieneguilla.webp')}}" class="w-100" />
                            @else
                            <img src="{{asset('/storage/sedes/'.$sedes[1]->imagen)}}" class="w-100" />
                            @endif
                        </figure>
                        <div class="overlay-item text-start">
                            <div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0 ms-5">
                                    {{ $sedes[1]->descripcion }}
                                </h3>
                                <div class="edades ms-5">{{$sedes[1]->direccion}}</div>
                            </div>
                        </div>
                        <div class="como-llegar text-start">
                            <a class="boton altas me-4 ms-5" id="Gmaps" href="https://maps.app.goo.gl/bn6WoxXeiyj8KKtp6" target="_blank">
                                <img src="{{asset('assets/images/ic-maps.svg')}}" class="icon me-2 me-lg-1">
                                Ir con Maps</a>
                            <a class="boton altas" id="Waze" href="https://ul.waze.com/ul?place=ChIJqWfiwm3rBZER9a9r70uj5sk&ll=-12.11460900%2C-76.80307200&navigate=yes&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location" target="_blank">
                                <img src="{{asset('assets/images/ic-waze.svg')}}" class="icon me-2 me-lg-1">
                                Ir con Waze</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
