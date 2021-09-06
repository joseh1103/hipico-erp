<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="padding: 0px 0px; margin: 0px 0px">
<style>
    html{
        margin: 1em;
    }

    p{
        padding: 0px;
        margin:0px;
        font-size: 0.7em;
        font-weight: bold;

    }

    th{
        font-size:0.8em;
    }
</style>
    <div style="width: 100%;">
        <img style="width: 80%; padding-left:10%" class="pl-4" src="img/zmlogo.png" alt="">
    </div>
    {{-- {{ $subtotal = 0; }} --}}

    <div style="text-align: center;">
        <p>SOPORTE Y SERVICIO TÉCNICO SMARTPHONE, TABLETA Y LAPTOP</p>
        <br>
    </div>

    <div class="info" style="text-align:left;">
        <p> {{ $sucursal_name }} </p>
        <p> {{ $sucursal_address }} </p>
        <p>Teléfono: {{ $sucursal_phone}} </p>
        <p>Mail: {{ $sucursal_email }} </p>
        <br/>
        <p>Datos del cliente:</p>
        <p> {{ $cliente }} </p>
        <p> {{ $client_phone }} </p>
        <p> {{ $client_address }} </p>
        <br>

    </div>
    <?php
        $subtotal = 0;
    ?>
    <p>Numero de nota: {{ strlen($numero)<3 ? '00'.$numero : $numero }} </p>
    <br>
    <table> 
        <tr>
            <th>#</th>
            <th>Descripción</th>
            <th>Precio U</th>
            <th>Total</th>
        </tr>
        @foreach($productos as $producto)
            <tr>
                <td><p>{{ $producto->quantityCart }} </p></td>
                <td><p> {{ $producto->description }} </p></td>
                <td><p> {{ $producto->price }} </p></td>
                <td> <p>{{ $producto->price * $producto->quantityCart }}</p> </td>
            </tr>
        @endforeach
    </table>

    @foreach($productos as $producto)
        <?php

            $totalProducto = $producto->quantityCart * $producto->price;
            $subtotal += $totalProducto ;
        ?>
        
    @endforeach
    <?php
        $subtotalConDescuento = $subtotal - $descuento;
        $impuestos = $subtotalConDescuento * ($porcentajeImpuestos / 100);
        $total = $subtotalConDescuento + $impuestos;

    ?>
    <br>
    <p class="grand total">Total: $ <?php echo number_format($total, 2) ?></p>

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

    <h6 class="nota-invoice-subt margin-0">Exclusiones </h6>
<p class="nota-invoice-text margin-0 align-left"> - Defectos o fallas del producto ocasionados por mal uso o abuso del cliente.</p>
<p class="nota-invoice-text margin-0 align-left"> - Por fallas en el equipo debido a instalación de programas o manipulación de terceros.</p>
<p class="nota-invoice-text margin-0 align-left padding-bottom:10px"> - Equipos mojados, touch, software, liberación y trabajos con temperatura corren riesgo de apagar o no encender debido a algún daño colateral.</p>
<br>
<br>
<div style="background-color: white; height:1em;">
</div>
</body>
</html>