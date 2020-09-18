<script src="{{ asset('js/jquery.number.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function()   
    { 
        var INPUT_TOTAL_IVA_5 = $(".iva_5_total");
        var INPUT_TOTAL_IVA_10 = $(".iva_10_total");
        var INPUT_TOTAL_IVA = $(".iva_total");
        var INPUT_MONTO_TOTAL = $(".monto_total");

        var CLASS_CANTIDAD = '.cantidad';
        var CLASS_PRECIO_UNITARIO = '.precio_unitario';
        var CLASS_SUB_TOTAL = '.sub_total';
        var INPUT_CANTIDAD = $(CLASS_CANTIDAD);
        var INPUT_PRECIO_UNITARIO = $(CLASS_PRECIO_UNITARIO);
        var INPUT_SUB_TOTAL = $(CLASS_SUB_TOTAL);


        INPUT_CANTIDAD.number(true, 2, ',', '');
        INPUT_PRECIO_UNITARIO.number(true, 0, '', '.');
        INPUT_SUB_TOTAL.number(true, 0, '', '.').attr('tabIndex', "-1");
        INPUT_TOTAL_IVA_5.number(true, 0, '', '.');
        INPUT_TOTAL_IVA_10.number(true, 0, '', '.');
        INPUT_TOTAL_IVA.number(true, 0, '', '.');
        INPUT_MONTO_TOTAL.number(true, 0, '', '.');
        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck(
        {
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
          $(window).keydown(function(event)
        {   
            //PRESS ENTER
            var ENTER_KEY = 13;
            if(event.keyCode == ENTER_KEY) 
            {
              event.preventDefault();
            }
        });
       });    
</script>
