<?php
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";

// woocommerce restful api get customer all orders with meta key wcpdf_invoice_number

require_once(APP_ROOT. '/vendor/autoload.php');

use Automattic\WooCommerce\Client;

$activePage = "clientes";

if(isset($params['id'])) {
    $id = $params['id'];
}

echo '<div class="container">';
echo '<h1>Gestión de Clientes</h1>';
echo '<h2>Información sobre el cliente</h2>';

echo "<hr>";
// Authenticate with the API
$woocommerce = new Client(
    'https://esinec.com/',
    WC_API_KEY,
    WC_API_SECRET,
    [
        'version' => 'wc/v3',
    ]
);

// Get the customer ID
$customer_id = $id;

// Retrieve the customer information
$customer = $woocommerce->get("customers/{$customer_id}");

// Display the customer information
echo '<div class="customer-info">';
echo '<h4>Cliente:</h4>';
echo '<p><strong>Nombre y apellidos</strong> : <a href="https://gestion.esinec.com/clientes/'.$customer_id.'/">' . $customer->first_name . ' '  . $customer->last_name .'</a><p>';
echo '<p><strong>Email</strong> : ' . $customer->email . '<p>';
echo '<p><strong>Teléfono:</strong> ' . $customer->billing->phone . '</p>';

echo '<p><strong>Dirección:</strong> ' . $customer->billing->address_1 . '</p>';
echo '<p><strong>Código postal:</strong> ' . $customer->billing->postcode . '</p>';
echo '<p><strong>Ciudad:</strong> ' . $customer->billing->city . '</p>';
echo '<p><strong>País:</strong> ' . $customer->billing->country . '</p>';

echo '</div>';

echo '<hr>';

echo '<h3>Facturación</h3>';
echo '<p><a href="https://gestion.esinec.com/clientes/'.$customer_id.'/facturacion/">Ver historial de facturación</a></p>';
echo '</div>';

include_once('modals-cliente-facturacion.php');

# footer
include_once(APP_ROOT. '/inc/footer.php');