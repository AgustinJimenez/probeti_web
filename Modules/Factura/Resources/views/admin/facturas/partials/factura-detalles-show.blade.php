<?php
    $tamcol1 = 5; $tamcol2 = 1; $tamcol3 = 1; $tamcol4 = 1; $tamcol5 = 1; $tamcol6 = 1; $tamcol7 = 1; 
?>
<table id="tabla_factura" class="table table-bordered table-striped table-highlight table-fixed">
    <thead>
        <tr>
            <th class="col-sm-<?=$tamcol1;?> head btn-primary">Remisiones</th>
            <th class="col-sm-<?=$tamcol2;?> head btn-primary">Tipo de Probetas</th>
            <th class="col-sm-<?=$tamcol3;?> head btn-primary">Cantidad</th>
            <th class="col-sm-<?=$tamcol4;?> head btn-primary">IVA</th>
            <th class="col-sm-<?=$tamcol5;?> head btn-primary">Precio Unitario</th>
            <th class="col-sm-<?=$tamcol6;?> head btn-primary">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detalles as $key => $detalle)
            <tr class="fila fila-{{ $key }}" fila-id="{{ $key }}">
                <td class="col-sm-<?=$tamcol1;?> {!! $errors->first('detalles['.$key.'][id]',  'has-error') !!}">
                    {!! Form::text('detalles['.$key.'][descripcion]', old('detalles['.$key.'][descripcion]',$detalle->descripcion), array('class' => 'form-control input-md remision_nombre remision_nombre-'.$key, 'disabled' => 'disabled')) !!}
                    @if($detalle->id)
                        {!! Form::$DEBUG('detalles['.$key.'][id]', old('detalles['.$key.'][id]',$detalle->id) , ['style' => 'width:30px; margin-top:-65px !important; background-color:LawnGreen ;', "readonly" => "readonly", "class" => "detalle_id", 'disabled' => 'disabled']) !!}
                        {!! Form::$DEBUG('detalles['.$key.'][eliminar]', old('detalles['.$key.'][eliminar]', 0) , ['style' => 'width:30px; margin-top:-65px; background-color:pink; !important;', "readonly" => "readonly", "class" => "eliminar_detalle eliminar_detalle-".$key, 'disabled' => 'disabled']) !!}
                    @endif
                    {!! Form::$DEBUG('detalles['.$key.'][remision_id]', old('detalles['.$key.'][remision_id]',$detalle->remision_id), ['style' => 'width:30px;background-color:DeepSkyBlue ;',"tabIndex" => "-1", "readonly" => "readonly", "class" => "remision_id remision_id-".$key, "cantidad-probetas-chicas" => "", "cantidad-probetas-grandes" => isset($detalle->remision)?$detalle->remision->cantidades_tipos_probetas()->grandes:'0', "cantidad-probetas-medianas" => isset($detalle->remision)?$detalle->remision->cantidades_tipos_probetas()->medianas:"0", "cantidad-probetas-chicas" => isset($detalle->remision)?$detalle->remision->cantidades_tipos_probetas()->chicas:"0", 'disabled' => 'disabled']) !!}
                    
                    {!! $errors->first('detalles['.$key.'][id]', '<p class="error">:message</p>') !!}
                </td>
                <td class="col-sm-<?=$tamcol2;?>">
                    @if($detalle->probeta_tipo)
                        {!! Form::select('detalles['.$key.'][probeta_tipo]', ['chica' => 'Chica', 'mediana' => 'Mediana', "grande" => "Grande"], old('detalles['.$key.'][probeta_tipo]', $detalle->probeta_tipo), ['class' => 'form-control tipo_probeta tipo_probeta-'.$key, 'disabled' => 'disabled']) !!}
                    @endif
                </td>
                <td class="col-sm-<?=$tamcol3;?>">
                    {!! Form::text('detalles['.$key.'][cantidad]', old('detalles['.$key.'][cantidad]', $detalle->cantidad), array('class' => 'form-control input-md cantidad cantidad-'.$key, 'disabled' => 'disabled')) !!}
                </td>
                <td class="col-sm-<?=$tamcol4;?>">                      
                    {!! Form::select('detalles['.$key.'][iva]', ['11' => '10%', '21' => '5%', "0" => "0%"], old('detalles['.$key.'][iva]',$detalle->iva), ['class' => 'form-control iva iva-'.$key, 'disabled' => 'disabled']) !!}
                </td>
                <td class="col-sm-<?=$tamcol5;?>">
                    {!! Form::text('detalles['.$key.'][precio_unitario]', old('detalles['.$key.'][precio_unitario]',$detalle->precio_unitario), array('class' => 'form-control input-md precio_unitario precio_unitario-'.$key, 'disabled' => 'disabled')) !!}
                </td>
                <td class="col-sm-<?=$tamcol6;?>">
                    {!! Form::text('detalles['.$key.'][sub_total]', old('detalles['.$key.'][sub_total]',$detalle->sub_total), array('class' => 'form-control input-md sub_total sub_total-'.$key, 'readonly' => 'readonly', "tabIndex" => "-1", 'disabled' => 'disabled')) !!}
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5" class="text-right">Monto total</th>
            <td colspan="<?=$tamcol7;?>">
                {!! Form::text('cabecera[monto_total]', old('cabecera[monto_total]', $factura->monto_total), array('class' => 'form-control input-md monto_total', 'readonly' => 'readonly', "tabIndex" => "-1", 'disabled' => 'disabled')) !!}
            </td>
        </tr>
    </tfoot>
</table>
<hr>