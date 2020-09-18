@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Detalle de Remision') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('remision::remisions.title.remisions') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                
                {{--<div class="btn-group pull-right" style="margin: 0 15px 15px 0;">--}}
                    {{--<a href="{{ route('admin.remision.remision.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">--}}
                        {{--<i class="fa fa-pencil"></i> {{ trans('remision::remisions.button.create remision') }}--}}
                    {{--</a>--}}
                {{--</div>--}}
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <p><strong>N° de Remision:</strong> {{ $remision->numero_remision }}</p>
                    <p><strong>Fecha:</strong> {{ $remision->fecha_remision }}</p>
                    <p><strong>Obra:</strong> {{ $remision->obra->nombre }}</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Numero de Probeta') }}</th>
                            <th>{{ trans('Fecha de moldeo') }}</th>
                            <th>{{ trans('Edad(dias)') }}</th>
                            <th>{{ trans('Fecha de rotura') }}</th>
                            <th>{{ trans('Tipo') }}</th>
                            <th>{{ trans('Pieza Estructural') }}</th>
                            <th>{{ trans('Fck Teorico (kg/cm²)') }}</th>
                            <th>{{ trans('Diametro(cm)') }}</th>
                            <th>{{ trans('Altura (cm)') }}</th>
                            <th>{{ trans('Peso (Kg)') }}</th>
                            <th>{{ trans('Peso Especifico (TON/cm&sup3;)') }}</th>
                            <th>{{ trans('Carga de Rotura(kgN)') }}</th>
                            <th>{{ trans('Resistencia(kg/cm²)') }}</th>
                            <th>{{ trans('Porcentaje') }}</th>
                        </tr>
                        </thead>
                    <div style="overflow-x:auto;" class="row">
                    
                        <tbody>
                        <?php if (isset($remision_detalles)): ?>
                        <?php foreach ($remision_detalles as $key => $remision): ?>
                        <tr>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $key+1 }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->numero_probeta }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->fecha_moldeo }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->dias }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->fecha_rotura }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->size_clasification }}
                                </a>
                            </td>
                            <td>
                                
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->pieza_estructural }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->wformat('fck') }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->wformat('diametro') }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->wformat('altura') }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->wformat('peso') }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->peso_especifico }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->wformat('carga_aplicada') }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->wformat('resistencia') }}
                                </a>
                            </td>
                             <td>
                                <a href="{{ route('admin.remision.remision.detalle.edit', [$remision->id]) }}">
                                    {{ $remision->relacion_fck_resistencia }}
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>

                    </div>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Numero de Probeta') }}</th>
                            <th>{{ trans('Fecha de moldeo') }}</th>
                            <th>{{ trans('Edad(dias)') }}</th>
                            <th>{{ trans('Fecha de rotura') }}</th>
                            <th>{{ trans('Tipo') }}</th>
                            <th>{{ trans('Pieza Estructural') }}</th>
                            <th>{{ trans('Fck Teorico (kg/cm²)') }}</th>
                            <th>{{ trans('Diametro(cm)') }}</th>
                            <th>{{ trans('Altura (cm)') }}</th>
                            <th>{{ trans('Peso (Kg)') }}</th>
                            <th>{{ trans('Peso Especifico (TON/cm&sup3;)') }}</th>
                            <th>{{ trans('Carga de Rotura(kgN)') }}</th>
                            <th>{{ trans('Resistencia(kg/cm²)') }}</th>
                            <th>{{ trans('Porcentaje') }}</th>
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
        <dt><code>c</code></dt>
        <dd>{{ trans('remision::remisions.title.create remision') }}</dd>
    </dl>
@stop

@section('scripts')

    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "{{ route('admin.remision.remision.create') }}" }
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
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": '{{ Module::asset("core:js/vendor/datatables/{$locale}.json") }}'
                }
            });
        });
    </script>
@stop