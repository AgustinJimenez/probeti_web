@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Obras') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('obras::obras.title.obras') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.obras.obras.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('obras::obras.button.create obras') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="obras" class="data-table table table-bordered table-hover">
                        <thead>

                        <tr>
                            <th>{{ trans('Etiqueta') }}</th>
                            <th>{{ trans('Nombre') }}</th>
                            <th>{{ trans('Ubicacion') }}</th>
                            <th>{{ trans('Residente') }}</th>
                            <th>{{ trans('Cliente') }}</th>
                            <th>{{ trans('Activo') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>

                        </thead>
                        <tbody>
                        <?php if (isset($obras)): ?>
                        <?php foreach ($obras as $obras): ?>
                        <tr>
                            <td>
                                <a href="{{ route('admin.obras.obras.edit', [$obras->id]) }}">
                                    {{ $obras->etiqueta }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.obras.obras.edit', [$obras->id]) }}">
                                    {{ $obras->nombre }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.obras.obras.edit', [$obras->id]) }}">
                                    {{ $obras->ubicacion }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.obras.obras.edit', [$obras->id]) }}">
                                    {{ $obras->residente }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.obras.obras.edit', [$obras->id]) }}">
                                    {{ $obras->cliente->nombre }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.obras.obras.edit', [$obras->id]) }}">
                                    @if($obras->activo)
                                        SI
                                    @else
                                        NO
                                    @endif
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary btn-flat" href="{{ route('admin.remision.remision.reporte_remision_obra_cliente', ['obra' => $obras->id, 'cliente' => $obras->cliente->id] ) }}">
                                    <strong>REPORTE</strong>
                                    </a>
                                    <a href="{{ route('admin.obras.obras.edit', [$obras->id]) }}" class="btn btn-default btn-flat">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.obras.obras.destroy', [$obras->id]) }}">
                                    <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ trans('Etiqueta') }}</th>
                            <th>{{ trans('Nombre') }}</th>
                            <th>{{ trans('Ubicacion') }}</th>
                            <th>{{ trans('Residente') }}</th>
                            <th>{{ trans('Cliente') }}</th>
                            <th>{{ trans('Activo') }}</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </tfoot>
                    </table>
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
        <dd>{{ trans('obras::obras.title.create obras') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            // Setup - add a text input to each footer cell
//            $('#obras tfoot th').each( function () {
//                var title = $(this).text();
//                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
//            } );
         
    </script>

    <?php $locale = locale(); ?>

    <script type="text/javascript">
        $(function () 
        {
            $('.data-table').dataTable(
            {
                "paginate": true,
                "lengthChange": true,
                "filter": false,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });




    /*
        $(function () 
        {
           var table =  $('#obras').DataTable(
           {
                dom: 'Bfrtip',
                //bFilter: false,
                bInfo: false,
                "paginate": true,
                "lengthChange": true,
                //"filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "aoColumns": [
                    { "bSearchable": true},
                    { "bSearchable": true},
                    { "bSearchable": true},
                    { "bSearchable": true},
                    { "bSearchable": true},

                ]
                //"order": [[ 0, "desc" ]],

            });
            // Apply the search
           table.columns().every( function () {
                var that = this;
               $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                    .search( this.value )
                    .draw();
                }
               });
           });
        });
    */
    </script>
@stop
