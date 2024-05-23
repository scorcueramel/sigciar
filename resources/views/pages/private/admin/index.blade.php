@extends('layouts.private.layout_private')
@push('title','Administración')

@section('content')

@endsection

{{-- @extends('layouts.public.app')
@section('title', 'Inicio')
@include('layouts.public.contac-logo')
@include('layouts.public.navbar')
@section('content')
@include('layouts.public.slider')
@include('layouts.public.aplications')
@if ($ssetEstado[0]->SIGPEESTADO)
@include('layouts.public.security-health-work')
@endif
@include('layouts.public.information-worker')
@include('layouts.public.footer')
@if ($popupactivo[0]['SIGPEESTADO'])
@include('layouts.public.popup')
@endif
@endsection
@section('js')
<script>
    var punto = document.getElementById('firtspoint');
    punto.value == 0 ? punto.classList.add('active') : null;
</script>
@endsection --}}
