<style type="text/css">
	.inner-addon 
	{
		position: relative;
	}
	.inner-addon .glyphicon 
	{
		color: black ;
		position: absolute;
		padding: 10px;
		cursor: pointer;
	}
	.left-addon .glyphicon  { left:  0px;}
	.right-addon .glyphicon { right: 0px;}
	.left-addon input  { padding-left:  30px; }
	.right-addon input { padding-right: 30px; }
</style>
<div class="col-md-2">
	{!! Form::label('for_fecha_inicio', 'Fecha Inicio', array('class' => 'mylabel')) !!}
	<div class="inner-addon right-addon">
        {!! Form::text('fecha_inicio', old('fecha_inicio'), array('class' => 'form-control input-md fecha_inicio ', 'placeholder' => "Fecha Inicio" , 'id' => 'fecha_inicio')) !!}
		<i class="glyphicon fa fa-trash-o fa-5" style="" id="borrar_fecha_inicio"></i>
	</div>
</div>
<div class="col-md-2">
    {!! Form::label('for_fecha_fin', 'Fecha Fin', array('class' => 'mylabel')) !!}
	<div class="inner-addon right-addon">
        {!! Form::text('fecha_fin', old('fecha_fin'), array('class' => 'form-control input-md fecha_fin ', 'placeholder' => "Fecha Inicio" , 'id' => 'fecha_fin')) !!}
		<i class="glyphicon fa fa-trash-o fa-5" style="" id="borrar_fecha_fin"></i>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('#fecha_inicio').click(function()
        {
            $("#search-form").submit();
        });

        $('#fecha_fin').click(function()
        {
            $("#search-form").submit();
        });

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
            var fecha_inicio = $(this).val();

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
	});
</script>