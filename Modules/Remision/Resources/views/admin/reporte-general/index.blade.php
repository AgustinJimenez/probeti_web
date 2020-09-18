@extends('layouts.master')

@section('content-header')
    <h1 class="text-center">
        Reporte de Probetas por Fecha
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right">
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    @include('remision::admin.reporte-general.partials.index.header')
                </div>
                <div class="box-body table-responsive" >
                    {{--
                         @include('remision::admin.reporte.partials.index.index-content') 
                    --}}
                    @include('remision::admin.reporte-general.partials.index.table') 
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('scripts')
    @include('remision::admin.reporte-general.partials.index.scripts.main')
@stop
