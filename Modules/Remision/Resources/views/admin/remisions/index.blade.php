@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Remisiones') }}
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
     
        .submit
        {
            margin-top: 1.9%;
        }

    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.remision.remision.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('remision::remisions.button.create remision') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                        {!! Form::open(array('route' => ['admin.remision.remision.index'],'method' => 'get')) !!}
                        <div class="row" >
                            <div id="DataTables_Table_0_filter" class="dataTables_filter search col-md-2" style="float: left:" >
                                <label>Cliente:<input type="search" class="form-control input-sm" placeholder="Busca Cliente" aria-controls="DataTables_Table_0" id="inputCliente" value="{{-- $cliente --}}" name="inputCliente">
                                </label>
                            </div>

                            <div id="DataTables_Table_0_filter" class="dataTables_filter search col-md-2" style="float: left:">
                                <label>Obra:<input type="search" class="form-control input-sm" placeholder="Busca Obra" aria-controls="DataTables_Table_0" id="inputObra" value="{{-- $obra --}}" name="inputObra">
                                </label>
                            </div>
                            <div id="DataTables_Table_0_filter" class="dataTables_filter search col-md-2" style="float: left:">
                                <label>Nro Remision:<input type="search" class="form-control input-sm" placeholder="Busca Nro Remision" aria-controls="DataTables_Table_0" id="inputNroRemision" value="{{-- $nroRemision --}}" name="inputNroRemision">
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="search col-md-2">
                                <label>Pagado:<br>
                                <select  aria-controls="DataTables_Table_0" class=" input-sm form-control" id="selectEstado"   name="selectEstado">
                                
                                    <option value="null" id="button">--</option>
                                    <option value="1" id="button">SI</option>
                                    <option value="0" id="button">NO</option>
                                   
                                </select>
                                </label>     
                            </div>

                            <div style="float: left:" class="search col-md-2">
                                <label>Terminado:<br>
                                <select aria-controls="DataTables_Table_0" class=" input-sm search form-control" id="selectTerminado"  name="selectTerminado">
                                
                                    <option value="null" id="button" >--</option>
                                    <option value="1" id="button" >SI</option>
                                    <option value="0" id="button">NO</option>
                                
                                </label>
                                </select>
                            </div> 
                            <div class="search submit col-md-2 ">
                                <input type="submit" value="Buscar" class="search btn btn-primary btn-flat" style="">
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div class="table-responsive">
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
                        <tr class="{{-- $remision->terminado --}}"  id="{{-- $remision->estado --}}">
                            <td id="tdFechaReimision"> </td>
                            <td id="tdNumeroRemision"></td>
                            <td id="tdClienteNombre"></td>
                            <td id="tdObraNombre"></td>
                            <td class="{{-- $remision->estado --}}"> </td>
                            <td id="tdRemisionTerminado"></td>
                            <td></td>
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
    
    <style type="text/css">
        table.data-table  > thead > tr:nth-child(2)
        {
            display: none;
        }
        .data-table
        {
            width: 100%!important;
        }
    </style>

    <script type="text/javascript">
        $( document ).ready(function() 
        {
            $("#inputCliente").on("keyup",function()
            {
                $("#2").val( $(this).val() ).keyup();

            });

            $("#inputObra").on("keyup",function()
            {
                $("#3").val( $(this).val() ).keyup();
            });

            $("#inputNroRemision").on("keyup",function()
            {
                $("#1").val( $(this).val() ).keyup();
            });

            $("#selectEstado").on("change",function()
            {
                if( $(this).val()==true )
                    var estado='1';
                else if( $(this).val()==false )
                    var estado='0';
                else if( $(this).val()=='null' )
                {
                    var estado='';
                }

                $("#4").val(estado).keyup();
            });

            $("#selectTerminado").on("change",function()
            {
                if( $(this).val()==true )
                    var estado='1';
                else if( $(this).val()==false )
                    var estado='0';
                else if( $(this).val()=='null' )
                {
                    var estado='';
                }

                $("#5").val(estado).keyup();
            });
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
                ajax: '{!! route('admin.remision.remision.indexAjax') !!}',
                columns: 
                [
                    { data: 1, name: 'fecha_remision' },
                    { data: 2, name: 'numero_remision' },
                    { data: 6, name: 'clientes__clientes.nombre' },
                    { data: 5, name: 'obras__obras.nombre' },
                    { data: 3, name: 'estado' },
                    { data: 4, name: 'terminado' },
                    { data: 7, name: 'acciones', orderable: false, searchable: false} 
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
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();

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


            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.remision.remision.create') ?>" }]});
        });
    </script>
@stop
