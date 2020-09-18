@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Clientes') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('clientes::clientes.title.clientes') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.clientes.clientes.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('clientes::clientes.button.create clientes') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover" >
                        <thead>
                        <tr>
                            <th>{{ trans('Nombre') }}</th>
                            <th>{{ trans('RUC') }}</th>
                            <th>{{ trans('Teléfono') }}</th>
                            <th>{{ trans('Dirección') }}</th>
                            <th>{{ trans('Contacto') }}</th>
                            
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ trans('Nombre') }}</th>
                            <th>{{ trans('RUC') }}</th>
                            <th>{{ trans('Teléfono') }}</th>
                            <th>{{ trans('Dirección') }}</th>
                            <th>{{ trans('Contacto') }}</th>
                            <th>Acciones</th>
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
        <dd>{{ trans('clientes::clientes.title.create clientes') }}</dd>
    </dl>
@stop

@section('scripts')
    <style type="text/css">
        table.data-table  > thead > tr:nth-child(2)
        {
            display: none;

        }

        .data-table
        {
            width:100%!important;
        }
    </style>
    <script type="text/javascript">
        $( document ).ready(function()
        {

        });

            
    </script>
    <?php $locale = locale(); ?>    
    <script type="text/javascript">
        var count=0;
        $(function () 
        {
            var table = $('.data-table').DataTable(
            {
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",

                "deferRender": true,
                processing: false,
                serverSide: true,
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                ajax: '{!! route('admin.clientes.clientes.indexAjax') !!}',
                columns: 
                [
                    { data: 0, name: 'nombre' },
                    { data: 1, name: 'ruc' },
                    { data: 2, name: 'telefono' },
                    { data: 3, name: 'direccion' },
                    { data: 4, name: 'contacto' },
                    { data: 6, name: 'acciones', orderable: false, searchable: false} 
                ],
                initComplete: function () 
                {
                    this.api().columns().every(function () 
                    {

                        var column = this;

                        var input = document.createElement("input");
                        input.setAttribute("id",count );
                        count=count+1;
                        
                        $(input).appendTo($(column.footer()).empty()).on('keyup', function () 
                        {
                            var dato = $(this).val();
                            column.search(dato, false, false, true).draw();

                        });
                    });
                }

                
            });



            $('.data-table tbody').on('click', 'td.details-control', function () 
            {


                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) 
                {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else 
                {
                    row.child( template(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
            $('.data-table tfoot tr').appendTo('.data-table thead');








            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.clientes.clientes.create') ?>" }]})
        });
    </script>
@stop
