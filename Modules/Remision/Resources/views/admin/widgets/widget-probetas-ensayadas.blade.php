@extends('remision::admin.widgets.layouts.widget-master')

@section('cantidad-total-probetas')
    {{ $cantidad_probetas }}
@endsection

@section('nombre-probetas')
    Probetas Ensayadas
@endsection

@section('cantidad-probetas-chicas')
    {{ $cantidad_probetas_chicas }}
@endsection

@section('cantidad-probetas-medianas')
    {{ $cantidad_probetas_medianas }}
@endsection

@section('cantidad-probetas-grandes')
    {{ $cantidad_probetas_grandes }}
@endsection