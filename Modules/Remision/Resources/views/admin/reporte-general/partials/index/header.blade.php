<div class="row">
	<div class="col-md-4 col-md-offset-1">
		{!! Form::label('for_cliente', 'Clientes', array('class' => 'mylabel')) !!}
		<select name="clientes" class="form-control" id="clientes">
					<option value="">Todos</option>
			@foreach($clientes as $key => $cliente_select)
				@if($cliente_select->id == $cliente->id)
					<option value="{{ $cliente_select->id }}" selected>{{ $cliente_select->razon_social }}</option>
				@else
					<option value="{{ $cliente_select->id }}">{{ $cliente_select->razon_social }}</option>
				@endif
			@endforeach
		</select>
	</div>
	<div class="col-md-4">
		{!! Form::label('for_obra', 'Obras', array('class' => 'mylabel')) !!}
		<select name="obras" class="form-control" id="obras">
			<option value="" selected>Todas</option>
		@foreach($obras as $key => $obra_cliente)
			@if(isset($obra->id) && $obra_cliente->id == $obra->id)
				<option value="{{ $obra_cliente->id }}" class="{{ $obra_cliente->cliente->id }}" selected>{{ $obra_cliente->etiqueta }} - {{ $obra_cliente->nombre }}</option>
			@else
				<option value="{{ $obra_cliente->id }}" class="{{ $obra_cliente->cliente->id }}">{{ $obra_cliente->etiqueta }} - {{ $obra_cliente->nombre }}</option>
			@endif
		@endforeach
		</select>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-2 col-md-offset-1">
		<table>
			<td>{!! Form:: normalInput('fecha_desde', 'Fecha Desde', $errors, (object)["fecha_desde" => $fecha_desde]) !!} </td>
			<td>
				<i class="glyphicon glyphicon-trash btn" onclick=""></i>
			</td>
		</table>
	</div>
	<div class="col-md-2">
		<table>
		<td>{!! Form:: normalInput('fecha_hasta', 'Fecha Hasta', $errors, (object)["fecha_hasta" => $fecha_hasta]) !!}</td>
		<td><i class="glyphicon glyphicon-trash btn"></i></td>
		</table>
	</div>
</div>
