<style type="text/css">
    .white-input
    {
        background-color: white !important;
        border:none;
        font-size: 2em;
    }
    .white-input2
    {
        background-color: white !important;
        border:none;
    }
    .head
    {
        text-align:center;
    }
    table
    {
        width: 100%;
    }
    p.error
    {
        color:red;
    }
</style>
<fieldset>
    
    @if($factura->id)
        {!! Form::$DEBUG('cabecera[id]', $factura->id , ['style' => 'width:30px; margin-top:-65px !important; background-color:LawnGreen ;', "readonly" => "readonly", "class" => "id", 'disabled' => 'disabled']) !!}
    @endif
    <div class="box-body cabecera">
        <div class="row">
            <div class="form-group col-md-6 {!! $errors->first('cabecera[razon_social]',  'has-error') !!} {!! $errors->first('cabecera[cliente_id]',  'has-error') !!}">
                {!! Form::label('for_razon_social', 'Razon Social', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[razon_social]', old('cabecera[razon_social]',$factura->razon_social) , array('class' => 'form-control input-md razon_social ', 'placeholder' => "Razon Social", 'id' => 'razon_social', 'disabled' => 'disabled')) !!}
                {!! Form::$DEBUG('cabecera[cliente_id]', old('cabecera[cliente_id]',$factura->cliente_id) , ['style' => 'width:30px; margin-top:-65px; background-color:DeepSkyBlue ;!important;', "readonly" => "readonly", "class" => "cliente_id", 'disabled' => 'disabled']) !!}
                {!! $errors->first('cabecera[razon_social]', '<p class="error">:message</p>') !!}
                {!! $errors->first('cabecera[cliente_id]', '<p class="error">:message</p>') !!}
            </div>
            <div class="form-group col-md-6 {!! $errors->first('cabecera[direccion]',  'has-error') !!}">
                {!! Form::label('for_direccion', 'Direccion', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[direccion]', old('cabecera[direccion]',$factura->direccion), array('class' => 'form-control input-md direccion ', 'placeholder' => "Direccion" , 'id' => 'direccion', 'required' => 'required', 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[direccion]', '<p class="error">:message</p>') !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2 {!! $errors->first('cabecera[ruc]',  'has-error') !!}">
                {!! Form::label('for_ruc', 'RUC', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[ruc]', old('cabecera[ruc]',$factura->ruc) , array('class' => 'form-control input-md ruc ', 'placeholder' => "RUC" , 'id' => 'ruc', 'required' => 'required', 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[ruc]', '<p class="error">:message</p>') !!}
            </div>
            <div class="form-group col-md-2 {!! $errors->first('cabecera[telefono]',  'has-error') !!}">
                {!! Form::label('for_telefono', 'Telefono', array('class' => 'mylabel')) !!}
                {!! Form::number('cabecera[telefono]', old('cabecera[telefono]',$factura->telefono) , array('class' => 'form-control input-md telefono ', 'placeholder' => "Telefono" , 'id' => 'telefono', 'min' => '0', 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[telefono]', '<p class="error">:message</p>') !!}
            </div>
            <div class="form-group col-md-2 {!! $errors->first('cabecera[forma_de_pago]',  'has-error') !!}">
                {!! Form::label('for_forma_pago', 'Forma de Pago', array('class' => 'mylabel')) !!}
                {!! Form::select('cabecera[forma_de_pago]', ['contado' => 'Contado', 'credito' => 'Credito'], old('cabecera[forma_de_pago]',$factura->forma_de_pago), ['class' => 'form-control input-md forma_pago', 'id' => 'forma_pago', 'disabled' => 'disabled']) !!}
                {!! $errors->first('cabecera[forma_de_pago]', '<p class="error">:message</p>') !!}
            </div>
            <div class="form-group col-md-3 {!! $errors->first('cabecera[fecha]',  'has-error') !!}">
                {!! Form::label('for_fecha', 'Fecha', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[fecha]', old('cabecera[fecha]',$factura->fecha), array('class' => 'form-control input-md fecha ', 'placeholder' => "Fecha" , 'id' => 'fecha', 'required' => 'required', 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[fecha]', '<p class="error">:message</p>') !!}
            </div>
            <div class="form-group col-md-3 {!! $errors->first('cabecera[nro_factura]',  'has-error') !!}">
                {!! Form::label('for_nro_factura', 'Nro. de Factura', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[nro_factura]', old('cabecera[nro_factura]',$factura->nro_factura), array('class' => 'form-control input-md nro_factura white-input', 'placeholder' => "Nro. de Factura" , 'id' => 'nro_factura', 'readonly' => 'readonly', 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[nro_factura]', '<p class="error">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="box-body detalles">
        <div class="table-responsive" id="div-tabla">
<!--==========================DETALLES================================================-->
            @include('factura::admin.facturas.partials.factura-detalles-show')
<!--==========================DETALLES================================================-->
        </div>
    </div>
    <?php $margin_right = 1;?>
    <div id="box-body footer">
        <div class="row">
            <div class="col-md-<?=$margin_right;?>"></div>
            <div class="col-md-9 {!! $errors->first('cabecera[monto_total_letras]',  'has-error') !!}">
                {!! Form::label('for_monto_total_letras', 'Monto Total', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[monto_total_letras]', old('cabecera[monto_total_letras]',$factura->monto_total_letras), array('class' => 'form-control input-md monto_total_letras white-input2', 'id' => 'monto_total_letras', 'readonly' => 'readonly', "tabIndex" => "-1", 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[monto_total_letras]', '<p class="error">:message</p>') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-<?=$margin_right;?>"></div>
            <div class="col-md-3 {!! $errors->first('cabecera[iva_5_total]',  'has-error') !!}">
                {!! Form::label('for_iva_5_total', 'IVA 5%', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[iva_5_total]', old('cabecera[iva_5_total]',$factura->iva_5_total), array('class' => 'form-control input-md iva_5_total white-input2', 'id' => 'iva_5_total', 'readonly' => 'readonly', "tabIndex" => "-1", 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[iva_5_total]', '<p class="error">:message</p>') !!}
            </div>
            <div class="col-md-3 {!! $errors->first('cabecera[iva_10_total]',  'has-error') !!}">
                {!! Form::label('for_iva_10_total', 'IVA 10%', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[iva_10_total]', old('cabecera[iva_10_total]',$factura->iva_10_total), array('class' => 'form-control input-md iva_10_total white-input2', 'id' => 'iva_10_total', 'readonly' => 'readonly', "tabIndex" => "-1", 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[iva_10_total]', '<p class="error">:message</p>') !!}
            </div>
            <div class="col-md-3 {!! $errors->first('cabecera[iva_total]',  'has-error') !!}">
                {!! Form::label('for_iva_total', 'IVA Total', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[iva_total]', old('cabecera[iva_total]',$factura->iva_total), array('class' => 'form-control input-md iva_total white-input2', 'id' => 'iva_total', 'readonly' => 'readonly', "tabIndex" => "-1", 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[iva_total]', '<p class="error">:message</p>') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-<?=$margin_right;?>"></div>
            <div class="col-md-9 {!! $errors->first('cabecera[observacion]',  'has-error') !!}">
                {!! Form::label('for_observacion', 'Observacion', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[observacion]', old('cabecera[observacion]',$factura->observacion), array('class' => 'form-control input-md observacion',  "placeholder" => "Observacion",'id' => 'observacion', 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[observacion]', '<p class="error">:message</p>') !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-<?=$margin_right;?>"></div>
            <div class="col-md-9 {!! $errors->first('cabecera[detalle_pago]',  'has-error') !!}">
                {!! Form::label('for_detalle_pago', 'Detalle de pago', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera[detalle_pago]', old('cabecera[detalle_pago]',$factura->detalle_pago), array('class' => 'form-control input-md detalle_pago', "placeholder" => "Detalle de pago", 'id' => 'detalle_pago', 'required' => 'required', 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[detalle_pago]', '<p class="error">:message</p>') !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-<?=$margin_right;?>"></div>
            <div class="col-md-9 {!! $errors->first('cabecera[orden_compra]',  'has-error') !!}">
                {!! Form::label('for_'.$name="orden_compra", $title='Orden de Compra', array('class' => 'mylabel')) !!}
                {!! Form::text('cabecera['.$name.']', old('cabecera[orden_compra]',$factura->orden_compra), array('class' => 'form-control input-md '.$name, "placeholder" => $title, 'id' => $name, 'disabled' => 'disabled')) !!}
                {!! $errors->first('cabecera[orden_compra]', '<p class="error">:message</p>') !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2">
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                
                    {!! Form::label('for_anular', 'Anular Factura', array('class' => 'mylabel', 'style' => 'font-size:2em;')) !!}
                    {!! Form::normalCheckbox('cabecera[anulado]', 'Check para anular', $errors, (object)["cabecera[anulado]" => old('cabecera[anulado]',$factura->anulado)]) !!}
               
            </div>
            <div class="col-md-2">
                    {!! Form::label('for_anular', 'Cobrado', array('class' => 'mylabel', 'style' => 'font-size:2em;')) !!}
                    {!! Form::normalCheckbox('cabecera[cobrado]', 'Cobrado', $errors, (object)["cabecera[cobrado]" => old('cabecera[cobrado]',$factura->cobrado)]) !!}
            </div>
        </div>
    </div>
    <br><br><br>
</div>
<div class="box-footer">
        <button type="submit" class="btn btn-primary btn-flat">Actualizar Factura</button>
        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.factura.factura.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
    
</div>
</fieldset>
