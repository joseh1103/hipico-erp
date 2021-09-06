<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">


  <title>Orden de Venta</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700;900&display=swap');
  </style>
  
  


  <title>Example 1</title>
  <style>
  
    body{
      font-family: 'Roboto', sans-serif !important;
     }
     header {
      padding: 10px 0;
      margin-bottom: 30px;
      width: 100%;
    }
    #logo {
      text-align: center;
      margin-bottom: 10px;
    }

    #logo img {
      width: auto !important;
    }

    h1.order-title{
      text-align: center !important;
      font-family: 'Roboto', sans-serif !important;
     font-weight: 700 !important;
     font-size:18px !important;
     padding: 3px !important;
     background: rgba(253, 126, 20, 1.0) !important;
     color: #fff !important;
    }

    .row-ordersale:after {
    content: "";
    display: table;
    clear: both;
    }
    .column-order{
      float: left;
    width: 49%;
    margin: 1px !important;
    height: auto !important;
    }
    
    .right{
      text-align: right !important;
    }
    .white-space-order{
      height:50px !important;
    }
    .title-type-order{
      text-align: center !important;
      font-family: 'Roboto', sans-serif !important;
      font-weight: 400 !important;
      font-size:16px !important;
     
     background: rgba(253, 126, 20, 1.0) !important;
     color: #fff !important;
    }
    .label{
     
      font-family: 'Roboto', sans-serif !important;
      font-size:14px !important;
      margin-right: 10px !important;
      text-align: left !important;
      
    }
    .responsedata{
      width: 60% !important;
      font-family: 'Roboto', sans-serif !important;
      font-size:14px !important;
      
    }
    table{
      width:100% !important;
      font-family: 'Roboto', sans-serif !important;
    }
    thead{
      background: rgba(253, 126, 20, 1.0) !important;
      padding:24px !important;
      color: #fff !important;
      font-family: 'Roboto', sans-serif !important;
      font-size: 15px !important;
    }
    table th {
      padding: 5px 20px;
      color: #5D6975;
      border-bottom: 1px solid #C1CED9;
      white-space: nowrap;
      font-weight: normal;
    }
    table td{
      background: #F2F2F2 !important;
      text-align: left !important;
      font-size:14px !important;
      padding: 8px !important;
      color: #000 !important;
      text-align: center !important;
    }
    table td.unit,
    table td.qty,
    table td.total {
      font-size: 1.2em;
    }

    table td.service,
    table td.desc {
      vertical-align: top;
    }

    .below-table{
      font-weight: 600 !important;
      font-family: 'Roboto', sans-serif !important;
      text-transform: uppercase !important;
      font-size: 14px !important;
     text-align: right !important;
     padding:8px !important;
    }

    .invoice-notice{
      background: #F2F2F2 !important;
      font-family: 'Roboto', sans-serif !important;
      padding: 4px !important;
      margin-top: 1% !important;
    }

    footer {
      color: #5D6975;
      width: 100%;
      height: 30px;
      text-align: center;
    }

    .footer_order{
      width: 100% !important;
      position:absolute !important;
      bottom: 10px !important;
      background: #f7f7f7 !important;
      margin-top: 5% !important;
      padding: 10px !important;
      color: red !important;
      font-weight: 700 !important;
      text-align: center !important;
    }
    .container_header{
      width: auto !important;
      height: auto !important;
      padding: 5px !important;
      
    }
    .container_body{
      width: auto !important;
      height: auto !important;
      padding: 5px !important;
      
    }

    .container-two-body{
      margin-top: 15px !important;

    }

    
    .nota-invoice-title{
      font-size: 20px !important;
      text-align: center !important;
    }
    .nota-invoice-subt{
      font-size: 16px !important;
      text-align: center !important;
    }
    .nota-invoice-text{
      font-size: 12px !important;
      text-align: center !important;
      font-style: italic !important;
      font-weight: 200 !important;
    }
    .margin-0{
      margin: 5px !important;
      padding: 5px !important;
    }
    .align-left{
      text-align:left !important;
      margin-bottom:5px !important;
    }

  </style> 

</head>

