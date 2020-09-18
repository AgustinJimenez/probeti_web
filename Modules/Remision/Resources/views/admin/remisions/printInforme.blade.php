
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Impresion de Remision {{ $remision->numero_remision }}</title>
		
		<style type="text/css">

		.right-centrado
		{
			text-align: right;
			margin-right: 10%;
		}
		.left-centrado
		{
			text-align: left;
			margin-left: 11%;

		}
		.right-centrado-table
		{
			text-align: right;
			margin-right: 2%;
		}
		.left-centrado-table
		{
			text-align: left;
			margin-left: 1%;

		}
		.right-centrado-float
		{
			float: right;
			margin-right: 10%;
		}
		.left-centrado-float
		{
			float: left;
			margin-left: 10%;
		}
		table 
		{
			font-size: 10pt;
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}
		td, th 
		{
		    border: 1px solid #dddddd;
		    text-align: left;
		    padding: 0%;
		}
		strong
		{
			font-size: 11px;
		}
		p
		{
			font-size: 9px;
		}
		.referencias p
		{
			font-size:0.7em;
		}
		</style>
	</head>
	<body style="">
		
		<p align="center">
		<img
        src="data:image/png;base64,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"
       
        align="left"
        hspace="12"
        width="702"
        height="96"
        border="0"
    />
		</p>

		<div class="" style=" margin-left:79%;margin-right:0%; ">
			<div style="" >
				<span style="">Informe Nº: </span>
				<span style="">{{ $remision->numero_remision }}</span><br>
			</div>
			<div style="" >
				<span style="">Fecha: </span>
				<span style="">{{ $day }}/{{ $month }}/{{ $year }}</span>
			</div>
		</div>
		<div class="left-centrado-table" style="float: left; margin-right: 50%; padding-top: -4%; ">
			<span style="font-family: Arial, serif;">
				<span style="font-size: 13px;">
					<!--<strong>Dirección: {{-- $direccion --}}</strong><br>
					<strong>Tel&eacute;fono:</strong>
					<strong> {{ $telefono }}</strong><br>
					<strong>E-mail: </strong>
					<strong>{{ $email }}</strong><br>
					<strong>Ruc: </strong>
					<strong>{{ $ruc }}</strong><br>
					<strong>Timbrado: </strong>
					<strong>{{ $timbrado }}</strong>-->
				</span>
			</span>
		</div>
		<!--
		<p class="right-centrado-table" style="padding-top: -1%;">
			<span style="font-family: Arial, serif;">
				<span style="font-size: medium;">Luque</span>
				<span style="font-size: medium;">{{ $day }}</span>
				<span style="font-size: medium;">, de </span>
				<span style="font-size: medium;">{{ $month }}</span>
				<span style="font-size: medium;">del</span>
				<span style="font-size: medium;">{{ $year }}</span>
			</span>
		</p>
		-->
			<p class="left-centrado-table" style="">
				<span style="font-family: Arial, serif;">
					<span style="font-size: medium;">EMPRESA: {{ $remision->obra->cliente->nombre }}</span><br>
					<span style="font-size: medium;">RESIDENTE: {{ $remision->obra->residente }}</span><br>
					<span style="font-size: medium;">PRESENTE</span><br>
				</span>
			</p>

			<p class="left-centrado-table right-centrado-table">
				<span style="font-family: Arial, serif;">
					<span style="font-size: medium;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nos dirigimos a usted para presentarle el informe correspondiente a rotura de probetas de la obra </span>
					<span style="font-size: medium;">{{ $remision->obra->nombre }}.</span>
					<span style="font-size: medium;"> Los resultados de los ensayos de rotura de probetas de hormig&oacute;n son los siguientes:</span>
				</span>
			</p>
			<div id="tabla" >
			<table style="width: 100%;"><!--width="30%" cellspacing="0" cellpadding="5"-->
				<thead>
					<tr>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#</strong></span>
								</span>
							</p>
						</td>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;"><strong>N&ordm; de Probeta</strong></span>
								</span>
							</p>
						</td>

						<td colspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Fecha de:</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Edad (d&iacute;as)</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Area (cm²)</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Fck Teorico (kg/cm²)</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Tipo de Rotura</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Carga de Rotura (kg)</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Resistencia (kg/cm²)</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Porcentaje</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Estructura</strong>
									</span>
								</span>
							</p>
						</td>

						<td rowspan="2" bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Observaci&oacute;n</strong>
									</span>
								</span>
							</p>
						</td>

					</tr>
					<tr>
						<td bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Moldeo</strong>
									</span>
								</span>
							</p>
						</td>
						<td bgcolor="#5a5a5a" >
							<p align="center">
								<span style="color: #ffffff;">
									<span style="font-family: Calibri, serif;">
										<strong>Rotura</strong>
									</span>
								</span>
							</p>
						</td>
					</tr>
				</thead>
					<tbody>
					@if (isset($remision_detalles))
						@foreach ($remision_detalles as $key => $remision_detalle)
							<?php $radio=(  str_replace(',','.',$remision_detalle->diametro)/2) ;
								   $area=3.14*($radio*$radio);
								   //carga_aplicada_kg
							?>
							<tr valign="bottom">
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;">{{ $key+1 }}</span></p>
								</td>
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;">{{ $remision_detalle->numero_probeta }}</span></p>
								</td>
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;"> {{ $remision_detalle->fecha_moldeo }}</span></p>
								</td>
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;" > {{ $remision_detalle->fecha_rotura }}</span></p>
								</td>
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;"> {{ $remision_detalle->dias }}</span></p>
								</td>

								<?php $area=number_format($area,2,",","."); ?>

								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;" id="area"> <?php echo $area;?></span></p>
								</td>
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;"> {{ $remision_detalle->wformat('fck') }} </span></p>
								</td>
								<td bgcolor="#ffffff" >
									<p align="center"><span style="color: #000000;"> {{ $remision_detalle->tipo_rotura }} </span></p>
								</td>
									<td bgcolor="#ffffff" >
                            			<p align="center"><span style="color: #000000;" id="carga_aplicada">{{ $remision_detalle->carga_aplicada_kg }}</span></p>
                            		</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" id="resistencia"> {{ $remision_detalle->wformat('resistencia') }}</span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;"> {{ $remision_detalle->relacion_fck_resistencia }}</span></p>
									</td>
                            		<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" > {{ $remision_detalle->pieza_estructural }}</span></p>
									</td>
									<td bgcolor="#ffffff" >
										<p align="center"><span style="color: #000000;" > {{ $remision_detalle->observacion }}</span></p>
									</td>
								</td>
							</tr>
						@endforeach
                    @endif
				</tbody>
			</table>
			</div>
			<br>
				<p style="font-size: 12px!important;">El moldeo de las probetas es responsabilidad exclusiva del cliente.</p>
			<br><br>
			<p class="left-centrado-table">
				<span style="font-family: Arial, serif;">
					<span style="font-size: medium;">Le saludo muy atentamente. </span>
				</span>
			</p>
			<br>
			<p class="right-centrado-table">
				<span style="font-family: Arial, serif; ">
					<span style="font-size: medium;">{{ $firma }}</span>
				</span>
			</p>
			<br><br><br><br><br>
			<div>
				<strong>REFERENCIAS DE TIPOS DE ROTURAS</strong>
				<div class="referencias">
					<p>TIPO A: Conos razonablemente bien formados en ambos extremos, fisuras a través de los cabezales de menos de 25 mm (1 pulgada)</p>
					<p>TIPO B: Conos bien formados en un extremo, fisuras verticales a través de los cabezales, cono no bien definido en el otro extremo.</p>
					<p>TIPO C: Fisuras verticales encolumnadas a través de ambos extremos, conos mal formados.</p>
					<p>TIPO D: Fractura Diagonal y Cono bien formado en un extremo.</p>
					<p>TIPO E: Fractura diagonal sin fisuras a través de los extremos.</p>
					<p>TIPO F: Fracturas en los lados en las partes superior o inferior.</p>
					<p>TIPO G: Similar al Tipo F pero al extremo del cilindro es puntiagudo.</p>
				</div>
			</div>
		</body>
	</html>
	<script type="text/javascript">
	</script>
	
	@section('scripts')
		<script src="{{ asset('js/jquery.number.min.js') }}"></script>

		<script type="text/javascript">
			$( document ).ready(function()
			{
				$("#area").number( true , 0, '', '.' );
				$("#carga_aplicada").number( true , 0, '', '.' );
				$("#resistencia").number( true , 0, '', '.' );
			});


		</script>

		 

	@stop