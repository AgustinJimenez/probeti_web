{!! Theme::script('js/jquery.chained.min.js') !!}
<script type="text/javascript">
	$(document).ready(function()
	{
		$("#obras").chained("#clientes");
		select_obras_cambio();
		/*
		=============================================
		===================EVENTOS===================
		=============================================
		*/
		$("#obras").on("change" ,function()
		{
			select_obras_cambio();
			calcular_totales();
		});
		$("#clientes").on("change" ,function()
		{
			select_clientes_cambio();
			calcular_totales();
		});
		/*
		=============================================
		=============================================
		=============================================
		 */
		
		 //EVENTOS INICIALES

		calcular_totales()



		/*
		=============================================
		===================FUNCIONS==================
		=============================================
		*/
		function calcular_totales()
		{
			var cantidad_retiradas = get_cantidad('.todas-retiradas'); 	
			var cantidad_ensayadas = get_cantidad('.todas-ensayadas'); 
			var cantidad_facturadas = get_cantidad3('.todas-facturadas'); 
			var cantidad_cobrar = get_cantidad3('.todas-por_cobrar'); 
			var cantidad_ensayar = get_cantidad('.todas-por_ensayar'); 


			$("#cantidades-probetas-retiradas").text(cantidad_retiradas);
			$("#cantidades-probetas-ensayadas").text(cantidad_ensayadas);
			$("#cantidades-probetas-facturadas").text(cantidad_facturadas);
			$("#cantidades-probetas-cobrar").text(cantidad_cobrar);
			$("#cantidades-probetas-ensayar").text(cantidad_ensayar);

			var chicas = '';
			var medianas = '';
			var grandes = '';

			chicas = get_cantidad2(".chicas:visible .retiradas");
			medianas = get_cantidad2(".medianas:visible .retiradas");
			grandes = get_cantidad2(".grandes:visible .retiradas");

			$("#cantidades-probetas-retiradas-chicas").text( chicas );
			$("#cantidades-probetas-retiradas-medianas").text( medianas );
			$("#cantidades-probetas-retiradas-grandes").text( grandes );

			chicas = get_cantidad2(".chicas:visible .ensayadas");
			medianas = get_cantidad2(".medianas:visible .ensayadas");
			grandes = get_cantidad2(".grandes:visible .ensayadas");

			$("#cantidades-probetas-ensayadas-chicas").text(chicas);
			$("#cantidades-probetas-ensayadas-medianas").text(medianas);
			$("#cantidades-probetas-ensayadas-grandes").text(grandes);

			chicas = get_cantidad4(".chicas:visible .facturadas");
			medianas = get_cantidad4(".medianas:visible .facturadas");
			grandes = get_cantidad4(".grandes:visible .facturadas");

			$("#cantidades-probetas-facturadas-chicas").text(chicas);
			$("#cantidades-probetas-facturadas-medianas").text(medianas);
			$("#cantidades-probetas-facturadas-grandes").text(grandes);

			chicas = get_cantidad4(".chicas:visible .por_cobrar");
			medianas = get_cantidad4(".medianas:visible .por_cobrar");
			grandes = get_cantidad4(".grandes:visible .por_cobrar");

			$("#cantidades-probetas-cobrar-chicas").text(chicas);
			$("#cantidades-probetas-cobrar-medianas").text(medianas);
			$("#cantidades-probetas-cobrar-grandes").text(grandes);

			chicas = get_cantidad2(".chicas:visible .por_ensayar");
			medianas = get_cantidad2(".medianas:visible .por_ensayar");
			grandes = get_cantidad2(".grandes:visible .por_ensayar");

			$("#cantidades-probetas-ensayar-chicas").text(chicas);
			$("#cantidades-probetas-ensayar-medianas").text(medianas);
			$("#cantidades-probetas-ensayar-grandes").text(grandes);
		
		}
		function replace_this(target, search, replacement)
		{
			return String(target).split(search).join(replacement);
		};
		function get_cantidad(selector)
		{
			var total = 0;
			$(selector+" :visible").each(function()
			{
				total += parseInt( $(this).text() );
			});
			return total;
		}
		function get_cantidad3(selector)
		{
			var total = 0;
			$(selector+" :visible").each(function()
			{
				total += +parseFloat( replace_this( $(this).text(), ',','.' ) ).toFixed(2);
				console.log("c3 total="+total);
			});
			return replace_this(total, '.',',' );
		}
		function get_cantidad4(selector)
		{
			var total = 0;
			$(selector).each(function()
			{
				total += +parseFloat( replace_this($(this).text(), ',','.' ) ).toFixed(2);
				console.log("c4 total="+total);
			});
			return replace_this(total, '.',',' );
		}
		function get_cantidad2(selector)
		{
			var total = 0;
			$(selector).each(function()
			{

				total += parseInt($(this).text());
			});
			return total;
		}
		function get_obra_selected_id()
		{
			var obra_id = $("#obras option:selected").val();
			if(obra_id == '')obra_id = 0;
			var obra_selected_id = parseInt(obra_id);
			return obra_selected_id;
		}
		function get_cliente_selected_id()
		{
			var cliente_selected_id = parseInt($("#clientes option:selected").val());
			return cliente_selected_id;
		}

		function select_clientes_cambio()
		{
			refrescar();
		}

		function select_obras_cambio()
		{
			refrescar();
		}

		function refrescar()
		{
			var selected_cliente_id = get_cliente_selected_id();
			var selected_obra_id = get_obra_selected_id();
			var remision_cliente_id = 0;
			var remision_obra_id = 0;
			var find_some = false;
			$(".remision").each(function()
			{
				remision_cliente_id = parseInt($(this).attr("cliente-id"));
				remision_obra_id = parseInt($(this).attr("obra-id"));
				//dd(""+remision_cliente_id+"====>"+selected_cliente_id+"  "+remision_obra_id+" ======>"+selected_obra_id);
				if(!selected_obra_id)
					if(remision_cliente_id == selected_cliente_id)
						mostrar_remision($(this))
					else
						$(this).hide();
				else
					if(remision_cliente_id == selected_cliente_id && remision_obra_id == selected_obra_id)
						mostrar_remision($(this))
					else
						$(this).hide();
			});
		}

		function mostrar_remision(remision)
		{
			remision.show();
			var retiradas = 0;
			var ensayadas = 0;
			var facturadas = 0;
			var por_cobrar = 0;
			var por_ensayar = 0;

			var chicas = remision.find('.chicas');
			var medianas = remision.find('.medianas');
			var grandes = remision.find('.grandes');

			retiradas = parseInt(chicas.find(".retiradas").text());
			ensayadas = parseInt(chicas.find(".ensayadas").text());
			facturadas = parseInt(chicas.find(".facturadas").text());
			por_cobrar = parseInt(chicas.find(".por_cobrar").text());
			por_ensayar = parseInt(chicas.find(".por_ensayar").text());

			if( !(retiradas+ensayadas+facturadas+por_cobrar+por_ensayar)>0 )
				chicas.hide();
			else
				chicas.show();

			retiradas = parseInt(medianas.find(".retiradas").text());
			ensayadas = parseInt(medianas.find(".ensayadas").text());
			facturadas = parseFloat(medianas.find(".facturadas").text());
			por_cobrar = parseInt(medianas.find(".por_cobrar").text());
			por_ensayar = parseInt(medianas.find(".por_ensayar").text());

			if( !(retiradas+ensayadas+facturadas+por_cobrar+por_ensayar)>0 )
				medianas.hide();
			else
				medianas.show();
			
			retiradas = parseInt(grandes.find(".retiradas").text());
			ensayadas = parseInt(grandes.find(".ensayadas").text());
			facturadas = parseInt(grandes.find(".facturadas").text());
			por_cobrar = parseInt(grandes.find(".por_cobrar").text());
			por_ensayar = parseInt(grandes.find(".por_ensayar").text());

			if( !(retiradas+ensayadas+facturadas+por_cobrar+por_ensayar)>0 )
				grandes.hide();
			else
				grandes.show();


		}

		Number.prototype.formatMoney = function(c, d, t)
		{
			//.formatMoney(2, ',', '.')
			var n = this, 
		    c = isNaN(c = Math.abs(c)) ? 2 : c, 
		    d = d == undefined ? "." : d, 
		    t = t == undefined ? "," : t, 
		    s = n < 0 ? "-" : "", 
		    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
		    j = (j = i.length) > 3 ? j % 3 : 0;
		   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	 	};

		function dd(data)
		{
			return console.log(data);
		}
		/*
		=============================================
		=============================================
		=============================================
		 */

	});
</script>