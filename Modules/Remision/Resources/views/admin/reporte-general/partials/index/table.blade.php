<style type="text/css">
	td
	{
		text-align: center;
	}
</style>
<hr>
<h3 class="text-center">TOTALES</h3>
<div class="totales">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover table-condensed">
			<tr>
				<th class="bg-primary text-center" colspan="3">
					Retiradas
				</th>
				<th class="bg-primary text-center" colspan="3">
					Ensayadas
				</th>
				<th class="bg-primary text-center" colspan="3">
					Facturadas
				</th>
				<!--
				<th class="bg-primary text-center" colspan="3">
					Por Cobrar
				</th>
				<th class="bg-primary text-center" colspan="3">
					Por Ensayar
				</td>
				-->
			</tr>
			<tr>
				<td id="cantidades-probetas-retiradas" colspan="3" class="text-center"></td>
				<td id="cantidades-probetas-ensayadas" colspan="3" class="text-center"></td>
				<td id="cantidades-probetas-facturadas" colspan="3" class="text-center"></td>
			<!--
				<td id="cantidades-probetas-cobrar" colspan="3" class="text-center"></td>
				<td id="cantidades-probetas-ensayar" colspan="3" class="text-center"></td>
			-->
			</tr>
			<tr>
				<td class="bg-primary">CHICAS</td>
				<td class="bg-primary">MEDIANAS</td>
				<td class="bg-primary">GRANDES</td>

				<td class="bg-primary">CHICAS</td>
				<td class="bg-primary">MEDIANAS</td>
				<td class="bg-primary">GRANDES</td>

				<td class="bg-primary">CHICAS</td>
				<td class="bg-primary">MEDIANAS</td>
				<td class="bg-primary">GRANDES</td>
				<!--
				<td class="bg-primary">CHICAS</td>
				<td class="bg-primary">MEDIANAS</td>
				<td class="bg-primary">GRANDES</td>

				<td class="bg-primary">CHICAS</td>
				<td class="bg-primary">MEDIANAS</td>
				<td class="bg-primary">GRANDES</td>
				-->
			</tr>
			<tr>
				<td id="cantidades-probetas-retiradas-chicas" class="text-center"></td>
				<td id="cantidades-probetas-retiradas-medianas" class="text-center"></td>
				<td id="cantidades-probetas-retiradas-grandes" class="text-center"></td>

				<td id="cantidades-probetas-ensayadas-chicas" class="text-center"></td>
				<td id="cantidades-probetas-ensayadas-medianas" class="text-center"></td>
				<td id="cantidades-probetas-ensayadas-grandes" class="text-center"></td>

				<td id="cantidades-probetas-facturadas-chicas" class="text-center"></td>
				<td id="cantidades-probetas-facturadas-medianas" class="text-center"></td>
				<td id="cantidades-probetas-facturadas-grandes" class="text-center"></td>
<!--
				<td id="cantidades-probetas-cobrar-chicas" class="text-center"></td>
				<td id="cantidades-probetas-cobrar-medianas" class="text-center"></td>
				<td id="cantidades-probetas-cobrar-grandes" class="text-center"></td>
				
				<td id="cantidades-probetas-ensayar-chicas" class="text-center"></td>
				<td id="cantidades-probetas-ensayar-medianas" class="text-center"></td>
				<td id="cantidades-probetas-ensayar-grandes" class="text-center"></td>
-->
			</tr>
		</table>
	</div>
</div>
<hr>
<h3 class="text-center">REMISIONES</h3>

<div class="table-responsive">
	<?php $table_remisiones_columns = 
	[
		"Nro Remision",
		"Cliente",
		"Obra",
		'Fecha',
		"Retiradas",
		"Ensayadas",
		"Facturadas",
		"Acciones",
	];
	?>
	<table class="table table-bordered table-striped table-hover table-condensed" id="table-remisiones">
		<thead>
			@foreach ($table_remisiones_columns as $column)
				<th class="bg-primary text-center">{{ $column }}</th>
			@endforeach
		</thead>
		<tbody>
			
		</tbody>
		<tfoot>
			@foreach ($table_remisiones_columns as $column)
				<th class="bg-primary text-center">{{ $column }}</th>
			@endforeach
		</tfoot>
	</table>

</div>
