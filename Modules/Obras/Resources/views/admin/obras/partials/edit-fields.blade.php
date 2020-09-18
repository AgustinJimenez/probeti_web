<div class="box-body">
    {!! Form::normalInput('nombre', 'Nombre', $errors, $obras) !!}
    {!! Form::normalInput('ubicacion', 'Ubicacion', $errors, $obras) !!}
    {!! Form::normalInput('residente', 'Residente', $errors, $obras) !!}
    {!! Form::normalInput('diametro', 'Diametro (cm)', $errors, $obras) !!}
    {!! Form::normalInput('etiqueta', 'Etiqueta', $errors, $obras) !!}
    {!! Form::normalInput('observacion','Observacion', $errors, $obras) !!}
    {!! Form::normalCheckbox('activo', 'Activo', $errors, $obras) !!}
    {!! Form::normalSelect('cliente_id', 'Cliente', $errors, $clientes, $obras) !!}

    <!--YOUR SELECT-->
</div>


<!--
<div class="form-group">
        <label for="fecha">Cliente</label>
        <select name="cliente_id">
            foreach($clientes as $cliente)
                if($cliente->id == $obras->cliente_id)
                    <option value="{{--$cliente->id--}}" selected> {{-- $cliente->nombre --}}</option>
                else
                    <option value="{{--$cliente->id--}}"> {{--$cliente->nombre--}}</option>
                endif
            endforeach
        </select>
    </div>
-->






