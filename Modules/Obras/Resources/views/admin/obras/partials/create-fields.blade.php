<div class="box-body">
    {!! Form::normalInput('nombre', 'Nombre', $errors) !!}
    {!! Form::normalInput('ubicacion', 'Ubicacion', $errors) !!}
    {!! Form::normalInput('residente', 'Residente', $errors) !!}
    {!! Form::normalInput('diametro', 'Diametro (cm)', $errors) !!}
    {!! Form::normalInput('etiqueta', 'Etiqueta', $errors) !!}
    {!! Form::normalInput('observacion','Observacion', $errors) !!}
    {!! Form::normalCheckbox('activo','Activo', $errors) !!}
    {!! Form::normalSelect('cliente_id', 'Cliente', $errors, $clientes) !!}
    
</div>
<script type="text/javascript">
	
$( document ).ready(function() 
{
    $("#diametro").val(15);

});

</script>