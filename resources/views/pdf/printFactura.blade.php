<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Example 2</title>
    
    <style type="text/css">

      html, body, div, span, applet, object, iframe, table, caption,
      tbody, tfoot, thead, tr, th, td, del, dfn, em, font, img, ins,
      kbd, q, s, samp, small, strike, strong, sub, sup, tt, var,
      h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr,
      acronym, address, big, cite, code, dl, dt, dd, ol, ul, li,
      fieldset, form, label, legend {
          vertical-align: baseline;
          font-family: inherit;
          font-weight: inherit;
          font-style: inherit;
          font-size: 100%;
          outline: 0;
          padding: 0;
          margin: 0;
          border: 0;
      }
      :focus {
          outline: 0;
      }
      body {
          background: white;
          line-height: 1;
          color: black;
      }
      ol, ul {
          list-style: none;
      }
      table {
          border-collapse: separate;
          border-spacing: 0;
      }
      caption, th, td {
          font-weight: normal;
          text-align: left;
      }
      blockquote:before, blockquote:after, q:before, q:after {
          content: "";
      }
      blockquote, q {
          quotes: "" "";
      }

      table 
      {
        border-collapse: collapse;
        margin: auto;
        padding: auto;
        padding-top: 2%;
      }

    table, td, th 
    {
        border: 1px solid black;
    }
      span.title
      {
        font-weight: bold;
      }
      span.content
      {
        font-weight: normal;
      }
      td.txtLeft
      {
        text-align: left;
      }
      th.txtLeft
      {
        text-align: left;
      }
      td.txtCenter
      {
        text-align: center;
      }
      .facturaBody
      {
        border-radius: 2px;
      }
    </style>
</head>
  <body>
  <?php   $STPU=0;$STP=0;?>
    <table id="tableFactura">
      <tr>
        <th colspan="3" rowspan="1"></th>
        <th colspan="2"><br><span class="title">FACTURA: </span><br> {{ $factura->nro_factura }}</th>
      </tr>

      <tr>
        <td colspan="5"><span class="title">Direccion: </span>{{ $factura->direccion }}<br><span class="title">Telf:</span> {{ $factura->telefono }}<br><span class="title">Fecha:</span> {{ $factura->fecha }}<br><span class="title">RUC:</span> {{ $factura->ruc }}<br><span class="title">Razon Social: </span> {{ $factura->razon_social }}
        RUC:{{ $factura->ruc }}<br><span class="title">Forma de pago:</span> {{ $factura->forma_de_pago }}<br><span class="title">Observacion:</span> {{ $factura->observacion }}</td>
      </tr>
      <tr>
        <th>Cantidad</th>
        <th>Descripcion</th>
        <th>Precio Unitario</th>
        <th>Precio</th>
        <th>Sub Total + IVA</th>
      </tr>
      @foreach ($detalleFacturas as $detalleFactura)
      <tr>
        <td class="txtCenter">{{ $detalleFactura->cantidad }}</td>
        <td>{{ $detalleFactura->descripcion }}</td>
        <td class="txtCenter"><?php echo number_format((float)$detalleFactura->precio_unitario); $STPU+=$detalleFactura->precio_unitario;?>  </td>
        <td class="txtCenter"><?php echo number_format((float)$detalleFactura->precio);$STP+=$detalleFactura->precio;?>  </td>
        <td class="txtLeft">{{ $detalleFactura->subtotal }}</td>
      </tr>
      @endforeach
      <tr>
        <th colspan="2" class="txtLeft">Sub-Totales</th>
        <th> <?php echo '<span class="content">'.number_format((float)$STPU).'</span>';?></th>
        <th> <?php echo '<span class="content">'.number_format((float)$STP).'</span>';?></th>
      </tr>
      <tr>
        <td colspan=4 class="txtLeft"><span style="font-weight: bold;">Total a pagar Gs </span><span>{{ $factura->monto_total_letras }} </span></td>
        <td><?php echo number_format( (float)$factura->monto_total);?></td>
      </tr>

    </table>


  </body>

</html>

<script type="text/javascript">

</script>