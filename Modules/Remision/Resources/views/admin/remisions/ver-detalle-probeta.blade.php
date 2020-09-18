@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Remisiones de Probetas') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('remision::remisions.title.remisions') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}

    <style type="text/css">
     

    </style>

@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
        <p style="text-align: center; font-size: 20px;"><strong>{{ $fecha->format('d/m/Y') }}</strong></p>
            <div class="box box-primary">
                <div class="box-header">
                </div>

                
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover" id="tablaRemision">

                        <thead>
                        <tr>
                            <th>{{ trans('Fecha Remision') }}</th>
                            <th>{{ trans('Numero de remision') }}</th>
                            <th>{{ trans('Cliente') }}</th>
                            <th>{{ trans('Obra') }}</th>
                            <th>{{ trans('Pagado') }}</th>
                            <th>{{ trans('Terminado') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php?>
                        <?php if (isset($remisions)): ?>
                        <?php foreach ($remisions as $remision): ?>
                        <tr class="{{ $remision->terminado }}"  id="{{ $remision->estado }}">
                            <td id="tdFechaReimision">
                                <a href="{{ route('admin.remision.remision.edit', [$remision->id]) }}">
                                    {{ $remision->fecha_remision }}
                                </a>
                            </td>
                            <td id="tdNumeroRemision">
                                <a href="{{ route('admin.remision.remision.edit', [$remision->id]) }}">
                                    {{ $remision->numero_remision }}
                                </a>
                            </td>
                            <td id="tdClienteNombre">
                                <a href="{{ route('admin.remision.remision.edit', [$remision->id]) }}">
                                    {{ $remision->obra->cliente->nombre }}
                                </a>
                            </td>
                            <td id="tdObraNombre">
                                <a href="{{ route('admin.remision.remision.edit', [$remision->id]) }}">
                                    {{ $remision->obra->nombre }}
                                </a>
                            </td>
                            <td class="{{ $remision->estado }}">
                                <a href="{{ route('admin.remision.remision.edit', [$remision->id]) }}">
                                    @if ($remision->estado)
                                      SI
                                    @else
                                      NO
                                    @endif
                                </a>
                            </td>
                            <td id="tdRemisionTerminado">
                                <a href="{{ route('admin.remision.remision.edit', [$remision->id]) }}">
                                    @if ($remision->terminado)
                                      SI
                                    @else
                                      NO
                                    @endif
                                </a>
                            </td>

                            <td>
                                <div class="btn-group">
                                    
                                        <a href="{{ route('admin.remision.remision.createInforme', [$remision->id]) }}" class="btn btn-default btn-flat"><i>PDF</i></a>
                                    
                                    <a href="{{ route('admin.remision.remision.edit', [$remision->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ route('admin.remision.remision.detalles', [$remision->id]) }}" class="btn btn-default btn-flat">Detalles</a>
                                    @if($remision->estado)
                                        <a href="{{ route('admin.factura.factura.edit', [$remision->id]) }}" class="btn btn-default btn-flat">Detalle Pago</a>
                                    @else
                                        <a href="{{ route('admin.factura.factura.create', [$remision->id]) }}" class="btn btn-default btn-flat">Realizar Pago</a>
                                    @endif

                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.remision.remision.destroy', [$remision->id]) }}"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ trans('Fecha Remision') }}</th>
                            <th>{{ trans('Numero de remision') }}</th>
                            <th>{{ trans('Cliente') }}</th>
                            <th>{{ trans('Obra') }}</th>
                            <th>{{ trans('Pagado') }}</th>
                            <th>{{ trans('Terminado') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
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
    <script type="text/javascript">
        $( document ).ready(function() 
        {





        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@stop
