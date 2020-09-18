<script type="text/javascript">
	
  $("#obras, #clientes, #fecha_desde, #fecha_hasta").on("change" ,function()
  {
    table.draw();
  }); 
  $(".glyphicon-trash").click(function()
  {
    $(this).closest('table').find('input').val('');
    table.draw();
  });
  
  // Add event listener for opening and closing details
  $('body').on('click', 'td.details-control', function () 
  {
      dd("row details");
      var tr = $(this).closest('tr');
      var row = table.row( tr );

      if ( row.child.isShown() ) 
      {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
      }
      else 
      {
        // Open this row
        row.child( template(row.data()) ).show();
        tr.addClass('shown');
      }
  });

</script>