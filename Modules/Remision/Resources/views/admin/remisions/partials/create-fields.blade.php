
<style type="text/css">
    .timepicker.col-md-6
    {
        display: none;
    }
    .datepicker.col-md-6
    {
        width: 30%;
        margin-left: 5%;
        display: none;

    }




</style>
<fieldset>
@if (count($errors) > 0)
            <div style="overflow:hidden;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">
                <div id="datetimepicker12"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker12').datetimepicker({
                inline: true,
                sideBySide: true
            });

        });
    </script>
    </div>
        <div class="box-body cabecera" >
            <div class="form-group {!! $errors->first('numero_remision',  'has-error') !!} ">
                <label for="numero_remision" class="control-label">Numero de Remision</label>
                <input type="text" value="{{old('numero_remision')}}" name="numero_remision" class="form-control">
                {!! $errors->first('numero_remision', '<p>:message</p>') !!}
            </div>

            <div class="form-group {!! $errors->first('fecha_remision',  'has-error') !!} ">
                <label for="fecha" class="control-label">Fecha Remision</label>
                <input type='text' value="{{old('fecha_remision')}}" name="fecha_remision" class="form-control" id='fecha_remision' placeholder="dd/mm/aaaa" />
                {!! $errors->first('fecha_remision', '<p>:message</p>') !!}
            </div>

            <div class="form-group {!! $errors->first('obra_id',  'has-error') !!} ">
                <label for="numero_probeta" class="control-label">Obra</label>
                <select name="obra_id" class="form-control">
                        @foreach($obras as $obra)
                            @if(old('obra_id') == $obra->id)
                                <option value="{{$obra->id}}" selected>{{$obra->nombre}}</option>
                            @else
                                <option value="{{$obra->id}}">{{$obra->nombre}}</option>
                            @endif
                        @endforeach
                </select>
                    {!! $errors->first('obra_id', '<p>:message</p>') !!}
            </div>
        </div>

        {{-- Para el formulario de Remision detalle --}}

        <div id="detalles_div">

            <div class="box-body detalle">

                <div class="table-responsive">
                    <table id="tabla_remision" class="table table-bordered table-striped table-highlight table-fixed" >
                        <thead>
                        <tr>
                             <th>#</th>
                             <th class="col-sm-2 maxwidth" >Nº de Probeta</th>
                             <th class="col-sm-2 maxwidth" >Fecha Moldeo</th>
                             <th class="col-sm-2 maxwidth" >Fecha de Rotura</th>
                             <th class="col-sm-2 maxwidth" >FCK Teorico(kg/cm²)</th>
                             <th class="col-sm-2 maxwidth" >Pieza Estructural</th>
                             <th class="col-sm-2 maxwidth" >Eliminar</th>
                        </tr>
                        </thead>
                        <tbody id="remision_detalles">
                        @foreach(old('numero_probeta') as $key => $val)
                        <tr >
                            <td class="nro"><strong> {{$key+1}} </strong></td>
                            <td class="col-sm-2 {!! $errors->first('numero_probeta.'.$key, 'has-error') !!} maxwidth" >
                                <input type="text" value="{{old('numero_probeta.'.$key)}}" name="numero_probeta[]" class="form-control input-md" placeholder="Nº de Probeta"/>
                                <div style="position: relative; display: none; width: 100%;">
                                    {!! $errors->first('numero_probeta.'.$key, '<p style="font-size: 10px">:message</p>') !!}
                                </div>
                            </td>
                            <td class="col-sm-2  {!! $errors->first('fecha_moldeo.'.$key, 'has-error') !!} maxwidth" >
                                <input type='text' value="{{old('fecha_moldeo.'.$key)}}" name="fecha_moldeo[]" class="form-control input-md " id='fecha_moldeo_old{{$key}}' placeholder="dd/mm/aaaa" />
                                <div style="position: relative;display: none;width: 100%;">
                                    {!! $errors->first('fecha_moldeo.'.$key, '<p style="font-size: 10px">:message</p>') !!}
                                </div>
                            </td>
                            <td class="col-sm-2  {!! $errors->first('fecha_rotura.'.$key, 'has-error') !!} maxwidth" >
                                <input type='text' value="{{old('fecha_rotura.'.$key)}}" name="fecha_rotura[]" class="form-control input-md " id='fecha_rotura_old{{$key}}' placeholder="dd/mm/aaaa" />
                                <div style="position: relative;display: none;width: 100%;">
                                    {!! $errors->first('fecha_rotura.'.$key, '<p style="font-size: 10px">:message</p>') !!}
                                </div>
                            </td>
                            <td class="col-sm-2 {!! $errors->first('fck.'.$key, 'has-error') !!} maxwidth" >
                                <input type='text' value="{{old('fck.'.$key)}}" name="fck[]" class="form-control input-md" placeholder="FCK"/>
                                <div style="position: relative;display: none;width: 100%;">
                                    {!! $errors->first('fck.'.$key, '<p style="font-size: 10px">:message</p>') !!}
                                </div>
                            </td>
                            <td class="col-sm-2 {!! $errors->first('pieza_estructural.'.$key, 'has-error') !!} maxwidth" >
                                <input type='text' value="{{old('pieza_estructural.'.$key)}}" name="pieza_estructural[]" class="form-control input-md" placeholder="Pieza Estructural" id="pieza_estructural"/>
                                <div style="position: relative;display: none;width: 100%;">
                                    {!! $errors->first('pieza_estructural.'.$key, '<p style="font-size: 10px">:message</p>') !!}
                                </div>
                            </td>
                            <td class="col-sm-2 maxwidth" >
                            @if($key>0)
                                <a href="#" class="btn btn-danger remove_field_old{{ $key }}">Eliminar</a>
                            
                            @else
                                <a href="#" class="btn btn-danger remove_field_old">Eliminar</a>
                            
                            @endif

                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <br>
            <div class="form-group" style="margin-left:1%;" >
                <a href="#" id="agregar" class="btn btn-small btn-success">Agregar Detalle</a>
            </div>
        </div>

    @else

    <div style="overflow:hidden;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">
                <div id="datetimepicker12"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker12').datetimepicker({
                inline: true,
                sideBySide: true
            });

        });
    </script>
    </div>

    <div class="box-body cabecera  ">
        <div class="form-group ">
            <label for="numero_remision" class="control-label">Numero de Remision</label>
            <input type="text" name="numero_remision" class="form-control" required="required">
        </div>

        <div class="form-group ">
            <label for="fecha" class="control-label">Fecha Remision</label>
            <input type='text' name="fecha_remision" class="form-control" id='fecha_remision' placeholder="dd/mm/aaaa" required="required" />
        </div>

        <div class="form-group ">
            <label for="numero_probeta" class="control-label">Obra</label>
            <div>
                <select name="obra_id" class="form-control">
                @foreach($obras as $obra)
                    <option value="{{$obra->id}}" diametro="{{ $obra->diametro }}">{{ $obra->nombre }} -Diametro: {{ $obra->diametro }} cm</option>
                @endforeach
                </select>
            </div>
        </div>

    </div>

    {{-- Para el formulario de Remision detalle --}}
    <div id="detalles_div">
        <div class="box-body detalle">
            <div class="table-responsiv">
                <table id="tabla_remision" class="table table-bordered table-striped table-highlight table-fixed" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="col-sm-1 " >Nº de Probeta</th>
                             <th class="col-sm-1 " >Fecha Moldeo</th>
                             <th class="col-sm-1 " >Fecha de Rotura</th>
                             <th class="col-sm-1 " >FCK Teorico(kg/cm²)</th>
                             <th class="col-sm-1 " >Diametro (cm)</th>
                             <th class="col-sm-1 " >Altura (cm)</th>
                             <th class="col-sm-1 " >Peso (Kg)</th>
                             <th class="col-sm-2 " >Pieza Estructural</th>
                             <th class="col-sm-1 " >Eliminar</th>
                        </tr>

                    </thead>
                    <tbody id="remision_detalles">
                    <tr>
                        <td class="nro"><strong>1</strong></td>
                        <td class="col-sm-1 " >
                            <input type="text" name="numero_probeta[]" class="form-control input-md" placeholder="Nº de Probeta" required="required" maxlength="8"/>
                        </td>
                        <td class="col-sm-1 " >
                            <input type='text' name="fecha_moldeo[]" class="form-control input-md" id='fecha_moldeo0' placeholder="dd/mm/aaaa" required="required"/>
                        </td>
                        <td class="col-sm-1 " >
                            <input type='text' name="fecha_rotura[]" class="form-control input-md" id='fecha_rotura0' placeholder="dd/mm/aaaa" required="required"/>
                        </td>
                        <td class="col-sm-1 " >
                            <input type='text' name="fck[]" class="form-control input-md fck fck-0" placeholder="FCK"/>
                        </td>
                        <td class="col-sm-1" >
                            <input type='text' name="diametro[]" class="form-control input-md diametro diametro-0" placeholder="Diametro" required="required"/>
                        </td>
                        <td class="col-sm-1" >
                            <input type='text' name="altura[]" class="form-control input-md altura altura-0" placeholder="Altura"/>
                        </td>
                        <td class="col-sm-1" >
                            <input type='text' name="peso[]" class="form-control input-md peso peso-0" placeholder="Peso"/>
                        </td>
                        <td class="col-sm-2 " >
                            <input type='text' name="pieza_estructural[]" class="form-control input-md" placeholder="Pieza Estructural" id="pieza_estructural"/>
                        </td>
                        <td class="col-sm-1 " >
                            <p  class="btn btn-danger">Eliminar</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="form-group" style="margin-left:1%;" >
                <a href="#" id="agregar" class="btn btn-small btn-success">Agregar Detalle</a>
            </div>
    </div>

    </div>
@endif
</fieldset>