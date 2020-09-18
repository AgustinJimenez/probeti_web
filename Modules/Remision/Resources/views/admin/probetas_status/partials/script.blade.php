<script type="text/javascript">
	log('here');

	$.fn.dataTable.ext.errMode = 'none';
/*
    $('#fecha_inicio').datetimepicker(
    {
        format: 'DD/MM/YYYY',
        //format: 'YYYY-MM-DD',
        locale: 'es'
    });

    $('#fecha_fin').datetimepicker(
    {
        format: 'DD/MM/YYYY',
        //format: 'YYYY-MM-DD',
        locale: 'es'
    });

    $("#fecha_inicio").on("dp.change", function (e) 
    {
        $("#search-form").submit();
    });

    $("#fecha_fin").on("dp.change", function (e) 
    {
        $("#search-form").submit();
    });

    $('#borrar_fecha_inicio').click(function()
    {
        $('#fecha_inicio').val('');
        $("#search-form").submit();
    });

    $('#borrar_fecha_fin').click(function()
    {
        $('#fecha_fin').val('');
        $("#search-form").submit();
    });
 */
/*
    $("#razon_social").on("keyup",function()
    {
        $("#search-form").submit();
    });

    $("#nro_factura").on("keyup",function()
    {
        $("#search-form").submit();
    });

    $("#anulado").on("change",function()
    {
        $("#search-form").submit();
    });
*/
    $('#search-form').on('submit', function(e) 
    {
        table.draw();
        e.preventDefault();
    });
    
    var table = $('.data-table').removeAttr('width').DataTable(
    {
    	/*
        dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
        "<'row'<'col-xs-12't>>"+
        "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
        */
        "deferRender": true,
        fixedColumns: true,
        scrollY:        "auto",
        scrollX:        true,
        scrollCollapse: true,
        processing: true,
        serverSide: true,
        "paginate": true,
        "autoWidth": false,
        "iDisplayLength": 10,
        /*
        "columnDefs": 
                [
                    { "width": "5%", "targets": 0 },
                    { "width": "55%", "targets": 1 },
                    { "width": "15%", "targets": 2 },
                    { "width": "10%", "targets": 3 },
                    { "width": "15%", "targets": 4 },
                ],
                */
        "order": [[ 0, "desc" ]],
        "lengthChange": true,
        "filter": true,
        "sort": true,
        "info": true,
        ajax: 
        {
            url: '{!! route('admin.remision.remision.probetas_status_ajax') !!}',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            type: "POST",
            data: function (e) 
            {
                //e.fecha_inicio = $('#fecha_inicio').val();
            }
        },
        columns: 
        [
            { data: 'id', name: 'id' },
            { data: 'numero_probeta', name: 'numero_probeta' },
            { data: 'fecha_moldeo', name: 'fecha_moldeo' },
            { data: 'dias', name: 'dias' },
            { data: 'fck', name: 'fck' },
            { data: 'remision_id', name: 'remision_id' },
            { data: 'created_at', name: 'created_at' },
            { data: 'fecha_rotura', name: 'fecha_rotura' },
            { data: 'carga_aplicada', name: 'carga_aplicada' },
            { data: 'resistencia', name: 'resistencia' },
            { data: 'resistencia_calculada', name: 'resistencia_calculada' },
            { data: 'diff_resistencias', name: 'diff_resistencias' },
            { data: 'porcentaje', name: 'porcentaje' },
            { data: 'porcentaje_calculado', name: 'porcentaje_calculado' },
            { data: 'diff_porcentajes', name: 'diff_porcentajes' },
            { data: 'diametro', name: 'diametro' },
            { data: 'altura', name: 'altura' },
            { data: 'peso', name: 'peso' },
            { data: 'peso_especifico', name: 'peso_especifico' },
            { data: 'peso_especifico_calculado', name: 'peso_especifico_calculado' },
            { data: 'diff_pesos_especificos', name: 'diff_pesos_especificos' },
           // { data: 'acciones', name: 'acciones', orderable: false, searchable: false}
        ], 

         language: {
            processing:     "Procesando...",
            search:         "Buscar",
            lengthMenu:     "Mostrar _MENU_ Elementos",
            info:           "Mostrando de _START_ a _END_ registros de un total de _TOTAL_ registros",
            infoEmpty:      "Mostrando 0 registros",
            infoFiltered:   ".",
            infoPostFix:    "",
            loadingRecords: "Cargando Registros...",
            zeroRecords:    "No existen registros disponibles",
            emptyTable:     "No existen registros disponibles",
            paginate: {
                first:      "Primera",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Ultima"
            }
        }
    });    











function log(data)
{
	return console.log(data);
}
</script>