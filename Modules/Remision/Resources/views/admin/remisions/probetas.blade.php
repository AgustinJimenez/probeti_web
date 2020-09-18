@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Probetas del Dia') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('remision::remisions.title.remisions') }}</li>
    </ol>
@stop

@section('styles')
        {!! Theme::style('css/buttons.dataTables.min.css') !!}
        {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
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
        .dt-button.buttons-pdf.buttons-html5
        {
            background-image: none;
            background-color: #d73925;
            color: white;

        }
        .dt-button.buttons-pdf.buttons-html5:hover
        {
            background-image: none;
            background-color: #dd4b39;
            color: white;

        }
        .btn.btn-default.btn-flat
        {
            display: none;
        }
        .dt-buttons
        {
            margin-right: 3px;
            margin-bottom: 5px;
        }

        #carga
        {
            font-size: 0.88em;
        }

        form
        {
            display: inline;
        }

        .sorting_1 
        { 
            font-weight: bold;
        }
        

        </style>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    {!! Form::open(array('route' => ['admin.remision.remision.probeta.probetaVerDetalle'],'method' => 'get')) !!}
                    <div class="form-group">
                        <label for="numero_remision" class="control-label" >Fecha</label>
                        <input type="text" onkeyup="" onchange="" class="form-control input-sm" name="fecha_buscar" id="fecha_buscar" value={{ $now }} style="width:9%;display: inline;">   
                        <input type="submit" value="Ver Remisiones y Generar Informes" class="search btn " style=" margin-left: 2%;display: inline; background-color:#dd4b39 ;color: white;">
                    {!! Form::close() !!}
                        <div style="display: inline;">
                             
                            <div style="display: none;">
                                <a href="#" id="buscar" class="btn btn-default" style="margin-left: 3.5%;">Buscar Fecha</a>
                            </div>
                        </div>
                    </div>
            
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(array('route' => ['admin.remision.remision.probeta.probetaEditarAll'],'method' => 'get')) !!}
                            <input type="text" onkeyup="buscarFecha()" class="form-control input-sm" name="fecha_buscar" id="fecha_buscar2" value={{ $now }} style="width:9%;display: none;" >
                            <div class="dt-buttons">
                                <input type="submit" value="Cargar Resultados" class="search btn btn-primary btn-flat" style="  " id="carga">
                            

                            </div>
                            {!! Form::close() !!} 
                <div class="tabla" id="tabla">
                    <table class="data-table table table-bordered table-hover probetaTabla">

                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Numero Probeta') }}</th>
                            <th>{{ trans('Fecha de moldeo') }}</th>
                            <th>{{ trans('Edad(dias)') }}</th>
                            <th>{{ trans('Fecha de Rotura') }}</th>
                            <th>{{ trans('Pieza Estructural') }}</th>
                            <th>{{ trans('Carga de Rotura(kN)') }}</th>
                            <th>{{ trans('Carga de Rotura(kg)') }}</th>
                            <th>{{ trans('Resistencia(kg/cm²)') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($remision_detalles)): ?>
                        <?php foreach ($remision_detalles as $detalle): ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Numero Probeta') }}</th>
                            <th>{{ trans('Fecha de moldeo') }}</th>
                            <th>{{ trans('Edad(dias)') }}</th>
                            <th>{{ trans('Fecha de Rotura') }}</th>
                            <th>{{ trans('Pieza Estructural') }}</th>
                            <th>{{ trans('Carga de Rotura(kN)') }}</th>
                            <th>{{ trans('Carga de Rotura(kg)') }}</th>
                            <th>{{ trans('Resistencia(kg/cm²)') }}</th>
                            
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
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
    {{--<script type="text/javascript" src="{{asset('js/buttons.flash.min.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/buttons.print.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/buttons.flash.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/pdfmake.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/vfs_fonts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jszip.min.js')}}"></script>
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

    <script type="text/javascript">
        $( document ).ready(function() 
        {
            fecha='{{ $now }}';
            var telefono='021 326 2929';
            var mail='contacto@probeti.com.py';
            var direccion='Benito Juarez 550 casi Boqueron - Luque';
            //alert(fecha);
            //$("#fecha_buscar").val(fecha);
            document.getElementById("fecha_buscar").value = fecha;


            $("#fecha_buscar").change(function()
            {
                //console.log($('#fecha_buscar').val());
            });

            $("#fecha_buscar").on("dp.change", function (e) 
            {
                $("#buscar").click();
            });
            $('#fecha_buscar').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'es'
            });



         /*   $('#tabla').on( 'draw.dt', function () 
            {
                count=1;
                $(".sorting_1").each(function() 
                {
                    console.log('NROVAL IS: '+$(this).text(count)+'count is: '+count );
                    count+=1;
                    if($(this).text()=='[object Object]')
                    {
                        
                        console.log('NROVAL IS: '+$(this).text(count)+'count is: '+count );
                    }
                });
            });
            */


        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () 
        {


            $('.data-table').DataTable(
            {
                dom: 'Bfrtip',
                buttons: [
                    {
                        title:'Probeti SRL',
                        extend: 'excelHtml5',
                        text: 'Exportar a Excel',
                        message: 'fecha del dia',
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5,6,7,8]
                        },
                        
                        customize: function (xlsx) 
                        {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var numrows = 6;
                            var clR = $('row', sheet);

                            //update Row
                            clR.each(function () {
                                var attr = $(this).attr('r');
                                var ind = parseInt(attr);
                                ind = ind + numrows;
                                $(this).attr("r",ind);
                            });

                            // Create row before data
                            $('row c ', sheet).each(function () 
                            {
                                var attr = $(this).attr('r');
                                var pre = attr.substring(0, 1);
                                var ind = parseInt(attr.substring(1, attr.length));
                                ind = ind + numrows;
                                $(this).attr("r", pre + ind);
                            });

                            function Addrow(index,data) {
                                msg='<row r="'+index+'">'
                                for(i=0;i<data.length;i++)
                                {
                                    var key=data[i].key;
                                    var value=data[i].value;
                                    msg += '<c t="inlineStr" r="' + key + index + '">';
                                    msg += '<is>';
                                    msg +=  '<t>'+value+'</t>';
                                    msg+=  '</is>';
                                    msg+='</c>';
                                }
                                msg += '</row>';
                                return msg;
                            }
                            var telefono='021 326 2929';
                            var mail='contacto@probeti.com.py';
                            var direccion='Benito Juarez 550 casi Boqueron - Luque';

                            //insert
                            var r1 = Addrow(1, [{ key: 'A', value: 'Probeti SRL' }, { key: 'B', value: '' }]);
                            var r2 = Addrow(2, [{ key: 'A', value: 'Fecha' }, { key: 'B', value: fecha }]);
                            var r3 = Addrow(3, [{ key: 'A', value: 'Teléfono' }, { key: 'B', value: telefono }]);
                            var r4 = Addrow(4, [{ key: 'A', value: 'Mail' }, { key: 'B', value: mail }]);
                            var r5 = Addrow(5, [{ key: 'A', value: 'Direccion' }, { key: 'B', value: direccion }]);
                            sheet.childNodes[0].childNodes[1].innerHTML = r1+r2+r3+r4+r5+ sheet.childNodes[0].childNodes[1].innerHTML;
                        }
                    },
                    { 
                        extend: 'pdfHtml5', 
                        text: 'Exportar a PDF', 
                        title:'Probeti SRL', 
                        message: 'Fecha: '+fecha+'\nTeléfono: 021 326 2929\nMail: contacto@probeti.com.py\nDireccion: Benito Juarez 550 casi Boqueron - Luque\n', 
                        exportOptions: { 
                            columns: [ 0,1,2,3,4,5,6,7,8 ] 
                        }, 
                        customize:function(doc)  
                        { 
                            doc['header']= false, 
                            doc['title']= 'Probeti SRL', 
                            doc['footer']= { 
                                columns: [ 
                                    /*'Left part'*/'', 
                                    { text: /*'Right part'*/'', alignment: 'right' } 
                                ] 
                            } 
                        } 
                    },
 

                    ],


                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                columns: [
                    { "data": "nro"},
                    { "data": "numero_probeta"},
                    { "data": "fecha_moldeo" },
                    { "data": "dias" },
                    { "data": "fecha_rotura" },
                    { "data": "pieza_estructural" },
                    { "data": "carga_aplicada_format" },
                    { "data": "carga_aplicada_kg" },
                    { "data": "resistencia_format" },
                    { "data": "acciones" },
                ],
                "language": {
                    "url": '{{ Module::asset("core:js/vendor/datatables/{$locale}.json") }}'
                }
            });
        });









        $("#buscar").on("click", function (event) 
        {
            $('#fecha_buscar2').val($('#fecha_buscar').val());
            event.preventDefault();
            var buscar = $('#fecha_buscar').val();
            //console.log(buscar);
            $.ajax({
                url: "{{ route('admin.remision.remision.probeta.search') }}",
                type: "post",
                data: {fecha: buscar}
            }).done(function (result) {
                //console.dir(result);
                $('.data-table').DataTable().clear().draw();
                $('.data-table').DataTable().rows.add(result).draw();
            }).fail(function (jqXHR, textStatus, errorThrown) {
                //console.log('error');
            });
        });
    </script>
    <script>
        $(function () 
        {
            

        });
    </script>
@stop
