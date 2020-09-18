@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Editar Remision') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.remision.remision.index') }}">{{ trans('remision::remisions.title.remisions') }}</a></li>
        <li class="active">{{ trans('remision::remisions.title.edit remision') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}  

    <style type="text/css">
        .nro 
        { 
            font-weight: bold;
            width: 2%;
        }
    </style>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.remision.remision.update', $remision->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('remision::admin.remisions.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.remision.remision.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
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
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
    {!! Theme::script('js/jquery.maskedinput.min.js') !!}
    <script src="{{ asset('js/jquery.number.min.js') }}"></script>
    <script type="text/javascript">
        $( document ).ready(function() { });
        var x = '{{$x}}';
        instace_diametro_altura_peso(x);
        for(var i = 0; i <= x;i++)
        {
            
        }

        $('#detalles_div').on("click",".remove_field", function(e)
        { //user click on remove text
            e.preventDefault();
            var id = $(this).parent().parent().find("input[class=eliminar]").attr('id');
            $('#'+id).val('1');
            $(this).closest("tr").hide();
            console.log(id);
            //x--;
            
            count=0;
            $(".nro").each(function() 
            {
                count+=1;
                console.log('NROVAL IS: '+$(this).text(count) );
            });
        })

        $('#agregar').click(function (e) 
        {
            e.preventDefault();
            x++;
            
                $('#tabla_remision > tbody:last-child').
                append('<tr>'+
                        '<td class="nro"><strong>'+(x+1)+'</strong></td><td class="col-sm-1 maxwidth" ><input type="text" name="numero_probeta[]" class="form-control input-md" required="required"  maxlength="8"/></td>'+
                        '<td class="col-sm-1 " ><input type="text" name="fecha_moldeo[]" class="form-control input-md" placeholder="dd/mm/aaaa" required="required" id="fecha_moldeo_'+ x +'" required="required"/></td>'+
                        '<td class="col-sm-1 " ><input type="text" name="fecha_rotura[]" class="form-control input-md" placeholder="dd/mm/aaaa" id="fecha_rotura_'+ x +'" required="required"/></td>'+
                        '<td class="col-sm-1 " ><input type="text" name="fck[]" class="form-control input-md fck fck-'+x+'" /></td>'+
                        '<td class="col-sm-1" ><input type="text" name="diametro[]" class="form-control input-md diametro diametro-'+x+'" placeholder="Diametro" required="required" value="'+obra_selected_diametro()+'"/></td>'+
                            '<td class="col-sm-1" ><input type="text" name="altura[]" class="form-control input-md altura altura-'+x+'" placeholder="Altura"/></td>'+
                            '<td class="col-sm-1" ><input type="text" name="peso[]" class="form-control input-md peso peso-'+x+'" placeholder="Peso"/></td>'+
                        '<td class="col-sm-2 maxwidth" ><input type="text" name="pieza_estructural[]" class="form-control" /></td>'+
                        '<td class="col-sm-1 maxwidth" ><a href="#" class="btn btn-danger remove_field_new">Eliminar</a> </td></tr>');

                

                $('.remove_field_new').on("click", function(e)
                { //user click on remove text
                    e.preventDefault();
                    $(this).parent().parent('tr').remove();
                    x--; 
                    console.log('se quito, x: '+x);

                    count=0;
                    $(".nro").each(function() 
                    {
                        count+=1;
                        console.log('NROVAL IS: '+$(this).text(count) );
                    });
                })

                $("#fecha_moldeo_"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
                $("#fecha_rotura_"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
                instace_diametro_altura_peso(x);

            count=0;
            $(".nro").each(function() 
            {
                count+=1;
                console.log('NROVAL IS: '+$(this).text(count) );
            });
        });
        function obra_selected_diametro()
        {
            return $("select[name=obra_id] option:selected").attr("diametro");
        }
        function instace_diametro_altura_peso(x)
        {
            $('.diametro-'+x).number(true, 3, ',','');
            $('.altura-'+x).number(true, 3, ',','');
            $('.peso-'+x).number(true, 3, ',','');
            $('.fck-'+x).number(true, 3, ',','');
        }
    </script>

    <script>
        $( document ).ready(function() 
        {

            @if(old('numero_probeta'))
                @foreach(old('numero_probeta') as $key => $val)

                    x='{{ $key }}';

                    @if(old('detalle_id.'.$key))

                        $('.remove_field_new'+x).on("click", function(e)
                        { //user click on remove text
                            e.preventDefault();
                            var id = $(this).parent().parent().find("input[class=eliminar]").val('1');
                            //$('#'+id).val('1');
                            $(this).closest("tr").hide();
                            
                            x--;
                            //console.log('se quito if de old, x: '+x);

                            count=0;
                            $(".nro").each(function() 
                            {
                                count+=1;
                                //console.log('NROVAL IS: '+$(this).text(count) );
                            });
                        });

                        $("#fecha_moldeoold"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
                        $("#fecha_roturaold"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
                    @else
                        $('#detalles_div').on("click",".remove_field_old"+x, function(e)
                        { //user click on remove text
                            e.preventDefault();
                            $(this).parent().parent('tr').remove();
                            x--;
                            //console.log('se quito els de old, x: '+x);
                            count=0;
                            $(".nro").each(function() 
                            {
                                count+=1;
                                //console.log('NROVAL IS: '+$(this).text(count) );
                            });
                        });
                        $("#fecha_moldeoold"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
                        $("#fecha_roturaold"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});

                    @endif
                @endforeach
            @endif
            
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck(
            {
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
    <script>
        $(function () {
            $('#fecha_remision').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                locale: 'es'
            });
            for (var x=0;x<'{{count($x)}}';x++)
            {
                instace_diametro_altura_peso(x);
            }

        });
    </script>

@stop
