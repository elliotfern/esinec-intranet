<?php

if(isset($params['id'])) {
    $id = $params['id'];
}

$url_server = "https://" . $_SERVER['HTTP_HOST'];

function wc_price( $price ) {
    $currency_symbol = '€'; // replace with your currency symbol
    $decimal_separator = ','; // replace with your decimal separator
    $thousands_separator = '.'; // replace with your thousands separator
    
    $price = number_format( $price, 2, $decimal_separator, $thousands_separator );
    
    return $price . $currency_symbol;
}

echo '<div class="container">';
echo '<h1>Gestión de facturación</h1>';

//call api
        //read json file from url in php
        $url = $url_server . "/controller/facturacion.php?type=factura-intranet-cliente&id=" .$id;
        $input = file_get_contents($url);
        $arr = json_decode($input, true);
        $vault = $arr[0];

            $status = $vault['status'];
            $date = $vault['fecha'];
            $clienteId = $vault['clienteId'];
            $invoiceNumber = $vault['invoice_number'];
            $precio_neto2 = $vault['total'];
            $orderTax = $vault['tax'];
            $items = $vault['producto'];
            $numPago = $vault['numPago'];
            $paymentType = $vault['payment_method'];
            $productoVariante = $vault['productoVariante'];
            $notas = $vault['notas'];
            $comision1 = $vault['comision1'];
            $comisionista2 = $vault['comisionista2'];
            $comision2 = $vault['comision2'];
            $comisionista1 = $vault['comisionista1'];
            $nombre = $vault['nombre'];
            $apellidos = $vault['apellidos'];
            $productoNombre = $vault['productoNombre'];

            $comision1_net = intval($comision1);
            $comision2_net = intval($comision2);

            // calculo del IVA
            $vatAmount = $precio_neto2 * ($orderTax / 100);
            $vat_redondeado = ceil($vatAmount * 100) / 100;

            $precio_total = $precio_neto2 + $vat_redondeado;

            //$email =$vault['email']";
            //$telefono = $vault['telefono'];

            $datetime = new DateTime($date);
            $year = $datetime->format('Y');
            $date_net = $datetime->format('d/m/Y');

// Display the order information

echo '<h3>Número de factura: ESINEC.'.$year.'.'.$invoiceNumber.'</h3>';

echo '<h4>Cliente</h4>';
echo '<ul>';
echo '<li><strong>Nombre y apellidos:</strong> <a href="https://gestion.esinec.com/clientes/'.$clienteId.'/">' . $nombre . ' '  . $apellidos .'</a></li>';
//echo '<li><strong>Email:</strong> ' . $email. '</li>';
//echo '<li><strong>Teléfono:</strong> ' . $telefono . '</li>';
echo '</ul>';

echo "<hr>";

echo '<h4>Info Factura</h4>';
echo '<ul>';
echo '<li><strong>Estado:</strong> ';

if ($status == 1) {
    $statusName = "Pendiente de pago";
} elseif ($status == 2) {
    $statusName = "Pagado";
} elseif ($status == 3) {
    $statusName = "Cancelado";
} else {
    $statusName = "";
}

echo ''. $statusName . '</li>';
echo '<li><strong>Fecha:</strong> ' . $date_net . '</li>';
echo '<li><strong>Método de pago: </strong>';

if ($paymentType == 1) {
    $paymentMethod = "Transferencia bancaria";
} elseif ($paymentType == 2) {
    $paymentMethod = "Tarjeta";
} elseif ($paymentType == 3) {
    $paymentMethod = "PayPal";
} elseif ($paymentType == 4) {
    $paymentMethod = "Cash";
} else {
    $paymentMethod = "";
}

echo ' '.$paymentMethod.'</li>';
echo '<li><strong>Número de pago:</strong> '; if (!isset($numPago)) {
                                                echo '--';
                                            } else {
                                                echo $numPago;
                                            }'</li>';
echo '<li><strong>Notas:</strong> '; if (!isset($notas)) {
                                                echo '--';
                                            } else {
                                                echo $notas;
                                            }'</li>';
echo '<li><strong>Comisionista 1:</strong> '; if ($comisionista1 == "") {
                                                echo '--';
                                            } else {
                                                echo $comisionista1;
                                            }'</li>';
echo '<li><strong>Comisión 1:</strong> '; if (!isset($comision1)) {
                                                echo '--';
                                            } else {
                                                echo wc_price($comision1_net);
                                            }'</li>';
echo '<li><strong>Comisionista 2:</strong> '; if ($comisionista2 == "") {
                                                echo '--';
                                            } else {
                                                echo $comisionista2;
                                            }'</li>';
echo '<li><strong>Comisión 2:</strong> '; if (!isset($comision2)) {
                                                echo '--';
                                            } else {
                                                echo wc_price($comision2_net);
                                            }'</li>';
echo '</ul>';

echo "<hr>";

echo '<h4>Detalle</h4>';

echo "<div class='container' style='margin-top:20px;margin-bottom:25px'>";
     echo "<div class='".TABLE_DIV_CLASS."'>";
     echo "<table class='".TABLE_CLASS."'>";
     echo "<thead class='".TABLE_THREAD."'>";
echo '<tr>
<th>Producto</th>
<th>Cantidad</th>
<th>Precio neto</th>
</tr>
</thead>
<tbody>';
    echo '<tr>';
    echo '<td>' . $productoNombre . '';
    if ($productoVariante !== "") {
        echo ' - '.$productoVariante.'';
    }
    echo '</td>';
    echo '<td>x 1</td>';
    echo '<td>'.wc_price($precio_neto2).'</td>';
    echo '</tr>';
echo "</tbody>";                            
echo "</table>";
echo "</div>";

echo '<li><strong>Total IVA:</strong> ' . wc_price($vat_redondeado) . '</li>';
echo '<li><strong>Total pagado:</strong> ' .wc_price($precio_total).'</li>';

echo "</div>";

# footer
include_once(APP_ROOT. '/inc/footer.php');