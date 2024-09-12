@extends('layouts.public.landing')
@push('title', 'Nuestras Promesas')
@section('content')
@include('components.public.header',['sedes'=>"/ciar/#sedes"])
<section class="banner esInterna position-relative">
    <div class="container padding position-relative">
        <div class="row justify-content-center justify-content-md-start position-relative">
            <div class="col-11 col-md-12 col-xl-12 text-center">
                <div class="padding2"></div>
                <h2 class="titulo altas fw-bold mb-3 mb-lg-4">Nuestras Promesas</h2>
            </div>
        </div>
    </div>
</section>
<section class="promesas-interna padding interna bgLightblue" id="promesas-interna">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-11 col-md-5 px-5">
                <img src="{{asset('/storage/promesas/'.$promesa->foto)}}" class="w-100" />
            </div>
            <div class="col-11 col-md-5 text-start ps-5">
                <h2 class="titulo mainColor fw-bold mb-1">{{$promesa->nombre}}</h2>
                <p class="edad">{{$promesa->edad}}</p>
                <div class="row datos-personales">
                    <div class="col-6 col-md-6">
                        <div class="row">
                            <div class="col-12 col-md-12 bgWhite text-end">
                                <span class="text-start fw-bold">Peso</span> {{ $promesa->peso }}
                            </div>
                            <div class="col-12 col-md-12 bgWhite text-end">
                                <span class="text-start fw-bold">Estatura</span> {{ $promesa->estatura }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 bgWhite text-end">
                        <span class="text-start fw-bold">EDAD</span>
                        <div class="utr mt-2">{{$promesa->edad}}</div>
                    </div>
                    <div class="col-12 col-md-12 bgWhite text-end">
                        <span class="text-start fw-bold">Mano</span> {{ $promesa->mano }}
                    </div>
                    <div class="col-12 col-md-12 bgWhite text-end">
                        <span class="text-start fw-bold">Academia</span> {{ $promesa->academia }}
                    </div>
                    <div class="col-12 col-md-12 bgWhite text-end">
                        <span class="text-start fw-bold">Preparador físico</span> {{ $promesa->preparador }}
                    </div>
                    <div class="col-12 col-md-12 bgWhite text-end">
                        <span class="text-start fw-bold">Nutricionista</span> {{ $promesa->nutricionista }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="promesas-interna padding interna">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-md-8 text-start">
                {!! $promesa->detalle !!}
            </div>
        </div>
    </div>
</section>
@include('components.public.footer')
@include('components.public.fixed')
@endsection
