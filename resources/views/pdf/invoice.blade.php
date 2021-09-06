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
      width: 50% !important;
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
      <img class="img center" width="200" height="120" src="./img/logo.png" alt="Logotipo">
    </div>
    <h1 class="order-title">Jornada <?php echo $jornada_name ?></h1>

    <div class="row-ordersale">
    <div id="company" class="clearfix column-order">
      <h3 class="title-type-order">Datos de Jornada</h3>
      <div><b class="label">Nombre: </b><span class="responsedata"> <?php echo $jornada_name ?> </span></div>
      <div><b class="label">Carreras: </b> <span class="responsedata"><?php echo $carreras ?></span></div>
      <div><b class="label">Comission: </b><span class="responsedata"><?php echo $commission ?></span></div>
      <div><b class="label">Fecha: </b><span class="responsedata"><?php echo $date ?></div>
    </div>

  </div>

  </header>
  <main>
    <table>
      <thead>
        <tr>
        <th class="service">Tabla</th>
          <th>Incentivo</th>
          <th class="desc">Total a Pagar</th>
          <th>Ganador</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>

      <?php
        $subtotal = 0;
        foreach ($data as $item) {
          $subtotal += $item['total_ganancia'];
        ?>
          <tr>
            <td class="service"><strong> <?php echo $item['carrera_id'] ?> </strong></td>
            <td class="desc"><strong> <?php echo number_format($item['incentive'], 2) ?> </strong></td>
            <td class="desc"><strong> <?php echo number_format($item['total_pay'], 2) ?> </strong></td>
            <td class="desc"><strong> <?php echo $item['users_winner'] ?> </strong></td>
            <td class="total"><strong> <?php echo number_format($item['total_ganancia'], 2) ?> </strong></td>
          </tr>
        <?php }
       
        ?>
        <tr>
          <td class="below-table" colspan="4" class="grand total">TOTAL</td>
          <td class="grand total"><strong><?php echo number_format($subtotal, 2) ?> </strong></td>
        </tr>

      </tbody>
    </table>

  </main>
</body>

</html>