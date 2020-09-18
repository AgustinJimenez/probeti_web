<script type="text/javascript">
	var INPUT_FECHA = $(".fecha");
        var INPUT_DIRECCION = $(".direccion");
        var INPUT_TELEFONO = $(".telefono");
        var INPUT_TOTAL_IVA_5 = $(".iva_5_total");
        var INPUT_TOTAL_IVA_10 = $(".iva_10_total");
        var INPUT_TOTAL_IVA = $(".iva_total");
        var INPUT_MONTO_TOTAL = $(".monto_total");
        var INPUT_MONTO_TOTAL_LETRAS = $(".monto_total_letras");
        var INPUT_RAZON_SOCIAL = $( ".razon_social" );
        var INPUT_CLIENTE_ID = $(".cliente_id");
        var INPUT_RUC = $(".ruc");
        var BUTTON_AGREGAR = $(".agregar");

        var CLASS_TIPO = ".tipo"
        var CLASS_REMISION_NOMBRE = '.remision_nombre';    
        var CLASS_REMISION_ID = '.remision_id';  
        var CLASS_REMISION_SELECCIONADA = ".success"
        var CLASS_TIPO_PROBETA = ".tipo_probeta";
        var CLASS_CANTIDAD = '.cantidad';
        var CLASS_IVA = ".iva"
        var CLASS_PRECIO_UNITARIO = '.precio_unitario';
        var CLASS_SUB_TOTAL = '.sub_total';
        var CLASS_ELIMINAR = ".eliminar";
        var INPUT_REMISION_NOMBRE = $(CLASS_REMISION_NOMBRE);    
        var INPUT_REMISION_ID = $(CLASS_REMISION_ID);  
        var SELECT_TIPO_PROBETA = $(CLASS_TIPO_PROBETA);
        var INPUT_CANTIDAD = $(CLASS_CANTIDAD);
        var SELECT_IVA = $(CLASS_IVA);
        var INPUT_PRECIO_UNITARIO = $(CLASS_PRECIO_UNITARIO);
        var INPUT_SUB_TOTAL = $(CLASS_SUB_TOTAL);
        var BUTTON_ELIMINAR = $(CLASS_ELIMINAR);
        var ARRAY_ELEMENTS_CLASS = [
                                        CLASS_TIPO,
                                        CLASS_REMISION_NOMBRE, 
                                        CLASS_REMISION_ID, 
                                        CLASS_TIPO_PROBETA, 
                                        CLASS_CANTIDAD, 
                                        CLASS_IVA, 
                                        CLASS_PRECIO_UNITARIO, 
                                        CLASS_SUB_TOTAL, 
                                        CLASS_ELIMINAR
                                    ];

        var ID_TABLA_FACTURA = "#tabla_factura";
        var TABLA_FACTURA = $(ID_TABLA_FACTURA);
        var CLASS_FILA = ".fila";
        var TR_FILA = $(CLASS_FILA);
        var CLASS_FILA_0 = ".fila-0";
        var TR_FILA_0 = $(CLASS_FILA_0);

        var count_rows = $(ID_TABLA_FACTURA+" >tbody >tr").length;
        X = count_rows;  
        // ==================================================
        // ==================================================
        //	INSTANCIACION
        INPUT_CANTIDAD.number(true, 2, ',', '');
        INPUT_PRECIO_UNITARIO.number(true, 0, '', '.');
        INPUT_SUB_TOTAL.number(true, 0, '', '.').attr('tabIndex', "-1");
        INPUT_TOTAL_IVA_5.number(true, 0, '', '.');
        INPUT_TOTAL_IVA_10.number(true, 0, '', '.');
        INPUT_TOTAL_IVA.number(true, 0, '', '.');
        INPUT_MONTO_TOTAL.number(true, 0, '', '.');
        INPUT_FECHA.datepicker($.datepicker.regional[ "es" ]);
        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck(
        {
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
</script>