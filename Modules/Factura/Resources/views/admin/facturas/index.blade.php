@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Facturas') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('factura::facturas.title.facturas') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
    {!! Theme::style('css/buttons.dataTables.min.css') !!}
    <style type="text/css">
        .dt-button.buttons-excel.buttons-html5
        {
            background-image: none;
            background-color: #008d4c;
            color:white;

        }
        .dt-button.buttons-excel.buttons-html5:hover
        {
            background-image: none;
            background-color: #00a65a;
            color:white;

        }
    </style>

@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">

                <div class="col-md-2 col-md-offset-10">
                    <a href="{{ route('admin.factura.factura.create') }}" class="btn btn-primary btn-flat">
                        <i class="fa fa-pencil"></i> {{ trans('Crear Factura') }}
                    </a>
                </div>

            </div>
            <br>
            <div class="box box-primary">
                <div class="box-header">
                {!! Form::open(array('route' => ['admin.factura.factura.index'],'method' => 'post', 'id' => 'search-form')) !!}
                        @include("factura::admin.facturas.partials.index-date-filters")
                        <div class="col-md-2"> 
                            <label >Razon Social:</label>
                            <input type="search" class="form-control input-sm" placeholder="Busca Cliente" aria-controls="DataTables_Table_0" id="razon_social" value="" name="razon_social" >
                        </div>
                        <div class="col-md-2"> 
                        {!! Form::normalSelect('anulado', "Anulado", $errors, [0 => "No", 1 => "Si"], null, ['id' => "anulado"]) !!}
                        </div>
                        <div class="col-md-2"> 
                        {!! Form::normalSelect('cobrado', "Cobrado", $errors, [1 => "Si", 0 => "No"], null, ['id' => "cobrado"]) !!}
                        </div>
                        <input type="submit" value="Filtrar" class="search btn btn-primary btn-flat" id="filtro" style=" margin-left: 2%;display: none;">
                        
                    {!! Form::close() !!}
                    {!! Form::open(array('route' => ['admin.factura.factura.index_excel'],'method' => 'get', 'id' => 'excel-form')) !!}
                        {!! Form::hidden('fecha_inicio_excel') !!}
                        {!! Form::hidden('fecha_fin_excel') !!}
                        {!! Form::hidden('razon_social_excel') !!}
                        {!! Form::hidden('anulado_excel') !!}
                        {!! Form::hidden('cobrado_excel') !!}
                        <div class="col-md-2"> 
                            {!! Form::label('','') !!}
                            <br>
                            {!! Form::submit('Exportar a Excel', array('class' => 'btn btn-flat btn-success')) !!}
                        </div>
                    {!! Form::close() !!}
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover" id="tablaFactura">
                        <thead>
                            <tr>
                                <th>{{ trans('Fecha') }}</th>
                                <th>{{ trans('Razon Social') }}</th>
                                <th>{{ trans('Nro de Factura') }}</th>
                                <th>{{ trans('Cobrado') }}</th>
                                <th>{{ trans('Anulado') }}</th>
                                <th>{{ trans('Monto Total') }}</th>
                                <th data-sortable="false">Acciones</th>
                                <th style="display: none;">{{ trans('Monto Total') }}</th>
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
                            <th>{{ trans('Fecha') }}</th>
                            <th>{{ trans('Razon Social') }}</th>
                            <th>{{ trans('Nro de Factura') }}</th>
                            <th>{{ trans('Cobrado') }}</th>
                            <th>{{ trans('Anulado') }}</th>
                            <th>{{ trans('Monto Total') }}</th>
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
        <dd>{{ trans('factura::facturas.title.create factura') }}</dd>
    </dl>
@stop

@section('scripts')
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

    <script type="text/javascript">
        $(document).ready(function() 
        {
            $("#excel-form").submit(function()
            {
                $("input[name=fecha_inicio_excel]").val( $("#fecha_inicio").val() );
                $("input[name=fecha_fin_excel]").val( $("#fecha_fin").val() );
                $("input[name=razon_social_excel]").val( $("#razon_social").val() );
                $("input[name=anulado_excel]").val( $("#anulado").val() );
                $("input[name=cobrado_excel]").val( $("#cobrado").val() );
            });
            
            $("#anulado").change(function()
            {
                $("#search-form").submit();
            });
            $("#cobrado").change(function()
            {
                $("#search-form").submit();
            });
            $("#razon_social").keyup(function()
            {
                $("#search-form").submit();
            });
            $('#search-form').on('submit', function(e) 
            {
                table.draw();
                e.preventDefault();
            });

            var table = $('.data-table').DataTable(
            {
              dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                "deferRender": true,
                processing: false,
                serverSide: true,
                "order": [[ 0, "desc" ]],
                "paginate": true,
                "lengthChange": true,
                 "iDisplayLength": 25,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "paginate": true,
                ajax: 
                {
                    url: '{!! route('admin.factura.factura.indexAjax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (d) 
                    {
                        d.fecha_inicio = $("#fecha_inicio").val(),
                        d.fecha_fin = $("#fecha_fin").val(),
                        d.razon_social = $("#razon_social").val(),
                        d.anulado = $("#anulado").val(),
                        d.cobrado = $("#cobrado").val()
                    },
                    "dataSrc": function ( json ) 
                    {
                        //$("label[for=saldo_acumulado]").text('Saldo Acumulado hasta el '+json.fecha_inicio);
                        //$("input[name=saldo_acumulado]").val(json.saldo_acumulado);
                        return json.data;
                    } 
                },
                columns: 
                [
                    { data: 'fecha', name: 'fecha' },
                    { data: 'razon_social', name: 'razon_social' },
                    { data: 'nro_factura', name: 'nro_factura' },
                    { data: 'cobrado', name: 'cobrado' },
                    { data: 'anulado', name: 'anulado' },
                    { data: 'monto_total', name: 'monto_total' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false}
                ],
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar",
                    lengthMenu:     "Mostrar _MENU_ Elementos",
                    info:           "Mostrando de _START_ a _END_ registros de un total de _TOTAL_ registros",
                    //infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                    infoFiltered:   ".",
                    infoPostFix:    "",
                    loadingRecords: "Cargando Registros...",
                    zeroRecords:    "No existen registros disponibles",
                    emptyTable:     "No existen registros disponibles",
                    paginate: {
                        first:      "Primera",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Ultima"
                    }
                } 
            });


        });
    </script>
@stop