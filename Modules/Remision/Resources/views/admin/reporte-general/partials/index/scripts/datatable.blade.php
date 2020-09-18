<script type="text/javascript">
    $.fn.dataTable.ext.errMode = 'none';
    var template = Handlebars.compile( TABLE_DETALLES_TEMPLATE.html() );

	var table = TABLE_REMISIONES.DataTable(
    {
        dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
        "<'row'<'col-xs-12't>>"+
        "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
        "deferRender": true,
        processing: true,
        "order": [[ 3, "desc" ]],
        serverSide: true,
        "paginate": true,
        "lengthChange": true,
        "filter": true,
        "sort": true,
        "info": true,
        "autoWidth": true,
        "iDisplayLength": 25,
        ajax:
         {
            url: '{!! route('admin.remision.remision.reporte_remision_obra_cliente_ajax') !!}',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            type: "POST",
            data: function (e)
            {
              e.fecha_desde = INPUT_FECHA_DESDE.val(),
              e.fecha_hasta = INPUT_FECHA_HASTA.val(),  
              e.cliente_id = SELECT_CLIENTES.val(),
              e.obra_id = SELECT_OBRAS.val()
            },
            "dataSrc": function ( json ) 
            {
                var total_retiradas_chicas = json.cantidades_probetas_retiradas_chicas;
                var total_retiradas_medianas = json.cantidades_probetas_retiradas_medianas;
                var total_retiradas_grandes = json.cantidades_probetas_retiradas_grandes;

                var total_ensayadas_chicas = json.cantidades_probetas_ensayadas_chicas;
                var total_ensayadas_medianas = json.cantidades_probetas_ensayadas_medianas;
                var total_ensayadas_grandes = json.cantidades_probetas_ensayadas_grandes;

                var total_facturadas_chicas = json.cantidades_probetas_facturadas_chicas;
                var total_facturadas_medianas = json.cantidades_probetas_facturadas_medianas;
                var total_facturadas_grandes = json.cantidades_probetas_facturadas_grandes;
/*
                var total_por_cobrar_chicas = json.cantidades_probetas_por_cobrar_chicas;
                var total_por_cobrar_medianas = json.cantidades_probetas_por_cobrar_medianas;
                var total_por_cobrar_grandes = json.cantidades_probetas_por_cobrar_grandes;

                var total_por_ensayar_chicas = json.cantidades_probetas_por_ensayar_chicas;
                var total_por_ensayar_medianas = json.cantidades_probetas_por_ensayar_medianas;
                var total_por_ensayar_grandes = json.cantidades_probetas_por_ensayar_grandes;
*/
               // console.log("  total_facturadas_chicas="+total_facturadas_chicas+" total_facturadas_medianas="+total_facturadas_medianas+" total_facturadas_grandes="+total_facturadas_grandes )

                $("#cantidades-probetas-retiradas-chicas").text( total_retiradas_chicas );
                $("#cantidades-probetas-retiradas-medianas").text( total_retiradas_medianas );
                $("#cantidades-probetas-retiradas-grandes").text( total_retiradas_grandes);

                $("#cantidades-probetas-ensayadas-chicas").text( total_ensayadas_chicas );
                $("#cantidades-probetas-ensayadas-medianas").text( total_ensayadas_medianas );
                $("#cantidades-probetas-ensayadas-grandes").text( total_ensayadas_grandes );

                $("#cantidades-probetas-facturadas-chicas").text( total_facturadas_chicas.formatMoney(2, ',', '.') );
                $("#cantidades-probetas-facturadas-medianas").text( total_facturadas_medianas.formatMoney(2, ',', '.') );
                $("#cantidades-probetas-facturadas-grandes").text( total_facturadas_grandes.formatMoney(2, ',', '.') );
/*
                $("#cantidades-probetas-cobrar-chicas").text( total_por_cobrar_chicas.formatMoney(2, ',', '.') );
                $("#cantidades-probetas-cobrar-medianas").text( total_por_cobrar_medianas.formatMoney(2, ',', '.') );
                $("#cantidades-probetas-cobrar-grandes").text( total_por_cobrar_grandes.formatMoney(2, ',', '.') );

                $("#cantidades-probetas-ensayar-chicas").text( total_por_ensayar_chicas.formatMoney(2, ',', '.') );
                $("#cantidades-probetas-ensayar-medianas").text( total_por_ensayar_medianas.formatMoney(2, ',', '.') );
                $("#cantidades-probetas-ensayar-grandes").text( total_por_ensayar_grandes.formatMoney(2, ',', '.') );
*/
                $("#cantidades-probetas-retiradas").text( (total_retiradas_chicas + total_retiradas_medianas + total_retiradas_grandes) );
                $("#cantidades-probetas-ensayadas").text( (total_ensayadas_chicas + total_ensayadas_medianas + total_ensayadas_grandes));
                $("#cantidades-probetas-facturadas").text( (total_facturadas_chicas + total_facturadas_medianas + total_facturadas_grandes).formatMoney(2, ',', '.') );
                //$("#cantidades-probetas-cobrar").text( (total_por_cobrar_chicas + total_por_cobrar_medianas + total_por_cobrar_grandes).formatMoney(2, ',', '.') );
                //$("#cantidades-probetas-ensayar").text( (total_por_ensayar_chicas + total_por_ensayar_medianas + total_por_ensayar_grandes).formatMoney(2, ',', '.') );


            return json.data;
            }    
        },
        columns:
        [
            { data: 'numero_remision', name: 'numero_remision' },
            { data: 'obra.cliente.razon_social' , name: 'obra.cliente.razon_social', orderable: false, searchable: false},
            { data: 'obra.nombre', name: 'obra.nombre'},
            { data: 'fecha_remision', name: 'fecha_remision' },
            { data: 'retiradas', name: 'retiradas', orderable: false, searchable: false},
            { data: 'ensayadas', name: 'ensayadas', orderable: false, searchable: false},
            { data: 'facturadas', name: 'facturadas', orderable: false, searchable: false},
            {
                "className":      'details-control text-center',
                "orderable":      false,
                "searchable":     false,
                "data":           null,
                "defaultContent": '<button class="btn btn-xs btn-primary"><b>DETALLES</b></button>'
            },
        ],
        language: 
        {
            processing:     "Procesando...",
            search:         "Buscar",
            lengthMenu:     "Mostrar _MENU_ Elementos",
            info:           "Mostrando de _START_ al _END_ registros de un total de _TOTAL_ registros",
            infoFiltered:   ".",
            infoPostFix:    "",
            loadingRecords: "Cargando Registros...",
            zeroRecords:    "No existen registros disponibles",
            emptyTable:     "No existen registros disponibles",
            paginate: 
            {
                first:      "Primera",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Ultima"
            }
        }
    }); //end datatale
</script>