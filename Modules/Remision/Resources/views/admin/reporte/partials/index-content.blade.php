<style type="text/css">
	.blue-bg
	{
		background: #3c8dbc!important;
		color:white!important;
	}
	.blue-bg2
	{
		background: #3c8dbc;
		color:white;
	}
	.full-width
	{
		width: 100%;
	}
</style>
	<div class="row totales">
		<div class="col-md-12 table-responsive">
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr>
					<th class="blue-bg text-center" colspan="3">
						Retiradas
					</th>
					<th class="blue-bg text-center" colspan="3">
						Ensayadas
					</th>
					<th class="blue-bg text-center" colspan="3">
						Facturadas
					</th>
					<th class="blue-bg text-center" colspan="3">
						Por Cobrar
					</th>
					<th class="blue-bg text-center" colspan="3">
						Por Ensayar
					</td>
				</tr>
				<tr>
					<td id="cantidades-probetas-retiradas" colspan="3" class="text-center"></td>
					<td id="cantidades-probetas-ensayadas" colspan="3" class="text-center"></td>
					<td id="cantidades-probetas-facturadas" colspan="3" class="text-center"></td>
					<td id="cantidades-probetas-cobrar" colspan="3" class="text-center"></td>
					<td id="cantidades-probetas-ensayar" colspan="3" class="text-center"></td>
				</tr>
				<tr>
					<td class="blue-bg">CHICAS</td>
					<td class="blue-bg">MEDIANAS</td>
					<td class="blue-bg">GRANDES</td>
					<td class="blue-bg">CHICAS</td>
					<td class="blue-bg">MEDIANAS</td>
					<td class="blue-bg">GRANDES</td>
					<td class="blue-bg">CHICAS</td>
					<td class="blue-bg">MEDIANAS</td>
					<td class="blue-bg">GRANDES</td>
					<td class="blue-bg">CHICAS</td>
					<td class="blue-bg">MEDIANAS</td>
					<td class="blue-bg">GRANDES</td>
					<td class="blue-bg">CHICAS</td>
					<td class="blue-bg">MEDIANAS</td>
					<td class="blue-bg">GRANDES</td>
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
					<td id="cantidades-probetas-cobrar-chicas" class="text-center"></td>
					<td id="cantidades-probetas-cobrar-medianas" class="text-center"></td>
					<td id="cantidades-probetas-cobrar-grandes" class="text-center"></td>
					<td id="cantidades-probetas-ensayar-chicas" class="text-center"></td>
					<td id="cantidades-probetas-ensayar-medianas" class="text-center"></td>
					<td id="cantidades-probetas-ensayar-grandes" class="text-center"></td>
				</tr>
			</table>
		</div>
	</div>
	<br>
	<div class="remisiones">
	@foreach ($remisiones as $remision)
		<div obra-id="{{ $remision->obra->id }}" cliente-id="{{ $remision->obra->cliente->id }}" class="remision" style="display:none;">
			<div class="table-responsive row">
				<div class="col-md-3">
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tr>
							<td class="blue-bg">
								<strong>Fecha:</strong> 
							</td>
							<td class="blue-bg">
								<strong>{{ $remision->fecha_remision }}</strong>
							</td>
						</tr>	
						<tr>
							<td class="blue-bg">
								<strong>Nro Remision:</strong> 
							</td> 
							<td class="blue-bg">
								<strong>{{ $remision->numero_remision }}</strong>
							</td>
						</tr>
						<tr>
							<td class="blue-bg">
								<strong>Obra:</strong> 
							</td>	
							<td class="blue-bg">
								<strong>{{ $remision->obra->etiqueta }} - {{ $remision->obra->nombre }}</strong>
							</td>
						</tr>
						<tr>
							<td class="blue-bg">
								<strong>Probetas:</strong> 
							</td>	
							<td class="blue-bg">
								<strong>{{ count($remision->detalles) }}</strong>
							</td>
						</tr>
					</table>
				</div>
				<div class="col-md-9">
					<table class="data-table table table-bordered table-hover table-condensed">
						<thead class="blue-bg">
							<th>Tipos</th>
							<th>Retiradas</th>
							<th>Ensayadas</th>
							<th>Facturadas</th>
							<th>Por Cobrar</th>
							<th>Por Ensayar</th>
						</thead>
						<tbody>
							<?php $datos_probetas = $remision->datos_probetas();?>
							<tr class="chicas">
								<td class="text-center"><strong>Chicas</strong></td>
								<td class="retiradas probeta">{{ $retiradas_chicas = $datos_probetas['retiradas']['chicas'] }}</td>
								<td class="ensayadas  probeta">{{ $ensayadas_chicas = $datos_probetas['ensayadas']['chicas'] }}</td>
								<td class="facturadas  probeta">{{ str_replace('.', ',', $facturadas_chicas = $datos_probetas['facturadas']['chicas']) }}</td>
								<td class="por_cobrar  probeta">{{ str_replace('.', ',', $por_cobrar_chicas = $datos_probetas['por_cobrar']['chicas']) }}</td>
								<td class="por_ensayar  probeta">{{ $por_ensayar_chicas = $datos_probetas['por_ensayar']['chicas'] }}</td>
							</tr>
							<tr class="medianas">
								<td class="text-center"><strong>Medianas</strong></td>
								<td class="retiradas probeta">{{ $retiradas_medianas = $datos_probetas['retiradas']['medianas'] }}</td>
								<td class="ensayadas probeta">{{ $ensayadas_medianas = $datos_probetas['ensayadas']['medianas'] }}</td>
								<td class="facturadas probeta">{{ str_replace('.', ',', $facturadas_medianas = $datos_probetas['facturadas']['medianas']) }}</td>
								<td class="por_cobrar probeta">{{ str_replace('.', ',', $por_cobrar_medianas = $datos_probetas['por_cobrar']['medianas']) }}</td>
								<td class="por_ensayar probeta">{{ $por_ensayar_medianas = $datos_probetas['por_ensayar']['medianas'] }}</td>
							</tr>
							<tr class="grandes">
								<td class="text-center"><strong>Grandes</strong></td>
								<td class="retiradas probeta">{{ $retiradas_grandes = $datos_probetas['retiradas']['grandes'] }}</td>
								<td class="ensayadas probeta">{{ $ensayadas_grandes = $datos_probetas['ensayadas']['grandes'] }}</td>
								<td class="facturadas probeta">{{ str_replace('.', ',', $facturadas_grandes = $datos_probetas['facturadas']['grandes'] ) }}</td>
								<td class="por_cobrar probeta">{{ str_replace('.', ',', $por_cobrar_grandes = $datos_probetas['por_cobrar']['grandes']) }}</td>
								<td class="por_ensayar probeta">{{ $por_ensayar_grandes = $datos_probetas['por_ensayar']['grandes'] }}</td>
							</tr>
							<tfoot class="todas blue-bg">
								<tr>
									<td class="text-center"><strong>TOTAL</strong></td>
									<td class="retiradas todas-retiradas"><strong>{{ $retiradas_chicas + $retiradas_medianas + $retiradas_grandes }}</strong></td>
									<td class="ensayadas todas-ensayadas"><strong>{{ $ensayadas_chicas + $ensayadas_medianas + $ensayadas_grandes }}</strong></td>
									<td class="facturadas todas-facturadas"><strong>{{ str_replace('.', ',', $facturadas_chicas + $facturadas_medianas + $facturadas_grandes) }}</strong></td>
									<td class="por_cobrar todas-por_cobrar"><strong>{{ str_replace('.', ',', $por_cobrar_chicas + $por_cobrar_medianas + $por_cobrar_grandes) }}</strong></td>
									<td class="por_ensayar todas-por_ensayar"><strong>{{ $por_ensayar_chicas + $por_ensayar_medianas + $por_ensayar_grandes }}</strong></td>
								</tr>
							</tfoot>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	@endforeach
	<div>
	<br>