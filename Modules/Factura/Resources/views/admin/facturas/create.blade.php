<?php                       $DEBUG = true;      

$DEBUG?$DEBUG="text":$DEBUG="hidden";
?>
@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Crear Factura') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.factura.factura.index') }}">{{ trans('factura::facturas.title.facturas') }}</a></li>
        <li class="active">{{ trans('factura::facturas.title.create factura') }}</li>
    </ol>
@stop

@section('styles')
@stop

@section('content')
    {!! Form::open(['route' => ['admin.factura.factura.store'], 'method' => 'post', "id" => "formulario"]) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content box box-primary">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
<!--==========================FACTURA================================================-->
                            @include('factura::admin.facturas.partials.factura-fields', ['lang' => $locale])
<!--==========================FACTURA================================================-->
                        </div>
                    @endforeach
                    <div class="box-footer">
                        <div class="col-md-1"></div>
                        <button type="submit" class="btn btn-primary btn-flat">Crear Factura</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.factura.factura.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
<!--==========================SCRIPT================================================-->
    @include('factura::admin.facturas.partials.factura-script')
<!--==========================SCRIPT================================================-->
@stop
