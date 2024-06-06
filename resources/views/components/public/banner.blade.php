<section class="banner position-relative">
    <div class="swiper swPortada">
        <div class="swiper-wrapper">
            <div class="swiper-slide bgDark d-flex align-items-center position-relative">
                <picture>
                    <source srcset="{{ asset('assets/images/portada/portada1-xl.webp') }}" media="(min-width: 1200px)">
                    <source srcset="{{ asset('assets/images/portada/portada1-md.webp') }}" media="(min-width: 768px)">
                    <img class="fondo position-absolute" src="images/portada/portada1-mobile.webp" alt="Centro internacional <span>de alto rendimiento</span>">
                </picture>
                <div class="container padding position-relative">
                    <div class="row justify-content-center justify-content-md-start">
                        <div class="col-11 col-md-8 col-xl-7 text-md-start">
                            <div class="padding"></div>
                            <h2 class="titulo altas fw-bold mb-3 mb-lg-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="500">Centro internacional <span>de alto rendimiento</span></h2>
                            <a class="btn-cta" href="{{ route('reservation') }}" target="_blank" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="800"><img src="{{ asset('assets/images/calendar.svg') }}" class="icon me-2 me-lg-1" />Reserva tu cancha</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide bgDark d-flex align-items-center position-relative">
                <picture>
                    <source srcset="{{ asset('assets/images/portada/portada2-xl.webp') }}" media="(min-width: 1200px)">
                    <source srcset="{{ asset('assets/images/portada/portada2-md.webp') }}" media="(min-width: 768px)">
                    <img class="fondo position-absolute" src="images/portada/portada2-mobile.webp" alt="Centro internacional <span>de alto rendimiento</span>">
                </picture>
                <div class="container padding position-relative">
                    <div class="row justify-content-center justify-content-md-start">
                        <div class="col-11 col-md-8 col-xl-7 text-md-start">
                            <div class="padding"></div>
                            <h2 class="titulo altas fw-bold mb-3 mb-lg-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="500">Centro internacional <span>de alto rendimiento</span></h2>
                            <a class="btn-cta" href="{{ route('reservation') }}" target="_blank" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="800"><img src="{{ asset('assets/images/calendar.svg') }}" class="icon me-2 me-lg-1" />Reserva tu cancha</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
