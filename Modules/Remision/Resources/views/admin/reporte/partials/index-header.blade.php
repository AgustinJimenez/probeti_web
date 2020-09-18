<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-4">
		{!! Form::label('for_cliente', 'Clientes', array('class' => 'mylabel')) !!}
		<select name="clientes" class="form-control" id="clientes">
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
			<option value="" selected>--</option>
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
<hr>
<h3 class="text-center">REMISIONES</h3>