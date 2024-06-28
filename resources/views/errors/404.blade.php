@extends('errors.template-error')

@section('title', __('No Encontrado'))
@section('content')
    <!-- Content -->

    <!-- Error -->
    <div class="container-xxl container-p-y text-center mt-5 pt-5">
        <div class="misc-wrapper mt-5 pt-5">
            <h2 class="mb-2 mx-2">Página no encontrada :(</h2>
            <p class="mb-4 mx-2">Oops! 😖 Parece que la URL que búscas no se esta disponible o no existe.</p>
            <a href="{{route('home')}}" class="btn btn-primary">Ir al inicio</a>
            <div class="mt-3">
                <img
                    src="{{asset('assets/images/page-misc-error-light.png')}}"
                    alt="page-misc-error-light"
                    width="500"
                    class="img-fluid"
                    data-app-dark-img="illustrations/page-misc-error-dark.png"
                    data-app-light-img="illustrations/page-misc-error-light.png"
                />
            </div>
        </div>
    </div>
    <!-- /Error -->
@endsection
