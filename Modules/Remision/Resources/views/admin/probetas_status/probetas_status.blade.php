@extends('layouts.master')

@section('content-header')
    <h1 align="center">
        PROBETAS STATUS
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    @include("remision::admin.probetas_status.partials.header")
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    @include("remision::admin.probetas_status.partials.table")

                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
@stop
@section('shortcuts')
@stop

@section('scripts')
    @include("remision::admin.probetas_status.partials.script")
@stop
