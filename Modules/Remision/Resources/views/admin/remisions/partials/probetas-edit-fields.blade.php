<div class="box-body">
    <label for="numero_remision" class="control-label">Obra:  </label><span>&nbsp{{ $obra[0]->nombre }}</span><br>
    <label for="numero_remision" class="control-label">Ubicacion de Obra:  </label><span>&nbsp{{ $obra[0]->ubicacion }}</span><br>
    <label for="numero_remision" class="control-label">Area de Obra(cm²):  </label><span>&nbsp{{ $obra[0]->area }}</span><br>
    <label for="numero_remision" class="control-label">Cliente:  </label><span>&nbsp{{ $cliente[0]->nombre }}</span><br>
    <label for="numero_remision" class="control-label">Nº de Remision:  </label><span>&nbsp{{ $remision[0]->numero_remision }}</span><br>  
    <label for="numero_remision" class="control-label">Numero de Probeta:  </label><span>&nbsp{{ $detalle->numero_probeta }}</span><br>
    <label for="numero_remision" class="control-label">Fecha de Moldeo:  </label><span>&nbsp{{ $detalle->fecha_moldeo }}</span><br>
    <label for="numero_remision" class="control-label">Dias: </label><span>&nbsp{{ $detalle->dias }}</span><br>
    <label for="numero_remision" class="control-label">Fecha de Rotura:  </label><span>&nbsp{{ $detalle->fecha_rotura }}</span><br>
    <label for="numero_remision" class="control-label">FCK(kg/cm²): </label><span>&nbsp{{ $detalle->fck }}</span><br>
    <label for="numero_remision" class="control-label">Observacion 1:  </label><span>&nbsp{{ $detalle->obs1 }}</span><br>
    <label for="numero_remision" class="control-label">Observacion 2:  </label><span>&nbsp{{ $detalle->obs2 }}</span><br>
    <label for="numero_remision" class="control-label">Pieza Estructural:  </label><span>&nbsp{{ $detalle->pieza_estructural }}</span><br>
    <input type="hidden" name="detalle_id" value="{{old('detalle_id') ? old('detalle_id') : $detalle->id}}">
    <input type="hidden" name="remision_id" value="{{old('remision_id') ? old('remision_id') : $detalle->remision_id}}"><br>

    <div class="form-group {!! $errors->first('carga_aplicada',  'has-error') !!}">
        <label for="numero_remision" class="control-label">Carga aplicada(kg)</label>
        <input type="text" name="carga_aplicada" value="{{old('carga_aplicada') ? old('resistencia') : $detalle->resistencia }}" class="form-control" id="carga_aplicada" onkeyup="calcular()">
        {!! $errors->first('carga_aplicada', '<p>:message</p>') !!}
    </div>


    <div class="form-group {!! $errors->first('area',  'has-error') !!}">
        <label for="numero_remision" class="control-label">Area(cm²)</label>
        <input type="text" name="area" value="{{old('area') ? old('area') : $detalle->area }}" class="form-control" id="area" onkeyup="calcular()">
        {!! $errors->first('area', '<p>:message</p>') !!}
    </div>



    <div class="form-group {!! $errors->first('resistencia',  'has-error') !!}">
        <label for="fecha" class="control-label">Resistencia</label>
        <input type='text' name="resistencia" value="{{old('resistencia') ? old('resistencia') : $detalle->resistencia }}" class="form-control" id='resistencia2' disabled/>
        {!! $errors->first('resistencia', '<p>:message</p>') !!}
    </div>

    <div class="form-group {!! $errors->first('porcentaje',  'has-error') !!}">
        <label for="porcentaje" class="control-label">Porcentaje</label>
        <input type='text' name="porcentaje" value="{{old('porcentaje') ? old('porcentaje') : $detalle->porcentaje }}" class="form-control" id='porcentaje2' disabled/>
        {!! $errors->first('porcentaje', '<p>:message</p>') !!}
    </div>

    <div style="display: none;" class="form-group {!! $errors->first('resistencia',  'has-error') !!}" >
        <label for="fecha" class="control-label">Resistencia</label>
        <input  name="resistencia" value="{{old('resistencia')}}" class="form-control" id='resistencia' />
        {!! $errors->first('resistencia', '<p>:message</p>') !!}
    </div>

    <div style="display: none;" type='hidden' class="form-group {!! $errors->first('porcentaje',  'has-error') !!}" type="hidden">
        <label for="porcentaje" class="control-label">Porcentaje</label>
        <input  name="porcentaje" value="{{old('porcentaje')}}" class="form-control" id='porcentaje' />
        {!! $errors->first('porcentaje', '<p>:message</p>') !!}
    </div>
    <!--
    <div class="form-group" style="hidden" ">
        <a href="#" id="calcular" class="btn btn-small btn-success">Calcular</a>
    </div>
    -->
</div>
<script type="text/javascript">
    function calcular(e) 
    { 
        
        //e.preventDefault();
        var fck = '{{$fck}}';
        var carga_aplicada = $('#carga_aplicada').val();
        var area_obra = $('#area').val();
        //alert(carga_aplicada);
        console.log(carga_aplicada);
        var resistencia = carga_aplicada / area_obra;
        var porcentaje = (resistencia/fck)*100;

        $('#resistencia').val(resistencia);
        $('#porcentaje').val(porcentaje);
        $('#resistencia2').val(resistencia);
        $('#porcentaje2').val(porcentaje);

        if( $("#area").val()=='0' || $("#area").val()=='' )
        {

            $("#submit").hide();
        }
        else
        {

            $("#submit").show();
        }

    };

        ;
    


</script>