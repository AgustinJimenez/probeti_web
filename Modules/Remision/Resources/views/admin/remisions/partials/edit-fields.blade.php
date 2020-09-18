@if (count($errors) > 0)
    <div class="box-body cabecera">
        <div class="form-group">
            <input type="hidden" name="remision_id" value="{{old('remision_id')}}">
            <label for="numero_remision" class="control-label">Numero de Remision</label>
            <div class="{!! $errors->first('numero_remision',  'has-error') !!}">
                <input type="text" value="{{old('numero_remision')}}" name="numero_remision" class="form-control">
                {!! $errors->first('numero_remision', '<p>:message</p>') !!}
            </div>

        </div>

        <div class="form-group">
            <label for="fecha" class="control-label">Fecha Remision</label>
            <div class="{!! $errors->first('fecha_remision',  'has-error') !!}">
                <input type='text' value="{{old('fecha_remision')}}" name="fecha_remision" class="form-control"  id='fecha_remision' />
                {!! $errors->first('fecha_remision', '<p>:message</p>') !!}
            </div>

        </div>

        <div class="form-group">
            <label for="numero_probeta" class="control-label">Obra</label>
            <div class="{!! $errors->first('obra_id',  'has-error') !!}">
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

    </div>

     {{--Para el formulario de Remision detalle--}}

        <div id="detalles_div">
            <div class="box-body detalle">
                <div class="table-responsive">
                    <table id="tabla_remision" class="table table-bordered table-striped table-highlight table-fixed" style="width: 1150px;" >
                        <thead>
                        <tr>
                             <th>#</th>
                             <th class="col-sm-2 maxwidth" >Nº de Probeta</th>
                             <th class="col-sm-2 maxwidth" >Fecha Moldeo</th>
                             <th class="col-sm-2 maxwidth" >Fecha Rotura</th>
                             <th class="col-sm-2 maxwidth" >FCK Teorico(kg/cm²)</th>
                             <th class="col-sm-2 maxwidth" >Pieza Estructural</th>
                             <th class="col-sm-2 maxwidth" >Eliminar</th>
                        </tr>

                        </thead>
                        <tbody id="remision_detalles">
                        @foreach(old('numero_probeta') as $key => $val)

                            <tr>
                                @if(old('detalle_id.'.$key))
                                <input type="hidden" value="{{old('detalle_id.'.$key)}}" name="detalle_id[]">
                                <input type="hidden" class="eliminar" value="{{old('eliminar.'.$key) ? old('eliminar'.$key) : false}}" name="eliminar[]" id="eliminar">
                                @endif
                                <td class="nro"><strong>{{ $key+1 }}</strong></td>
                                <td class="col-sm-2 {!! $errors->first('numero_probeta.'.$key, 'has-error') !!} maxwidth" >
                                    <input type="text" value="{{old('numero_probeta.'.$key)}}" name="numero_probeta[]" class="form-control input-md" placeholder="Nº de Probeta"/>
                                    <div style="position: relative; display: none; width: 100%;">
                                        {!! $errors->first('numero_probeta.'.$key, '<p>:message</p>') !!}
                                    </div>
                                </td>
                                <td class="col-sm-2 {!! $errors->first('fecha_moldeo.'.$key, 'has-error') !!} maxwidth" >
                                    <input type='text' value="{{old('fecha_moldeo.'.$key)}}" name="fecha_moldeo[]" class="form-control input-md" id='fecha_moldeoold{{$key}}' placeholder="dd/mm/aaaa"/>
                                    <div style="position: relative; display: none; width: 100%;">
                                        {!! $errors->first('fecha_moldeo.'.$key, '<p>:message</p>') !!}
                                    </div>
                                </td>
                                <td class="col-sm-2 {!! $errors->first('fecha_rotura.'.$key, 'has-error') !!} maxwidth" >
                                    <input type='text' value="{{old('fecha_rotura.'.$key)}}" name="fecha_rotura[]" class="form-control input-md" id='fecha_roturaold{{$key}}' placeholder="dd/mm/aaaa"/>
                                    <div style="position: relative; display: none; width: 100%;">
                                        {!! $errors->first('fecha_rotura.'.$key, '<p>:message</p>') !!}
                                    </div>
                                </td>
                                <td class="col-sm-2 {!! $errors->first('fck.'.$key, 'has-error') !!} maxwidth" >
                                    <input type='text' value="{{old('fck.'.$key)}}" name="fck[]" class="form-control input-md" placeholder="FCK"/>
                                    <div style="position: relative; display: none; width: 100%;">
                                        {!! $errors->first('fck.'.$key, '<p>:message</p>') !!}
                                    </div>
                                </td>
                                <td class="col-sm-2 {!! $errors->first('pieza_estructural.'.$key, 'has-error') !!} maxwidth" >
                                    <input type='text' value="{{old('pieza_estructural.'.$key)}}" name="pieza_estructural[]" class="form-control" placeholder="Pieza Estructural"/>
                                    <div style="position: relative; display: none; width: 100%;">    
                                        {!! $errors->first('pieza_estructural.'.$key, '<p>:message</p>') !!}
                                    </div>
                                </td>

                                <td class="col-sm-2 maxwidth">
                                @if(old('detalle_id.'.$key))
                                    <a href="#" class="btn btn-danger remove_field_new{{ $key }}">Eliminar</a>
                                @else
                                    <a href="#" class="btn btn-danger remove_field_old{{ $key }}">Eliminar</a>
                                @endif    
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
                <br>
            <div class="form-group" style="margin-left:1%;" >
                <a href="#" id="agregar" class="btn btn-small btn-success">Agregar Detalle</a>
            </div>
            </div>

        </div>


