@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Editar Nro de Facturas') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('factura::facturas.title.facturas') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}

@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <!--
                    <a href="{{-- route('admin.factura.factura.create') --}}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{-- trans('factura::facturas.button.create factura') --}}
                    </a>
                    -->
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                        {!! Form::open(array('route' => ['admin.factura.factura.updateNroFactura'],'method' => 'post')) !!}
                            <?php if (isset($NroFacturas)): ?>
                            <?php foreach ($NroFacturas as $key => $NroFactura): ?>
                            <tr>
                            
                            <div class="col-sm-3 {!! $errors->first('valor.'.$key, 'has-error') !!}">
                                <?php 
                                    $identificador=ucwords(str_replace('_', ' ', $NroFactura->identificador));

                                ?>
                                <label>{{ $identificador }}</label>
                                <input type="text"  class="form-control col-sm-3" name="valor[]" id="valor" value="{{ $NroFactura->valor }}" style=""> 
                                <div style="position: relative; width: 100%;">
                                    {!! $errors->first('valor.'.$key, '<p style="font-size: 10px">:message</p>') !!}
                                </div>

                                <br>

                                <input type="text"  class="form-control input-sm" name="etiqueta[]" id="etiqueta" value="{{ $NroFactura->identificador }}" style="width: 50%; display: none;"> 
                                <br>
                            </div>
                            
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <br>
                            <input type="submit" value="Guardar" class="search btn btn-primary btn-flat" id="filtro" style=" margin-left: 2%;display: ;">
                        {!! Form::close() !!}
                        
                    
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('factura::facturas.title.create factura') }}</dd>
    </dl>
@stop

@section('scripts')
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

    <script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/buttons.print.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/buttons.flash.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/pdfmake.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/vfs_fonts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jszip.min.js')}}"></script>
    <script type="text/javascript">
        $( document ).ready(function() 
        {







            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.factura.factura.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@stop