<body>
  <header class="clearfix">
    <div id="logo">
      <img class="img center" width="200" height="130" src="./img/logo.png" alt="Logotipo">
    </div>
    <h1 class="order-title" >Presupuesto N-000<?php echo $numero ?></h1>

    <div class="row-ordersale">
    <div id="company" class="clearfix column-order">
      <h3 class="title-type-order">Datos de Sucursal</h3>
      <div><b class="label">Sucursal: </b><span class="responsedata"> <?php echo $sucursal_name ?> </span></div>
      <div><b class="label">Direccion: </b> <span class="responsedata"><?php echo $sucursal_address ?></span></div>
      <div><b class="label">Telefono: </b><span class="responsedata"><?php echo $sucursal_phone ?></span></div>
      <div><b class="label">Email: </b><span class="responsedata"><a href="mailto:<?php echo $sucursal_email ?>"><?php echo $sucursal_email ?></span></a></div>
    </div>

    <div id="project" class="column-order right">
    <h3 class="title-type-order">Datos de Cliente</h3>
      <div><b class="label">Cliente: </b><span class="responsedata"><?php echo $cliente ?></div>
      <div><b class="label">Direccion: </b><span class="responsedata"><?php echo $client_address ?></div>
      <div><b class="label">Telefono:</b><span class="responsedata"> <a href="phone:<?php echo $client_phone ?>"><?php echo $client_phone ?></a></div>
      <div><b class="label">Fecha: </b><span class="responsedata"><?php echo $fecha ?></div>
    </div>
  </div>
  </header>
  <div class="white-space-order"></div>
  <main>
    <table>
      <thead>
        <tr>
          <th class="service">Código</th>
          <th class="desc">Descripción</th>
          <th class="desc">Precio unitario</th>
          <th class="desc">Cantidad</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>

      <tbody>
        <?php
        $subtotal = 0;
        foreach ($productos as $producto) {
          $totalProducto = $producto->quantityCart * $producto->price;
          $subtotal += $totalProducto;
        ?>
          <tr>
            <td class="service"><?php echo $producto->barcode ?></td>
            <td class="desc"><?php echo $producto->description ?></td>
            <td class="desc">$<?php echo number_format($producto->price, 2) ?></td>
            <td class="desc"><?php echo $producto->quantityCart ?></td>
            <td class="total">$<?php echo number_format($producto->price * $producto->quantityCart, 2) ?></td>
          </tr>
        <?php }
        $subtotalConDescuento = $subtotal - $descuento;
        $impuestos = $subtotalConDescuento * ($porcentajeImpuestos / 100);
        $total = $subtotalConDescuento + $impuestos;
        
        ?>
      </tbody>
      <tr>
        <td class="below-table" colspan="4">SUBTOTAL</td>
        <td class="total">$<?php echo number_format($subtotal, 2) ?></td>
      </tr>
      <tr>
        <td class="below-table" colspan="4">Descuento</td>
        <td class="total">$<?php echo number_format($descuento, 2) ?></td>
      </tr>
      <tr>
        <td class="below-table" colspan="4" class="text-right">Subtotal con descuento</td>
        <td>$<?php echo number_format($subtotalConDescuento, 2) ?></td>
      </tr>
      <tr>
        <td class="below-table" colspan="4" class="grand total">TOTAL</td>
        <td class="grand total">$<?php echo number_format($total, 2) ?></td>
      </tr>
      </tbody>
    </table>

    <div class="invoice-notice">
    
<div class="container-header">
   <h6 class="nota-invoice-subt margin-0">Políticas de garantía</h6>
    <p class="nota-invoice-text margin-0">La garantía es de 60 días naturales. Solo aplica en la pieza cambiadao falla reparada</p>
</div>

<div class="container-body">
<h6 class="nota-invoice-subt margin-0">Procedimiento </h6>
<p class="nota-invoice-text margin-0 align-left"> - Presentar ticket, equipo y/o producto con holograma y sellos que garantizan nuestro trabajo, solicitamos 2 días habiles 
      para la reparación o diagnostico de la falla.</p>
<p class="nota-invoice-text margin-0 align-left"> - En caso de que no proceda la garantía por alguna circunstancia ajena a estas cláusulas o mal uso del cliente
      se le cobrarán $100.00 por concepto de diagnistico y materiales.</p>
<p class="nota-invoice-text margin-0 align-left"> - El cliente cuenta con 30 días naturales para recuperar su equipo, en casso de no hacerlo se cobrarán $10.00 diarios almacenaje y riesgos hasta cumplir 30 días naturales, posterior a este plazo zodiaco movil se
      deslinda de cualquier responsabilidad del dispositivo o equipo.</p>
<p class="nota-invoice-text margin-0 align-left"> - Sin ticket NO se entregará equipo, ni anticipo.</p>

</div>



<div class="container-two-body">
<h6 class="nota-invoice-subt margin-0">Exclusiones </h6>
<p class="nota-invoice-text margin-0 align-left"> - Defectos o fallas del producto ocasionados por mal uso o abuso del cliente.</p>
<p class="nota-invoice-text margin-0 align-left"> - Por fallas en el equipo debido a instalación de programas o manipulación de terceros.</p>
<p class="nota-invoice-text margin-0 align-left"> - Equipos mojados, touch, software, liberación y trabajos con temperatura corren riesgo de apagar o no encender debido a algún daño colateral.</p>
<p class="nota-invoice-text margin-0 align-left"> - El cliente es el unico responsable de la procedencia del equipo.</p>

</div>
     

    
</div>

    
  </main>
  <footer class="footer_order">
    OJO: ¡¡Este presupuesto es valido durante 30 dias!!
  </footer>
</body>

</html>