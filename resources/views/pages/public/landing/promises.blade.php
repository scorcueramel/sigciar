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
<section class="promesas-interna padding interna" id="promesas-interna">
	<div class="container">
		<div class="row justify-content-center align-items-center">
			<div class="col-11 col-md-5">
				<img class="w-100" src="{{asset('/storage/noticias/'.$noticiaPromesas[0]->imagen_destacada)}}" alt="CIAR" />
			</div>
			<div class="col-11 col-md-6 text-start px-5 intro">
				<h2 class="titulo mainColor altas fw-bold mb-4">{{$noticiaPromesas[0]->titulo}}</h2>
                {!! $noticiaPromesas[0]->extracto !!}
                <p class="lema"></p>
				{!! $noticiaPromesas[0]->cuerpo !!}
			</div>
		</div>
        @if (count($promesas) > 0)
		<div class="row padding2">
			<h2 class="titulo mainColor altas fw-bold mt-5 mb-4" style="margin-bottom: 25px !important;">Apoyemos a jóvenes promesas</h2>
            @foreach ($promesas as $promesa)
			<div class="col-11 col-md-4 py-4">
                <div class="item-promesas position-relative">
                    <div class="contenedor-item">
						<figure class="imagen-item">
                            <a href="{{route('landing.promises.details',$promesa->id)}}">
								<img src="{{asset('/storage/promesas/'.$promesa->foto)}}" class="w-100" />
							</a>
						</figure>

						<div class="overlay-item text-start">
							<div class="info-item py-3 px-3">
                                <h3 class="titulo-item altas mb-0">
                                    <a href="{{route('landing.promises.details',$promesa->id)}}">{{$promesa->nombre}}</a>
								</h3>
								<div class="edades altas">{{$promesa->edad}}<a href="{{route('landing.promises.details',$promesa->id)}}" class="enlace"><img src="{{asset('assets/images/link.svg')}}" /></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
            @endforeach
		</div>
        @else
		<div class="row padding2">
			<h2 class="titulo mainColor altas fw-bold mt-5 mb-4" style="margin-bottom: 25px !important;">Apoyemos a jóvenes promesas</h2>
			<div class="col-11 col-md-4 py-4 my-5">
				<div class="item-promesas position-relative">
					<div class="contenedor-item">
						<figure class="imagen-item">
							<a href="promesa-1.php">
								<img src="images/promesas/bernardo-penaranda.webp" class="w-100" />
							</a>
						</figure>

						<div class="overlay-item text-start">
							<div class="info-item py-3 px-3">
								<h3 class="titulo-item altas mb-0">
									<a href="promesa-1.php">Bernardo Peñaranda Kaptsionak</a>
								</h3>
								<div class="edades altas">11 años<a href="promesa-1.php" class="enlace"><img src="images/link.svg" /></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 py-4 my-5">
				<div class="item-promesas position-relative">
					<div class="contenedor-item">
						<figure class="imagen-item">
							<a href="#">
								<img src="images/promesas/promesa2.webp" class="w-100" />
							</a>
						</figure>

						<div class="overlay-item text-start">
							<div class="info-item py-3 px-3">
								<h3 class="titulo-item altas mb-0">
									<a href="#">Cesar Araoz</a>
								</h3>
								<div class="edades altas">14 años <a href="#" class="enlace"><img src="images/link.svg" /></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 py-4 my-5">
				<div class="item-promesas position-relative">
					<div class="contenedor-item">
						<figure class="imagen-item">
							<a href="#">
								<img src="images/promesas/promesa3.webp" class="w-100" />
							</a>
						</figure>

						<div class="overlay-item text-start">
							<div class="info-item py-3 px-3">
								<h3 class="titulo-item altas mb-0">
									<a href="#">Julio Laos</a>
								</h3>
								<div class="edades altas">14 años <a href="#" class="enlace"><img src="images/link.svg" /></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 py-4 my-5">
				<div class="item-promesas position-relative">
					<div class="contenedor-item">
						<figure class="imagen-item">
							<a href="#">
								<img src="images/promesas/promesa4.webp" class="w-100" />
							</a>
						</figure>

						<div class="overlay-item text-start">
							<div class="info-item py-3 px-3">
								<h3 class="titulo-item altas mb-0">
									<a href="#">Jorge Milla</a>
								</h3>
								<div class="edades altas">14 años <a href="#" class="enlace"><img src="images/link.svg" /></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 py-4 my-5">
				<div class="item-promesas position-relative">
					<div class="contenedor-item">
						<figure class="imagen-item">
							<a href="#">
								<img src="images/promesas/promesa5.webp" class="w-100" />
							</a>
						</figure>

						<div class="overlay-item text-start">
							<div class="info-item py-3 px-3">
								<h3 class="titulo-item altas mb-0">
									<a href="#">Celia Garcia</a>
								</h3>
								<div class="edades altas">14 años <a href="#" class="enlace"><img src="images/link.svg" /></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 py-4 my-5">
				<div class="item-promesas position-relative">
					<div class="contenedor-item">
						<figure class="imagen-item">
							<a href="#">
								<img src="images/promesas/promesa6.webp" class="w-100" />
							</a>
						</figure>

						<div class="overlay-item text-start">
							<div class="info-item py-3 px-3">
								<h3 class="titulo-item altas mb-0">
									<a href="#">Brissa Klein</a>
								</h3>
								<div class="edades altas">14 años <a href="#" class="enlace"><img src="images/link.svg" /></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        @endif
	</div>
</section>
@include('components.public.footer')
@include('components.public.fixed')
@endsection
