<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>Orden de Venta</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700;900&display=swap');
    </style>

</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img class="img center" width="200" height="130" src="./img/logo.png" alt="Logotipo">
        </div>
        <h1 class="order-title">Factura N-000
            <?php echo $numero ?>
        </h1>

        <div class="row-ordersale">
            <div id="company" class="clearfix column-order">
                <h3 class="title-type-order">Datos de Sucursal</h3>
                <div><b class="label">Sucursal: </b><span class="responsedata">
                        <?php echo $sucursal_name ?>
                    </span></div>
                <div><b class="label">Direccion: </b> <span class="responsedata">
                        <?php echo $sucursal_address ?>
                    </span></div>
                <div><b class="label">Telefono: </b><span class="responsedata">
                        <?php echo $sucursal_phone ?>
                    </span></div>
                <div><b class="label">Email: </b><span class="responsedata"><a
                            href="mailto:<?php echo $sucursal_email ?>">
                            <?php echo $sucursal_email ?></span></a></div>
            </div>

            <div id="project" class="column-order right">
                <h3 class="title-type-order">Datos de Cliente</h3>
                <div><b class="label">Cliente: </b><span class="responsedata">
                        <?php echo $cliente ?>
                </div>
                <div><b class="label">Direccion: </b><span class="responsedata">
                        <?php echo $client_address ?>
                </div>
                <div><b class="label">Telefono:</b><span class="responsedata"> <a
                            href="phone:<?php echo $client_phone ?>">
                            <?php echo $client_phone ?>
                        </a></div>
                <div><b class="label">Fecha: </b><span class="responsedata">
                        <?php echo $fecha ?>
                </div>
            </div>
        </div>
    </header>
    <div class="white-space-order"></div>
    <main>
        <?php
        $subtotal = 0;
        foreach ($productos as $producto) {
          $totalProducto = $producto->quantityCart * $producto->price;
          $subtotal += $totalProducto;
        ?>
        <tr>
            <p class="service">
                <?php echo $producto->barcode ?>
            </p>
            <p class="desc">
                <?php echo $producto->description ?>
            </p>
            <p class="unit">$
                <?php echo number_format($producto->price, 2) ?>
            </p>
            <p class="qty">
                <?php echo number_format($producto->quantityCart, 2) ?>
            </p>
            <p class="total">$
                <?php echo number_format($producto->price * $producto->quantityCart, 2) ?>
            </p>
        </tr>
        <?php }
        $subtotalConDescuento = $subtotal - $descuento;
        $impuestos = $subtotalConDescuento * ($porcentajeImpuestos / 100);
        $total = $subtotalConDescuento + $impuestos;
        ?>
        <p colspan="4">SUBTOTAL:</p>
        <p class="total">$
            <?php echo number_format($subtotal, 2) ?>
        </p>
        <p colspan="4">Descuento</p>
        <p class="total">$
            <?php echo number_format($descuento, 2) ?>
        </p>
        <p colspan="4" class="text-right">Subtotal con descuento</p>
        <p>$
            <?php echo number_format($subtotalConDescuento, 2) ?>
        </p>
        <p colspan="4" class="grand total">TOTAL:</p>
        <p class="grand total">$
            <?php echo number_format($total, 2) ?>
        </p>

        <div class="invoice-notice">

            <div class="container-header">
                <h6 class="nota-invoice-subt margin-0">Pol??ticas de garant??a</h6>
                <p class="nota-invoice-text margin-0">La garant??a es de 60 d??as naturales. Solo aplica en la pieza
                    cambiadao falla reparada</p>
            </div>

            <div class="container-body">
                <h6 class="nota-invoice-subt margin-0">Procedimiento </h6>
                <p class="nota-invoice-text margin-0 align-left"> - Presentar ticket, equipo y/o producto con holograma
                    y sellos que garantizan nuestro trabajo, solicitamos 2 d??as habiles
                    para la reparaci??n o diagnostico de la falla.</p>
                <p class="nota-invoice-text margin-0 align-left"> - En caso de que no proceda la garant??a por alguna
                    circunstancia ajena a estas cl??usulas o mal uso del cliente
                    se le cobrar??n $100.00 por concepto de diagnistico y materiales.</p>
                <p class="nota-invoice-text margin-0 align-left"> - El cliente cuenta con 30 d??as naturales para
                    recuperar su equipo, en casso de no hacerlo se cobrar??n $10.00 diarios almacenaje y riesgos hasta
                    cumplir 30 d??as naturales, posterior a este plazo zodiaco movil se
                    deslinda de cualquier responsabilidad del dispositivo o equipo.</p>
                <p class="nota-invoice-text margin-0 align-left"> - Sin ticket NO se entregar?? equipo, ni anticipo.</p>

            </div>



            <div class="container-two-body">
                <h6 class="nota-invoice-subt margin-0">Exclusiones </h6>
                <p class="nota-invoice-text margin-0 align-left"> - Defectos o fallas del producto ocasionados por mal
                    uso o abuso del cliente.</p>
                <p class="nota-invoice-text margin-0 align-left"> - Por fallas en el equipo debido a instalaci??n de
                    programas o manipulaci??n de terceros.</p>
                <p class="nota-invoice-text margin-0 align-left"> - Equipos mojados, touch, software, liberaci??n y
                    trabajos con temperatura corren riesgo de apagar o no encender debido a alg??n da??o colateral.</p>
                <p class="nota-invoice-text margin-0 align-left"> - El cliente es el unico responsable de la procedencia
                    del equipo.</p>

            </div>



        </div>
    </main>
    <footer class="footer_order">
        OJO: ????Este presupuesto es valido durante 30 dias!!
    </footer>
</body>

</html>