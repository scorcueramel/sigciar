@extends('layouts.public.app')
@push('title', 'Reservas')

@section('content')
    {{-- Barra de navegación --}}
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="btn btn-success" href="{{ route('login') }}">
                                    <i class="fa-solid fa-user-vneck" style="color: #fff; margin-right: 5px"></i>
                                    Ir a mi cuenta
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <input type="hidden" id="loginCheck" value="{{ Auth::check() }}">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if ($authenticate)
                                {{ $personalInfo[0]->nombres.' '.$personalInfo[0]->apepaterno.' '.$personalInfo[0]->apematerno }}
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Cerra Sesión') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row bg-secondary py-4">
            <div class="col-md-12">
                <div class="row mb-5">
                    <div class="col-md-12 text-center">
                        <h1 class="title_rse text-white">Reserva de Espacios</h1>
                        {{-- <h1 class="title_rse text-white">Calendario de Visitas</h1> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-end">
                        <small style="color:#fff;font-weight: bold;">
                            <i class="fa-duotone fa-circle" style="color: yellow"></i>
                            Disponible
                        </small>
                    </div>
                    <div class="col-4 text-center">
                        <small style="color:#fff;font-weight: bold;">
                            <i class="fa-duotone fa-circle" style="color: tomato"></i>
                            Ocupado
                        </small>
                    </div>
                    <div class="col-4">
                        <small style="color:#fff;font-weight: bold;">
                            <i class="fa-duotone fa-circle" style="color: cyan"></i>
                            Sleccionado
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-4 pb-3 d-flex justify-content-center">
            <div class="col-md-10 options">
                <div class="row pb-4 align-items-center">
                    <div class="col-md-6">
                        <label for="sede" class="descripcion">
                            <i class="fa-regular fa-circle-right"></i>
                            Seleccione la Sede:
                        </label>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-2">
                            <label class="input-group-text border-secondary shadow-sm" for="sede"><i
                                    class="fa-solid fa-buildings"></i></label>
                            <select class="form-select border-secondary shadow-sm" id="sede" onfocus="this.blur()">
                                <option value="0" selected disabled>Seleccionar sede</option>
                                @foreach ($sede as $s)
                                    <option value="{{ $s->id }}">{{ $s->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="lugar" class="descripcion"><i class="fa-regular fa-circle-right"></i>
                            Seleccione la Cancha:
                        </label>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text border-secondary shadow-sm" for="lugar"><i
                                    class="fa-solid fa-court-sport"></i></label>
                            <select class="form-select border-secondary shadow-sm" id="lugar" onfocus="this.blur()" disabled>
                                <option selected disabled>Seleccionar cancha</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-4 d-flex justify-content-center">
            <div class="col-md-10 calendar">
                <div id='reservation'></div>
            </div>
        </div>
    </div>
    @include('components.modal')
@endsection
@push('js')
    <script src="{{ asset('assets/js/personalized/reservation.js') }}" type="module"></script>
    <script>
        function cleanInpust() {
            $("#modal").modal('hide');
            $("#inicio").val("");
            $("#fin").val("");
            $("#estado").val("");
            $("#capacidad").val("");
            $("#sedeModal").val("");
            $("#lugarModal").val("");
            $('#lugar :nth-child(0)').prop('selected', true);
        }

        $("#btnClose").on('click', () => {
            cleanInpust();
        });

        $("#closeUp").on('click', () => {
            cleanInpust();
        });

        $('#sede').change(() => {
            $('#lugar').removeAttr("disabled");
        });
    </script>
@endpush
