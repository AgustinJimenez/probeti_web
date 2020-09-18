<script type="text/javascript">
	INPUT_RAZON_SOCIAL.autocomplete(
    {
        source: '{!! route('admin.clientes.clientes.search_cliente') !!}',
        minLength: 1,
        select: function(event, ui)
        {
            var cliente = ui.item;
            INPUT_CLIENTE_ID.val( cliente.id );
            INPUT_RUC.val( cliente.ruc );
            INPUT_DIRECCION.val( cliente.direccion);
            INPUT_TELEFONO.val( cliente.telefono );
            $("#cliente_seleccionado").text(cliente.value+" seleccionado");
        }
    });
        
        $(window).keydown(function(event)
        {   
            //PRESS ENTER
            var ENTER_KEY = 13;
            if(event.keyCode == ENTER_KEY) 
            {
              event.preventDefault();
              generar_nueva_fila();
            }
        });

         $("body").on("keyup", CLASS_PRECIO_UNITARIO+", "+CLASS_CANTIDAD, function()
        {
            calculate_all();
        });
         $("body").on("keyup", CLASS_REMISION_NOMBRE, function(event)
        {
        	if( !row_is_tipo_probeta( $(this) ) )
        		event.preventDefault();

        });
        $("body").on("change", CLASS_IVA, function()
        {
            calculate_all();
        });
        $("body").on("change", CLASS_TIPO, function()
        {
            dd("cambio tipo");
            bloquear_tipo_probeta( $(this) );
        });


        BUTTON_AGREGAR.click(function()
        {
            generar_nueva_fila();
        });

        $("body").on("click", CLASS_ELIMINAR, function()
        {
            button_eliminar_click($(this));
        });
        $("#formulario").on('submit', function(event)
        {
            validar(event, $(this));
        });
</script>