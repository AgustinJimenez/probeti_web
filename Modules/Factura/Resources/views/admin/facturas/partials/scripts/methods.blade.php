<script type="text/javascript">
    function button_eliminar_click(button)
    {
        eliminar_fila(button);
        calculate_all();
    }
    function asignar_nuevos_names(nueva_fila)
    {
        var old_name = 0;
        var tr_id = 0;
        var new_name = 0;
        nueva_fila.find("input:text,input:hidden, select").each(function()
        {
            old_name = $(this).attr('name');
            new_name = old_name.replace(/[0]/g, ''+X+'');
            $(this).attr('name', new_name);
        });
        return nueva_fila;
    }
    function generar_nueva_fila()
    {
        var nueva_fila = TR_FILA_0.clone();
        nueva_fila = limpiar_inputs(nueva_fila);
        nueva_fila.attr('fila-id', X).find(".detalle_id").remove();
        nueva_fila.find('.eliminar_detalle').remove();
        nueva_fila = asignar_nuevos_names(nueva_fila);
        nueva_fila = asignar_nuevos_class(nueva_fila);
        TABLA_FACTURA.append(nueva_fila);
        instanciar_detalles_number();
        remision_nombre_autocomplete_instance();
        focus_on_last_descripcion_on_table();
    }

    function row_is_tipo_probeta(selector)
    {
        return selector.closest('tr').find(CLASS_TIPO).val() == "probetas";
    }
    
    function eliminar_fila(selected)
    {
        var cantidad_rows = 0;
        $(CLASS_FILA).each(function()
        {   
            if( $(this).is(":visible") )
                cantidad_rows++;
        });
        var detalle_id = parseInt(selected.closest('td').closest('tr').find('.detalle_id').val());
        if(detalle_id)
        {
            if(  cantidad_rows > 1)
                selected.closest('td').closest('tr').hide().find(".eliminar_detalle").val(1);
        }
        else
            if(  cantidad_rows > 1)
                selected.closest('tr').remove();
    }
    function asignar_nuevos_class(object)
    {
        CLASS_FILA_0 = remove_first_dot_character(CLASS_FILA_0);
        object.removeClass(CLASS_FILA_0).addClass("fila-"+X);
        ARRAY_ELEMENTS_CLASS.forEach(function(item, indice, array)
        {
            var item_class = item;
            item = remove_first_dot_character(item);
            var old_class = item+"-0";
            var new_class = item+"-"+X;
            object.find(item_class).removeClass(old_class).addClass(new_class);
        });
        X++;
        return object;
    }
    function remove_first_dot_character(item)
    {
        while(item.charAt(0) === '.')
             item = item.substr(1);
         return item;
    }
    function limpiar_inputs(object)
    {
        object.find("input").val('');
        object.find(".success").text(" ");
        object.find(CLASS_TIPO_PROBETA+" option:eq(0)").text("Chica");
        object.find(CLASS_TIPO_PROBETA+" option:eq(1)").text("Mediana");
        object.find(CLASS_TIPO_PROBETA+" option:eq(2)").text("Grande");
        return object;
    }
    function precio_unitario_keyup()
    {
        calculate_all();
    }
    function cantidad_keyup()
    {
        calculate_all();
    }
    function instanciar_detalles_number()
    {
        $(CLASS_CANTIDAD).number(true, 2, ',', '');
        $(CLASS_PRECIO_UNITARIO).number(true, 0, '', '.');
    }
    function bloquear_tipo_probeta( select_tipo_changed )
    {
        if( select_tipo_changed.val() == "otros" )
        {
            select_tipo_changed.closest("tr").find(CLASS_TIPO_PROBETA).attr("readonly", true).hide();
            select_tipo_changed.closest("tr").find( CLASS_REMISION_ID ).val("");
            select_tipo_changed.closest("tr").find( CLASS_REMISION_NOMBRE ).val("").autocomplete("destroy");
            select_tipo_changed.closest("tr").find( CLASS_REMISION_SELECCIONADA ).text("");
            select_tipo_changed.closest("tr").find(CLASS_TIPO_PROBETA+" option:eq(0)").text("Chica");
            select_tipo_changed.closest("tr").find(CLASS_TIPO_PROBETA+" option:eq(1)").text("Mediana");
            select_tipo_changed.closest("tr").find(CLASS_TIPO_PROBETA+" option:eq(2)").text("Grande");
        }
        else
        {
            select_tipo_changed.closest("tr").find(CLASS_TIPO_PROBETA).attr("readonly", false).show();
            select_tipo_changed.closest("tr").find( CLASS_REMISION_NOMBRE ).val("")
            remision_nombre_autocomplete_instance( get_row_id( select_tipo_changed ) );
        }
    }
    function get_row_id(selector)
    {
        return parseInt( selector.closest('tr').attr('fila-id') );
    }
    function remision_nombre_autocomplete_instance(row_id = 0)
    {
        $(CLASS_REMISION_NOMBRE/*+"-"+row_id*/).autocomplete(
        {

           source: function (request, response)
           {
               $.ajax
               ({
                    url: '{!! route('admin.remision.remision.search_remision') !!}',
                    dataType: "json",
                    data: 
                    {
                        term: request.term,
                        cliente_id: get_cliente_id()
                    },
                    success: function( data ) 
                    {
                        response(data);
                    }
                });
           },
           minLength: 1,
           select: function (event, ui)
           {
                $(this).closest("td").find(".success").text(ui.item.value+" seleccionado");
                set_remision_datas(ui.item, $(this).closest('td').closest('tr'));
           }
        });
    }
    function get_cliente_id()
    {
        return INPUT_CLIENTE_ID.val();
    }
    function set_remision_datas(datas, tr)
    {
        var chicas = datas.cantidades_probetas_chicas;
        var medianas = datas.cantidades_probetas_medianas;
        var grandes = datas.cantidades_probetas_grandes;
        set_remision_id_chicas_medianas_grandes_attributes(tr, chicas, medianas, grandes);
        set_tipo_probeta_cantidad_chica_mediana_grande(tr, chicas, medianas, grandes);
        tr.find(CLASS_REMISION_ID).val(datas.id);
    }
    function set_tipo_probeta_cantidad_chica_mediana_grande(tr, chicas, medianas, grandes)
    {
        tr.find(CLASS_TIPO_PROBETA+' option[value="chica"]').text("Chica -restante: ("+chicas+")");
        tr.find(CLASS_TIPO_PROBETA+' option[value="mediana"]').text("Mediana -restante: ("+medianas+")");
        tr.find(CLASS_TIPO_PROBETA+' option[value="grande"]').text("Grande -restante: ("+grandes+")");
    }
    function set_remision_id_chicas_medianas_grandes_attributes(tr, chicas, medianas, grandes)
    {
        tr.find(CLASS_REMISION_ID).attr('cantidad-probetas-chicas', chicas).attr('cantidad-probetas-medianas', medianas).attr('cantidad-probetas-grandes', grandes);
    }
    function calcular_cantidad_probetas_sobrantes()
    {
        var tr = 0;
        $( ID_TABLA_FACTURA+" tr" ).each(function()
        {
            tr = $(this);
            var cantidad_escrita = tr.find(CLASS_CANTIDAD).val();
            var cantidad_grandes = tr.find(CLASS_REMISION_ID).attr('cantidad-probetas-grandes');
            var cantidad_medianas = tr.find(CLASS_REMISION_ID).attr('cantidad-probetas-medianas');
            var cantidad_chicas = tr.find(CLASS_REMISION_ID).attr('cantidad-probetas-chicas');
            var tipo_probeta_seleccionado = tr.find(CLASS_TIPO_PROBETA+" option:selected").val();

            if(cantidad_escrita == '')
                cantidad_escrita = 0;

            if(tipo_probeta_seleccionado == "chica")
            {
                //dd("cantidad_chicas="+cantidad_chicas+" cantidad_escrita="+cantidad_escrita);
                var cantidas_seleccionada_restante = parseInt(cantidad_chicas) - parseInt(remove_dots(cantidad_escrita));

                if(cantidas_seleccionada_restante < 0)
                {
                    tr.find(CLASS_CANTIDAD).val( parseInt(tr.find(CLASS_CANTIDAD).val()) +  cantidas_seleccionada_restante);
                    cantidas_seleccionada_restante = 0;
                }
                tr.find(CLASS_TIPO_PROBETA+" option:selected").text("Chica -restante: "+cantidas_seleccionada_restante);
            }
            else if(tipo_probeta_seleccionado == "mediana")
            {
                //dd("cantidad_medianas="+cantidad_medianas+" cantidad_escrita="+cantidad_escrita);
                var cantidas_seleccionada_restante = parseInt(cantidad_medianas) - parseInt(remove_dots(cantidad_escrita));
                if(cantidas_seleccionada_restante < 0)
                {
                    tr.find(CLASS_CANTIDAD).val( parseInt(tr.find(CLASS_CANTIDAD).val()) +  cantidas_seleccionada_restante);
                    cantidas_seleccionada_restante = 0;
                }
                tr.find(CLASS_TIPO_PROBETA+" option:selected").text("Mediana -restante: "+cantidas_seleccionada_restante);
            }
            else
            {
                //dd("cantidad_grandes="+cantidad_grandes+" cantidad_escrita="+cantidad_escrita);
                var cantidas_seleccionada_restante = parseInt(cantidad_grandes) - parseInt(cantidad_escrita);
                if(cantidas_seleccionada_restante < 0)
                {
                    tr.find(CLASS_CANTIDAD).val( parseInt(tr.find(CLASS_CANTIDAD).val()) +  cantidas_seleccionada_restante);
                    cantidas_seleccionada_restante = 0;
                }
                tr.find(CLASS_TIPO_PROBETA+" option:selected").text("Grande -restante: "+cantidas_seleccionada_restante);
            }
        });
        

    }
    function remove_dots(variable)
    {
        if(variable == '')
            return 0;
        return variable.replace(/\./g,'');
    }
    function focus_on_last_descripcion_on_table()
    {
        $(ID_TABLA_FACTURA+" tbody tr:last").find(CLASS_REMISION_NOMBRE).focus();
    }
    function replace_this(target, search, replacement)
    {
        return target.split(search).join(replacement);
    };
    function dd(data)
    {
        if('{{$DEBUG}}' == "text")
            return console.log(data);
        else
        {

        }
    }
    function calculate_all()
    {
        var total = 0;
        var total_sin_iva = 0;
        var total_iva_5 = 0;
        var total_iva_10 = 0;
        var total_ivas = 0;

        $(CLASS_FILA).each(function() 
        {
            var tr = $(this).closest('tr');
            var cantidad = 0;
            var precio_unitario = 0;
            var sub_total = 0;
            var iva = 0;
            var sub_total_iva = 0;
            if ( tr.is(':visible') )
            {
                cantidad = tr.find(CLASS_CANTIDAD).val() ;
                if(cantidad=='')
                    cantidad=0;
                precio_unitario = tr.find(CLASS_PRECIO_UNITARIO).val() ;
                    if(precio_unitario=='')
                        precio_unitario=0;
                iva = tr.find(CLASS_IVA).val() ;
            }
            sub_total = cantidad*precio_unitario;
            if(iva!=0)
                iva_sub_total = parseInt(sub_total/iva);
            else
                iva_sub_total = 0;
            if(iva==11)
            {
                total_iva_10 += iva_sub_total;
            }
            else if(iva==21)
            {
                total_iva_5 += iva_sub_total
            }
            total_ivas += iva_sub_total
            sub_total_mas_iva = sub_total/*+iva_sub_total*/;
            tr.find(CLASS_SUB_TOTAL).val( $.number( sub_total, 0, '', '.') );
            total_sin_iva += sub_total;
            total += sub_total_mas_iva;
            //console.log('cantidad= '+cantidad+' iva= '+iva+' precio unitario= '+precio_unitario+' subtotal= '+sub_total+' iva de subtotal='+iva_sub_total+' subtotal+iva= '+sub_total_mas_iva+' total acumulado= '+total);
        });
        //console.log('total='+total);
        // $("#monto_sub_total").val( $.number( parseInt(total_sin_iva) , 0, '', '.') );
        INPUT_MONTO_TOTAL.val( $.number( parseInt(total) , 0, '', '.') );
        INPUT_MONTO_TOTAL_LETRAS.val(NumeroALetras(total)); 
        INPUT_TOTAL_IVA_5.val( $.number( total_iva_5 , 0, '', '.') );
        INPUT_TOTAL_IVA_10.val( $.number( total_iva_10 , 0, '', '.') );
        //INPUT_TOTAL_IVA.val( total );
        //$("#total_pagar").val( $("#monto_total").val() );
        INPUT_TOTAL_IVA.val( $.number( parseInt(total_ivas) , 0, '', '.') );
        fix_remision_autocomplete();
        //calcular_cantidad_probetas_sobrantes();
    }

    function fix_remision_autocomplete()
    {
        $(CLASS_TIPO).each(function()
        {
            if( $(this).val() == "otros")
                $(this).closest('tr').find( CLASS_REMISION_NOMBRE ).autocomplete("destroy");

        });
    }
    
    
    function show_alert_modal(mensaje = "sin mensaje")
    {
        $("#alert-modal-message").html(mensaje);
        $("#modal-alert-confirmation").modal();
    }
    function validar(event, formulario)
    {
        var mensaje = '';
        var remision_id = 0;
        var fila_remision = 0;
        var cliente_id = INPUT_CLIENTE_ID.val();
        var is_valid = true;
        if(!cliente_id)
        {
            dd("error detected, cliente_id="+cliente_id);
            mensaje += "-No se selecciono ningun cliente <br>";
            is_valid = false;
        }

        $(CLASS_REMISION_ID).each(function()
        {
            remision_id = $(this).val();
            fila_remision = parseInt( $(this).closest('td').closest('tr').attr("fila-id") ) + 1;
            if( row_is_tipo_probeta( $(this) ) && remision_id == '' )
            {
                dd("error detected, remision_id="+remision_id+" fila_remision="+fila_remision);
                mensaje += "-No se selecciono ninguna remision en la fila "+fila_remision+" <br>";
                is_valid = false;
            }
        });

        if(!is_valid)
        {
            show_alert_modal(mensaje);
            event.preventDefault();
        }
    }
</script>