@elseif(isset($remision))

    <fieldset>
    <div class="box-body cabecera">
        <input type="hidden" name="remision_id" value="{{$remision->id}}">
        <div class="form-group">
            <label for="numero_remision" class="control-label">Numero de Remision</label>
            <div>
                <input type="text" value="{{$remision->numero_remision}}" name="numero_remision" class="form-control" required="required">
            </div>
        </div>

        <div class="form-group">
            <label for="fecha" class="control-label">Fecha Remision</label>
            <input type='text' value="{{$remision->fecha_remision }}" name="fecha_remision" class="form-control" id='fecha_remision' required="required"/>

        </div>

        <div class="form-group">
            <label for="numero_probeta" class="control-label">Obra</label>
            <div>
                <select name="obra_id" class="form-control">
                    @foreach($obras as $obra)
                        @if($remision->obra_id == $obra->id)
                            <option value="{{$obra->id}}" diametro="{{ $obra->diametro }}" selected>{{$obra->nombre}} -Diametro: {{ $obra->diametro }}</option>
                        @else
                            <option value="{{$obra->id}}" diametro="{{ $obra->diametro }}">{{$obra->nombre}} -Diametro: {{ $obra->diametro }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
     {{--Para el formulario de Remision detalle--}}
    <div id="detalles_div">
        <div class="box-body detalle">
            <div class="table-responsive">
                <table id="tabla_remision" class="table table-bordered table-striped table-highlight table-fixed" >
                    <thead>
                    <tr>
                         <th>#</th>
                         <th class="col-sm-1" >Nº de Probeta</th>
                         <th class="col-sm-1" >Fecha Moldeo</th>
                         <th class="col-sm-1" >Fecha Rotura</th>
                         <th class="col-sm-1" >Fck Teorico (kg/cm²)</th>
                         <th class="col-sm-1 " >Diametro (cm)</th>
                         <th class="col-sm-1 " >Altura (cm)</th>
                         <th class="col-sm-1 " >Peso (Kg)</th>
                         <th class="col-sm-2" >Pieza Estructural</th>
                         <th class="col-sm-1" >Eliminar</th>
                    </tr>

                    </thead>
                    <tbody id="remision_detalles">
                    @foreach($remision_detalles as $key => $detalle)
                        <tr>
                            <input type="hidden" value="{{$detalle->id}}" name="detalle_id[]">
                            <input type="hidden" class="eliminar" value="0" name="eliminar[]" id="eliminar{{$detalle->id}}">
                            <td class="nro"><strong>{{$key+1}}</strong></td>
                            <td class="col-sm-1" >
                                <input type="text" value="{{$detalle->numero_probeta}}" name="numero_probeta[]" class="form-control input-md" required="required"  maxlength="8"/>
                            </td>
                            <td class="col-sm-1" >
                                <input type='text' value="{{$detalle->fecha_moldeo}}" name="fecha_moldeo[]" class="form-control input-md" id='fecha_moldeo_{{$key}}' required="required"/>
                            </td>
                            <td class="col-sm-1" >
                                <input type='text' value="{{$detalle->fecha_rotura}}" name="fecha_rotura[]" class="form-control input-md" id='fecha_rotura_{{$key}}' required="required"/>
                            </td>
                            <td class="col-sm-1" >
                                <input type='text' value="{{ $detalle->wformat('fck', 3, '') }}" name="fck[]" class="form-control input-md fck fck-0" />
                            </td>
                            <td class="col-sm-1" >
                                <input type='text' value="{{ $detalle->wformat('diametro', 3, '') }}" name="diametro[]" class="form-control input-md diametro diametro-0" placeholder="Diametro" required="required"/>
                            </td>
                                <td class="col-sm-1" >
                                    <input type='text' value="{{ $detalle->wformat('altura', 3, '') }}" name="altura[]" class="form-control input-md altura altura-0" placeholder="Altura"/>
                                </td>
                                <td class="col-sm-1" >
                                    <input type='text' value="{{ $detalle->wformat('peso', 3, '') }}" name="peso[]" class="form-control input-md peso peso-0" placeholder="Peso"/>
                                </td>
                            <td class="col-sm-2" >
                                <input type='text' value="{{$detalle->pieza_estructural}}" name="pieza_estructural[]" class="form-control" />
                            </td>
                            <td class="col-sm-1" >
                                <p href="#" class="btn btn-danger remove_field" >Eliminar</p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <br>
            <div class="form-group" style="margin-left:1%;" >
                <a href="#" id="agregar" class="btn btn-small btn-success">Agregar Detalle</a>
            </div>
        </div>
    </div>
    </fieldset>
@endif