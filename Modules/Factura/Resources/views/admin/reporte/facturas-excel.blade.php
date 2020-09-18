<table>
	<tr>
		<td>Fecha Inicio: {{ $fecha_inicio }}</td>
		<td>Fecha Fin: {{ $fecha_fin }}</td>
		<td>Fecha de Documento: {{ $fecha_de_documento }}</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<th>Fecha</th>
		<th>Razon Social</th>
		<th>Nro de Factura</th>
		<th>Pagado</th>
		<th>Anulado</th>
		<th>Monto Total</th>
	</tr>
	@foreach($facturas as $key => $factura)
		<tr>
			<td>{{ $factura->fecha }}</td>
			<td>{{ $factura->razon_social }}</td>
			<td>{{ $factura->nro_factura }}</td>
			<td>{{ $factura->cobrado?"SI":"NO" }}</td>
			<td>{{ $factura->anulado?"SI":"NO" }}</td>
			<td>{{ $factura->monto_total }}</td>
		</tr>
	@endforeach
</table>