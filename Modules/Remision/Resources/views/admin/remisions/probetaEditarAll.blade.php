@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Editar Probetas') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('remision::remisions.title.remisions') }}</li>
    </ol>
    <style>
        .dataTables_length
        {
            float: left;
        }
        .col-md-3
        {
            width: 14%;
        }
        #selectTerminado
        {
            width: 100%!important;
        }
        #selectEstado
        {
            width: 100%!important;
        }
        .submit
        {
            margin-top: 1.9%;
        }
        .noDisplay
        {
            display: none;
        }
       
        
    </style>
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
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                {!! Form::open(array('route' => ['admin.remision.remision.probeta.probetaUpdateAll'],'method' => 'post')) !!}
                    <table class="data-table table table-bordered table-striped table-hover" id="tablaRemision">

                    <div id="advertencia1" style="display: none;">   
                        <label style="color: red;" id="advertencia1">Hay Datos Incorrectos</label>
                    </div>
                        <thead>
                        <tr>
                            <th class="noDisplay">{{ trans('ID') }}</th>
                            <th>{{ trans('Numero Probeta') }}</th>
                            <th>{{ trans('Fecha de moldeo') }}</th>
                            <th>{{ trans('Fecha de Rotura') }}</th>
                            <th>{{ trans('Edad(dias)') }}</th>
                            <th>{{ trans('FCK Teórico(kg/cm²)') }}</th>
                            <th>{{ trans('Tipo de Rotura') }}</th>
                            <th>{{ trans('Observación') }}</th>
                            <th>{{ trans('Diametro(cm)') }}</th>
                            <th>{{ trans('Carga de Rotura(kN)') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php?>
                        <?php if (isset($remision_detalles)): ?>
                        @foreach($remision_detalles as $key=>$remision_detalle)

                        <tr>
                            <td class="noDisplay">
                                <input type="text" class="form-control input-sm" name="id[]" value={{ $remision_detalle->id }} readonly="" class="noDisplay">
                            </td>
                            <td class="col-md-1">
                                {{ $remision_detalle->remision->obra->etiqueta}}-{{ $remision_detalle->numero_probeta }}
                            </td>
                            <td class="col-md-1">
                                {{ $remision_detalle->fecha_moldeo }}
                            </td>
                            <td class="col-md-1">
                                {{ $remision_detalle->fecha_rotura }}
                            </td>
                            <td class="col-md-1">
                                {{ $remision_detalle->dias }}
                            </td>
                            <td class="col-md-1">
                                <input class="form-control fck" type="text" name="fck[]" value="{{ $remision_detalle->wformat('fck', 3, '') }}" id='fck' autocomplete="off">
                            </td>
                            <td class="col-md-1">
                                {!! Form::select('tipo_rotura[]', [null => '--','A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G'], $remision_detalle->tipo_rotura, ['class' => 'form-control', 'style' => 'width:100%']) !!}
                            </td>
                            <td class="col-md-3">
                                <input class="form-control" type="text" name="observacion[]" value="{{ $remision_detalle->observacion }}" id='observacion' autocomplete="off">
                            </td>
                            <td class="col-md-1">
                                <input class="form-control diametro" type="text" class="calculateClass form-control input-sm" name="diametro[]" id="diametro" value="{{ $remision_detalle->wformat('diametro', 3, '') }}" autocomplete="off" required="required">
                            </td>
                            <td class="col-md-1">
                                <input class="form-control carga_aplicada" type="text" class="calculateClass form-control input-sm" name="carga_aplicada[]" id="carga_aplicada" autocomplete="off" value="{{ $remision_detalle->wformat('carga_aplicada', 3, '') }}" >
                            </td>
   
                        </tr>
                        <?php endforeach; ?>
                        @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="noDisplay">{{ trans('ID') }}</th>
                                <th>{{ trans('Numero Probeta') }}</th>
                                <th>{{ trans('Fecha de moldeo') }}</th>
                                <th>{{ trans('Fecha de Rotura') }}</th>
                                <th>{{ trans('Edad(dias)') }}</th>
                                <th>{{ trans('FCK Teórico(kg/cm²)') }}</th>
                                <th>{{ trans('Tipo de Rotura') }}</th>
                                <th>{{ trans('Observación') }}</th>
                                <th>{{ trans('Diametro(cm)') }}</th>
                                <th>{{ trans('Carga de Rotura(kN)') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <div id="advertencia2" style="display: none;">   
                        <label style="color: red;"> Hay Datos Incorrectos </label>
                    </div>
                    
                    <input type="submit" id='submit' value="Guardar" class="search btn btn-primary btn-flat" style=" margin-left: 2%; float: left;">
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
        <dd>{{ trans('remision::remisions.title.create remision') }}</dd>
    </dl>
@stop

@section('scripts')
    <script src="{{ asset('js/jquery.number.min.js') }}"></script>
    <script type="text/javascript">
        $( document ).ready(function() 
        {
            $('.fck').number(true, 3, ',','');
            $('.diametro').number(true, 3, ',','');
            $('.carga_aplicada').number(true, 3, ',','');
            

            e = jQuery.Event("keydown");        
            e.which = 50;
            e.ctrlKey = true;
            $("input").trigger(e);
            $("input").trigger(e);

            localStorage.clear();

        });
    </script>
    
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () 
        {
            $('.data-table').dataTable(
            {
                "paginate": false,
                "lengthChange": true,
                "filter": false,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": '{{ Module::asset("core:js/vendor/datatables/{$locale}.json") }}'
                }
            });
            $(document).keypressAction({actions: [{ key: 'c', route: "{{ route('admin.remision.remision.create') }}" }]});
        });
    </script>
@stop
