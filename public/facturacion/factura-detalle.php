<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// woocommerce restful api get customer all orders with meta key wcpdf_invoice_number

require_once(APP_ROOT. '/vendor/autoload.php');

use Automattic\WooCommerce\Client;

$activePage = "clientes";

if(isset($params['id'])) {
    $id = $params['id'];
}

function wc_price( $price ) {
    $currency_symbol = '€'; // replace with your currency symbol
    $decimal_separator = ','; // replace with your decimal separator
    $thousands_separator = '.'; // replace with your thousands separator
    
    $price = number_format( $price, 2, $decimal_separator, $thousands_separator );
    
    return $price . $currency_symbol;
}

echo '<div class="container">';
echo '<h1>Gestión de facturación</h1>';

// Authenticate with the API
$woocommerce = new Client(
    'https://esinec.com/',
    'ck_abc55b466d19218f2c24bf114c098d799a966f4b',
    'cs_2e386b874b0dc0feff1b6af2cfeb11b77b7dd1d0',
    [
        'wp_api' => true, // Enable the WP REST API integration
        'version' => 'wc/v3' // WooCommerce WP REST API version
    ]
);

// Get the order ID from the query string
$order_id = $id;

// Retrieve the order from the WooCommerce API
$order = $woocommerce->get('orders/' . $order_id);

// Get the meta data for the order
$meta_data = $order->meta_data;

// Loop through the meta data and output the values
foreach ($meta_data as $meta) {
    switch ($meta->key) {
        case '_wcpdf_invoice_number':
            $invoiceNumber = $meta->value;
            break;
        case 'numero_pago':
            $numeroPago = $meta->value;
            break;
        case 'notas':
            $notas = $meta->value;
            break;
        case 'comisionista_1':
            $comisionista1 = $meta->value;
            break;
        case 'comision_1':
            $comision1 = $meta->value;
            break;
        case 'comisionista_2':
            $comisionista2 = $meta->value;
            break;
        case 'comision_2':
            $comision2 = $meta->value;
            break;
    }
}

$date = $order->date_created;
$createDate = new DateTime($date);
$createDate_format = $createDate->format('d-m-Y');

// Display the order information

echo '<h3>Número de factura: ';
if (isset($invoiceNumber)) {
    echo ''.$invoiceNumber.'';
} else {
    echo ''.$order->id.'';
}
echo '</h3>';

echo '<h4>Cliente</h4>';
echo '<ul>';
echo '<li><strong>Nombre y apellidos:</strong> <a href="https://gestion.esinec.com/clientes/'.$order->customer_id.'/">' . $order->billing->first_name . ' '  . $order->billing->last_name .'</a></li>';
echo '<li><strong>Email:</strong> ' . $order->billing->email . '</li>';
echo '<li><strong>Teléfono:</strong> ' . $order->billing->phone . '</li>';
echo '</ul>';

echo "<hr>";

echo '<h4>Info Factura</h4>';
echo '<ul>';
echo '<li><strong>Estado:</strong> ' . $order->status . '</li>';
echo '<li><strong>Fecha:</strong> ' . $createDate_format . '</li>';
echo '<li><strong>Método de pago</strong> ' . $order->payment_method_title . '</li>';
echo '<li><strong>Número de pago:</strong> '; if (!isset($numeroPago)) {
                                                echo '--';
                                            } else {
                                                echo $numeroPago;
                                            }'</li>';
echo '<li><strong>Notas:</strong> '; if (!isset($notas)) {
                                                echo '--';
                                            } else {
                                                echo $notas;
                                            }'</li>';
echo '<li><strong>Comisionista 1:</strong> '; if (!isset($comisionista1)) {
                                                echo '--';
                                            } else {
                                                echo $comisionista1;
                                            }'</li>';
echo '<li><strong>Comisión 1:</strong> '; if (!isset($comision1)) {
                                                echo '--';
                                            } else {
                                                echo wc_price($comision1);
                                            }'</li>';
echo '<li><strong>Comisionista 2:</strong> '; if (!isset($comisionista2)) {
                                                echo '--';
                                            } else {
                                                echo $comisionista2;
                                            }'</li>';
echo '<li><strong>Comisión 2:</strong> '; if (isset($comision2)) {
                                                echo '--';
                                            } else {
                                                echo wc_price($comision2);
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
foreach ($order->line_items as $item) {
    echo '<tr>';
    echo '<td>' . $item->name . '</td>';
    echo '<td>x '.$item->quantity.'</td>';
    echo '<td>'.wc_price($item->subtotal).'</td>';
    echo '</tr>';
}
echo "</tbody>";                            
echo "</table>";
echo "</div>";

echo '<li><strong>Total IVA:</strong> ' . wc_price($order->total_tax) . '</li>';
echo '<li><strong>Total pagado:</strong> ' .wc_price($order->total).'</li>';

echo "</div>";

# footer
include_once(APP_ROOT. '/inc/footer.php');