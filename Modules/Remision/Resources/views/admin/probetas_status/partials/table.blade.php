<?php $columns = 
		"<tr>
			<th>ID</th>
			<th>NUMERO DE PROBETA</th>
			<th>FECHA MOLDEO</th>
			<th>DIAS</th>
			<th>FCK</th>
			<th>REMISION ID</th>
			<th>FECHA CREADO</th>
			<th>FECHA ROTURA</th>
			<th>CARGA APLICADA</th>
			<th>RESISTENCIA</th>
			<th>RESISTENCIA CALCULADA</th>
			<th>DIFF RESISTENCIAS</th>
			<th>PORCENTAJE</th>
			<th>PORCENTAJE CALCULADO</th>
			<th>DIFF PORCENTAJES</th>
			<th>DIAMETRO</th>
			<th>ALTURA</th>
			<th>PESO</th>
			<th>PESO ESPECIFICO</th>
			<th>PESO ESPECIFICO CALCULADO</th>
			<th>DIFF PESOS ESPECIFICOS</th>
		</tr>"
		;?>
<div class="table-responsive">
	<table class="data-table table table-bordered table-scriped table-hover">
		<thead class="btn-primary">
			{!! $columns !!}
		</thead>
		<tbody>
			<tr>
			</tr>
		</tbody>
		<tfoot class="btn-primary">
			{!! $columns !!}
		</tfoot>
	</table>
</div>