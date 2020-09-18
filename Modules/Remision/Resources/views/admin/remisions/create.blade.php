@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Crear Remision') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.remision.remision.index') }}">{{ trans('remision::remisions.title.remisions') }}</a></li>
        <li class="active">{{ trans('remision::remisions.title.create remision') }}</li>
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
    {!! Form::open(['route' => ['admin.remision.remision.store'], 'method' => 'post', 'class' => 'form-horizontal']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('remision::admin.remisions.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach
                    <?php if(!isset($key))$key=0; ?>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
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
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}.
    {!! Theme::script('js/jquery.maskedinput.min.js') !!}
    <script src="{{ asset('js/jquery.number.min.js') }}"></script>
    <script type="text/javascript">
        $( document ).ready(function() 
        {
            $(".diametro").val( obra_selected_diametro() );
            var x = 0;
            instace_diametro_altura_peso(x);
            $(window).keydown(function(event)
                {
                    if(event.keyCode == 13) {
                      event.preventDefault();
                      $("#agregar").click();
                      
                      return false;
                    }
                });
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck(
            {
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            @if(old('numero_probeta'))
                @foreach(old('numero_probeta') as $key => $val)
                    x='{{ $key }}';
                    $('#detalles_div').on("click",".remove_field_old"+x, function(e)
                    { //user click on remove text
                        e.preventDefault();
                        $(this).parent().parent('tr').remove();
                        x--;
                        if(x<0)
                        {
                            x=0;
                            
                        }
                        $("#fecha_moldeo_old"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
                        $("#fecha_rotura_old"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});

                        count=0;
                        $(".nro").each(function() 
                        {
                            count+=1;
                            //console.log('NROVAL IS: '+$(this).text(count) );
                        });

                        //console.log('x is: '+x);
                    })
                    $("#fecha_moldeo_old"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
                    $("#fecha_rotura_old"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
                @endforeach
            @endif
         

            //console.log('x ready: '+x);
            $("#fecha_moldeo"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
            $("#fecha_rotura"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});

            $('#agregar').click(function (e) 
            {

                e.preventDefault();
                x++;

                //console.log('x is: '+x);
                
                    $('#tabla_remision > tbody:last-child').
                    append('<tr>'+
                            '<td class="nro"><strong>'+(x+1)+'</strong></td>'+
                            '<td class="col-sm-1 " ><input type="text" name="numero_probeta[]" id="nprobeta'+x+'" class="form-control input-md" placeholder="Nº de Probeta"  required="required" maxlength="8"/></td>'+
                            '<td class="col-sm-1 " ><input type="text" name="fecha_moldeo[]" class="form-control input-md" id="fecha_moldeo'+x+'" placeholder="dd/mm/aaaa" required="required"/></td>'+
                            '<td class="col-sm-1 " ><input type="text" name="fecha_rotura[]" class="form-control input-md" id="fecha_rotura'+x+'" placeholder="dd/mm/aaaa" required="required"/></td>'+
                            '<td class="col-sm-1 " ><input type="text" name="fck[]" class="form-control input-md fck fck-'+x+'" placeholder="FCK"/></td>'+
                            '<td class="col-sm-1" ><input type="text" name="diametro[]" class="form-control input-md diametro diametro-'+x+'" placeholder="Diametro" required="required" value="'+obra_selected_diametro()+'"/></td>'+
                            '<td class="col-sm-1" ><input type="text" name="altura[]" class="form-control input-md altura altura-'+x+'" placeholder="Altura"/></td>'+
                            '<td class="col-sm-1" ><input type="text" name="peso[]" class="form-control input-md peso peso-'+x+'" placeholder="Peso"/></td>'+
                            '<td class="col-sm-2 "><input type="text" name="pieza_estructural[]" class="form-control" placeholder="Pieza Estructural" id="pieza_estructural"/></td>'+
                            '<td class="col-sm-1 " ><a href="#" class="btn btn-danger remove_field'+x+'">Eliminar</a> </td></tr>');

                    $("#fecha_moldeo"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
                    $("#fecha_rotura"+x).mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
                    instace_diametro_altura_peso(x);
                    document.getElementById("nprobeta"+x).focus();
                    $('.remove_field'+x).on("click", function(e)
                    { //user click on remove text
                        e.preventDefault();
                        $(this).parent().parent('tr').remove();

                        count=0;
                        $(".nro").each(function() 
                        {
                            count+=1;
                            //console.log('NROVAL IS: '+$(this).text(count) );
                        });

                        //console.log('x es en la funcion: '+x);
                    });

                
                
                if(x<0)
                {
                    x=0;
                    //console.log('x fixed to: '+x);
                }
                count=0;
                $(".nro").each(function() 
                {
                    count+=1;
                    //console.log('NROVAL IS: '+$(this).text(count) );
                });


            })
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
        $(function () 
        {
            $('#fecha_remision').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                locale: 'es'
            });
        });
    </script>
@stop
