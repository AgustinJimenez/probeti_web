@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Generar Informe') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('remision::remisions.title.remisions') }}</li>
    </ol>
    
@stop
@section('styles')
        {!! Theme::style('css/buttons.dataTables.min.css') !!}
        {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
        <style>
            .dataTables_length
            {
                float: left;
            }
            .col-md-3
            {
                width: 14%;
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
                    {!! Form::open(array('route' => ['admin.remision.remision.createInforme'],'method' => 'get')) !!}
                    <div class="form-group row col-sm-12">
                        <div class="">
                            <input type="text" class="form-control input-sm" name="remision_id" id="remision_id" value="{{ $remision_id }}" style="width:9%;display: none;">
                            <label for="fecha_inicio" class="control-label" >Fecha Inicio:   </label>
                            
                            <input type="text" class="form-control input-sm" name="fecha_inicio" id="fecha_inicio" value="{{ $fecha_inicio }}" style="width:9%;display: inline;">
                            <label for="fecha_fin" class="control-label" >Fecha Fin: </label>
                            <input type="text"  class="form-control input-sm" name="fecha_fin" id="fecha_fin" value="{{ $fecha_fin }}" style="width:9%;display: inline;"> 

                            <input type="submit" value="Filtrar" id="filtro"  class="search btn btn-primary btn-flat" style=" margin-left: 2%;display: none;">
                            <div style="display: inline; margin-left: 5%;">
                                <label for="fecha" class="control-label" >Fecha en Impresion: </label>
                                <input type="text"  class="form-control input-sm" name="fecha" id="fecha" value="{{ $fecha }}" style="width:9%;display: inline;">
                            </div>
                        </div>
                        
                    {!! Form::close() !!}
                    </div>




                    {!! Form::open(array('route' => ['admin.remision.remision.printInforme'],'method' => 'post', "id" => "formulario")) !!}
                    <div style="width:85%;">
                    <div class="row" >

                        <div class="col-sm-4" style="display: none;">
                            <label for="direccion" class="control-label "   style="display: inline;">Dirección: </label>
                            <input type="text"  class="form-control input-sm " name="direccion" id="direccion" value="Benito Juarez 550 casi Boqueron - Luque" style="display: inline;">
                        </div>

                        <div class="col-sm-4" style="display: none;">
                            <label for="telefono" class="control-label "   style="display: inline;">Telefono: </label>
                            <input type="text"  class="form-control input-sm " name="telefono" id="telefono" value="021 326 2929" style="display: inline;">
                        </div>

                        <div class="col-sm-4" style="display: none;">
                            <label for="email" class="control-label " style="display: inline;">E-mail: </label>
                            <input type="text"  class="form-control input-sm " name="email" id="email" value="contacto@probeti.com.py" style="display: inline;"> 
                        </div>
                        
                    </div>
                    <br>
                    <div class="row">   
                        <div class="col-sm-4" style="display: none;">
                            <label for="ruc" class="control-label " style="display: inline;">Ruc: </label>
                            <input type="text"  class="form-control input-sm " name="ruc" id="ruc" value="" style="display: inline;"> 
                        </div>
                        <div class="col-sm-4" style="display: none;">
                            <label for="timbrado" class="control-label " style="display: inline;">Timbrado: </label>
                            <input type="text"  class="form-control input-sm " name="timbrado" id="timbrado" value="" style="display: inline;"> 
                        </div>

                        <div class="col-sm-4">
                            <label class="">Firma:</label>
                            <select  aria-controls="DataTables_Table_0" class="form-control  " id="firma" style=";display: inline;"  name="firma">
                            
                                <option value=""  id="button" selected>--</option>
                                <option value="Ing. Gabriel Quiñones Ayala" id="button">Ing. Gabriel Quiñones Ayala</option>
                                <option value="Ing. Nestor Viveros Martínez" id="button">Ing. Nestor Viveros Martínez</option>

                            </select>
                        </div>
                    </div>  
                    <div class="row">    
                        

                         
                        <br>
                    </div>    
                        <input type="text" class="form-control input-sm" name="remision_id_hidden" id="remision_id_hidden" value="{{ $remision_id }}" style="width:9%;display: none;">

                        <input type="text" class="form-control input-sm" name="fecha_inicio_hidden" id="fecha_inicio_hidden" value="{{ $fecha_inicio }}" style="width:9%;display: none;">
                        
                        <input type="text"  class="form-control input-sm" name="fecha_fin_hidden" id="fecha_fin_hidden" value="{{ $fecha_fin }}" style="width:9%;display: none;">

                        <input type="text" class="form-control input-sm" name="fecha_hidden" id="fecha_hidden" value="{{ $fecha }}" style="width:9%;display: none;">

                        <input type="submit" value="Generar Informe de Rotura" class="search btn btn-primary btn-flat" route="{{ route('admin.remision.remision.printInforme') }}" id="submit-rotura">

                        <input type="submit" value="Generar Informe de Caracteristicas fisicas" class="search btn btn-primary btn-flat" id="submit-caracteristicas" route="{{ route('admin.remision.remision.get_informe_caracteristicas') }}">
                        
                </div>
                    {!! Form::close() !!}



                <!-- /.box-header -->
                <div class="box-body">

                    <table class="data-table table table-bordered table-hover" id="tablaRemision">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('Nº de Probeta') }}</th>
                                <th>{{ trans('Moldeo') }}</th>
                                <th>{{ trans('Rotura') }}</th>
                                <th>{{ trans('Edad(días)') }}</th>
                                <th>{{ trans('Area (cm²)') }}</th>
                                <th>{{ trans('Fck Teorico (kg/cm²)') }}</th>
                                <th>{{ trans('Tipo de Rotura') }}</th>
                                <th style="display: none;">{{ trans('Carga de Rotura (kN)') }}</th>
                                <th>{{ trans('Carga de Rotura (kg)') }}</th>
                                <th>{{ trans('Porcentaje') }}</th>
                                <th>{{ trans('Resistencia (kg/cm²)') }}</th>
                                <th>{{ trans('Estructura') }}</th>
                                <th>{{ trans('Observación') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php?>
                        <?php if (isset($remision_detalles)): ?>
                        @foreach($remision_detalles as $key=>$remision_detalle)
                        <?php $radio=(str_replace(',','.',$remision_detalle->diametro)/2) ;
                                   $area=3.14*($radio*$radio);
                            ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td class="text-center">{{ $remision_detalle->numero_probeta }}</td>
                            <td>{{ $remision_detalle->fecha_moldeo }}</td>
                            <td>{{ $remision_detalle->fecha_rotura }}</td>
                            <td class="text-center">{{ $remision_detalle->dias }}</td>
                            <?php $area=number_format($area,2,",","."); ?>
                            <td class="text-center" id="area">{{ $area }}</td>
                            <td class="text-center" id="fck">{{ $remision_detalle->wformat('fck') }}</td>
                            <td class="text-center" id="tipo_rotura">{{ $remision_detalle->tipo_rotura }}</td>
                            <td class="text-center" id="carga_aplicada">{{ $remision_detalle->carga_aplicada_kg }}</td>
                            <td class="text-center" id="relacion_fck_resistencia">{{ $remision_detalle->relacion_fck_resistencia }}</td>
                            <td class="text-center" id="resistencia">{{ $remision_detalle->wformat('resistencia') }}</td>
                            <td class="text-center">{{ $remision_detalle->pieza_estructural }}</td>
                            <td class="text-center">{{ $remision_detalle->observacion }}</td>
                        </tr>
                        <?php endforeach; ?>
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Nº de Probeta') }}</th>
                            <th>{{ trans('Moldeo') }}</th>
                            <th>{{ trans('Rotura') }}</th>
                            <th>{{ trans('Edad(días)') }}</th>
                            <th>{{ trans('Area (cm²)') }}</th>
                            <th>{{ trans('Fck Teorico (kg/cm²)') }}</th>
                            <th>{{ trans('Tipo de Rotura') }}</th>
                            <th style="display: none;">{{ trans('Carga de Rotura (kN)') }}</th>
                            <th>{{ trans('Carga de Rotura (kg)') }}</th>
                            <th>{{ trans('Porcentaje') }}</th>
                            <th>{{ trans('Resistencia (kg/cm²)') }}</th>
                            <th>{{ trans('Estructura') }}</th>
                            <th>{{ trans('Observación') }}</th>
                        </tr>
                        </tfoot>
                    </table>

                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal');
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
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
    

    <script type="text/javascript">
        $( document ).ready(function() 
        {
            $('#fecha_inicio').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                locale: 'es'
            });  
            $('#fecha_fin').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                locale: 'es'
            }); 
            $('#fecha').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                locale: 'es'
            }); 
            $("#fecha_inicio").on("dp.change", function (e) 
            {
                $("#filtro").click();
            });
            $("#fecha_fin").on("dp.change", function (e) 
            {
                $("#filtro").click();
            });

            $("#submit-rotura").click(function(event)
            {
                var route = $(this).attr("route");
                $("#formulario").attr("action", route);
            });
            $("#submit-caracteristicas").click(function(event)
            {
                var route = $(this).attr("route");
                $("#formulario").attr("action", route);
            });
        });
    </script>
    <script type="text/javascript">
      
        
        $("#fecha").on("dp.change", function (e) 
        {
            console.log($("#fecha_hidden").val()+"<--"+$("#fecha").val()  );
            $("#fecha_hidden").val($("#fecha").val());
        });


    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () 
        {
            $('.data-table').dataTable(
            {
                "paginate": false,
                "lengthChange": false,
                "filter": false,
                "sort": false,
                "info": false,
                "autoWidth": true,
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": '{{ Module::asset("core:js/vendor/datatables/{$locale}.json") }}'
                }
            });
        });
    </script>
@stop
