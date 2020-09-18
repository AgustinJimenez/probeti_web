<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura Numero xxx</title>
    <link rel="stylesheet" type="text/css" href="" >
    <style type="text/css">
      
      table
      {
        width: 100%;
        border-collapse:separate;
        /*border:solid black 1px;*/
        border-radius:20px;
        -moz-border-radius:6px;
      }
      td, th 
      {
        /*border-left:solid black 1px;*/
        /*border-top:solid black 1px;*/
        padding-bottom: -0.9em;
        padding-top: -0.9em;
      }
      thead
      {
        /*border-bottom: solid;*/
      }

      th 
      {
        border-top: none;
      }

      td:first-child, th:first-child 
      {
        border-left: none;
      }
   
      
/*-------------------------------*/
  .header
  {
    float: left; display: inline-block; border: solid 1.5px;
  }
  .header-content
  {
    margin:5px;
  }
  p {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 0.8em;
    font-weight: none;
    color: red;
  }
  .factura-cabecera
  {
    width: 100%; 
    height: 27px;
  }
  .centrado
  {
    text-align: center;
  }
  html{margin:40px 50px}


  
/*-------------------------------*/

    </style>
    <?php $space0 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'?>
</head>
  <body style="margin: 0px;background-color: rd; padding-bottom:0px;/* border: solid 1px red;*/">
    <?php 
        for($x = -20; $x <110; $x++)
        {
          echo '<div style="position:absolute; border:solid 1px blue; width:110%; height:1%; margin-top:'.$x.'%; font-size: 5pts;">'.$x.'</div>';

          echo '<div style="position:absolute; border:solid 1px blue; width:2%; height:110%; margin-left:'.$x.'%; font-size: 5pts;">'.$x.'</div>';

          $x++;
        }

    ?>
  <div style="background-color: blu;width: 700px;">
  <?php 
    $cantidad_de_facturas = 3;
  ?>
  @for($x = 0; $x<$cantidad_de_facturas; $x++)
    <div style="margin-top: 20px;margin-left: -35px">
      <div id="nro_factura" style="position: absolute; margin-left: 575px; margin-top: -12px;"><p>-{{ $factura->id }}</p></div>

      <div id="fecha_emision" style="position: absolute; margin-left: 65px; margin-top: 30px;"><p>{{ $hoy }}</p></div>
      <div id="ruc" style="position: absolute; margin-left: 295px; margin-top: 30px;"><p>{{ $cliente->ruc }}</p></div>
      <div id="contado" style="position: absolute; margin-left: 596px; margin-top: 27px;"><p>@if($factura->forma_de_pago == 'contado')x @else @endif</p></div>
      <div id="contado" style="position: absolute; margin-left: 668px; margin-top: 27px;"><p>@if($factura->forma_de_pago == 'credito')x @else @endif</p></div>

      <div id="razon_social" style="position: absolute; margin-left: 93px; margin-top: 50px;"><p>{{ $factura->razon_social }}</p></div>

      <div id="direccion" style="position: absolute; margin-left: 30px; margin-top: 74px;"><p>{{ $factura->direccion }}</p></div>
      <div id="telefono" style="position: absolute; margin-left: 495px; margin-top: 74px;"><p>{{ $factura->telefono }}</p></div>

      <div style="margin-left: -25px; margin-top: 135px; height: 103px;">
        <table  style="" class="" cellspacing="0.5" >

          
          <?php 
            $total_iva_0 = 0;
            $total_iva_5 = 0;
            $total_iva_10 = 0;
          ?>
          <tbody style="margin-left: -35px;height: 150px;">
          @foreach($detalleFacturas as $detalle)
            <?php 
              $cantidad = $detalle->cantidad;
              $precio_unitario = $detalle->precio_unitario;
              $iva = $detalle->iva;
              if($iva=='0')$iva=1;
              $iva = ($cantidad*$precio_unitario)/$iva;

            ?>
            <tr>
              <td class="centrado" style="background-color: orang; width: 50px;"><p>{{ $cantidad }}</p></td>
              <td class="centrado"  style="background-color: rd;width: 350px;"><p>{{ $detalle->descripcion }}</p></td>
              <td class="centrado"  style = " background-color: blu;padding-left: 0px;"><p  style="margin-right: -25px;">{{ number_format( $precio_unitario , 0, ',', '.') }}</p></td>
              <td class="centrado"  style="background-color: orang; width: 75px;"><p style="">@if($detalle->iva=='0') {{ /*number_format( $iva , 0, ',', '.')*/0}} <?php $total_iva_0 += $iva;?>@else  @endif</p></td>
              <td class="centrado"  style="background-color: gren; width: 75px;"><p  style="margin-right: -35px;">@if($detalle->iva=='21') {{ number_format( $iva , 0, ',', '.')}}<?php $total_iva_5 += $iva;?>@else  @endif</p></td>
              <td class="centrado"  style="background-color: blu; width: 75px;"><p style="margin-right: -55px;">@if($detalle->iva=='11') {{ number_format( $iva , 0, ',', '.')}}<?php $total_iva_10 += $iva;?>@else  @endif</p></td>
            </tr>
            
          @endforeach
            
          </tbody>  
          
          
        </table>

        
      </div>
      <div style="position:absolute;margin-top: 37px; margin-right: 0px;">

          <div id="total_excenta" style="position: absolute; margin-left: 505px; margin-top: -5px;"><p>0</p></div>
          <div id="total_iva_5" style="position: absolute; margin-left: 583px; margin-top: -5px;"><p>{{ number_format( $total_iva_5, 0, ',', '.') }}</p></div>
          <div id="total_iva_10" style="position: absolute; margin-left: 670px; margin-top: -5px;"><p>{{ number_format( $total_iva_10, 0, ',', '.') }}</p></div>

          <div id="total_a_pagar_letras" style="position: absolute; margin-left: 95px; margin-top: 17px;"><p>GUARANÍES {{ str_replace('GUARANÍES', '', $factura->monto_total_letras) }}</p></div>
          <div id="total_a_pagar" style="position: absolute; margin-left: 660px; margin-top: 17px;"><p>{{ number_format( $factura->monto_total, 0, ',', '.') }}</p></div>

          <div id="liquidacion_iva_5" style="position: absolute; margin-left: 120px; margin-top: 42px;"><p>{{ number_format( $factura->monto_total/21, 0, ',', '.')  }}</p></div>
          <div id="liquidacion_iva_10" style="position: absolute; margin-left: 270px; margin-top: 42px;"><p>{{ number_format( $factura->monto_total/11, 0, ',', '.')  }}</p></div>
          <div id="liquidacion_iva" style="position: absolute; margin-left: 470px; margin-top: 42px;"><p>{{ number_format( ($factura->monto_total/21)+($factura->monto_total/11), 0, ',', '.')  }}</p></div>
        </div>

    </div>
    
    <div style="margin-top: 164px;">
      
    </div>
  @endfor
  </div>
  </body>

</html>
<?php  function spaces($spaces)
{
  $val = '';
  while($spaces>0)
  {
    $val = $val.'&nbsp;';

    $spaces--;
  }
  return $val;
};?>

<script type="text/javascript">



</script>