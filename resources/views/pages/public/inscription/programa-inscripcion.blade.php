
@extends('layouts.public.landing')
@push('title', 'Inscripcion a programa')
@section('content')
@include('components.public.header',['sedes'=>"/ciar/#sedes"])
<section class="banner esInterna position-relative">
    <div class="container padding position-relative">
        <div class="row justify-content-center justify-content-md-start position-relative">
            <div class="col-11 col-md-12 col-xl-12 text-center">
                <div class="padding2"></div>
                <h2 class="titulo altas fw-bold mb-3 mb-lg-4">Inscribete al programa</h2>
            </div>
        </div>
    </div>
</section>
@foreach($programaResponse as $pr)
<section class="programas-tipo padding interna bgLightblue">
	<div class="container">
		<div class="row justify-content-center align-items-center">
			<div class="col-11 col-md-5 text-start ps-5">
				<h2 class="titulo mainColor fw-bold mb-1">{{$pr->titulo}}</h2>
				<p class="edades mainColor">{{$pr->subtitulo}}</p>

				<p>Optimiza tu bienestar con los informes de optimización epigenética, diseñados para ofrecer información precisa sobre tus necesidades nutricionales, factores externos, y estado de tus sistemas metabólicos.</p>
				<ul class="beneficios">
					<li>Agrupamos de acuerdo al nivel</li>
					<li>Clases de  una (1) hora</li>
					<li>8 cupos disponibles</li>
				</ul>
				<h3 class="mainColor fw-bold altas">Horario</h3>
				<p>{{$pr->horario}}</p>
                <h3 class="mainColor fw-bold altas">Costo por hora</h3>
				<p>{{$pr->costohora}}</p>
			</div>
			<div class="col-11 col-md-5 px-5">
				<img src="{{asset('storage/subtipos/'.$pr->imagen)}}" class="w-100" />
			</div>

		</div>
	</div>
</section>
<section class="programas-tipo padding interna">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-11 col-md-10 text-start ps-5">
				<h3 class="mainColor fw-bold altas">Primero selecciona las clases por semana:</h3>

				<h3 class="mainColor fw-bold altas">Total a pagar: S/<span class="total"> 320</span></h3>

				<a class="btn-cta altas mt-5" href="#">
					<img src="images/arrow-bt.svg" class="icon me-2 me-lg-1" /> Inscríbete aquí
				</a>
			</div>
		</div>
	</div>
</section>
@endforeach
@include('components.public.footer')
@include('components.public.fixed')
@endsection
