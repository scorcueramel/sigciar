@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', 'Tu usuario no tiene permisos suficientes')
