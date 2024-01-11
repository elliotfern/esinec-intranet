<?php

// woocommerce restful api get customer all orders with meta key wcpdf_invoice_number
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$url_server = "https://" . $_SERVER['HTTP_HOST'];



$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

function wc_price($price)
{
    $currency_symbol = ' €'; // replace with your currency symbol
    $decimal_separator = ','; // replace with your decimal separator
    $thousands_separator = '.'; // replace with your thousands separator

    $price = number_format($price, 2, $decimal_separator, $thousands_separator);

    return $price . $currency_symbol;
}

global $conn2; // Declare the variable as global
$stmt = $conn2->prepare("SELECT
p2.id as order_id,
p2.date AS fecha,
p2.status AS status,
p2.invoiceNumber AS invoice_number,
p2.orderTotal AS total,
p2.orderTax AS tax,
p2.paymentType AS payment_method,
p2.numPago,
p2.productoVariante AS productoVariante,
p2.items,
umf.meta_value AS nombre,
uml.meta_value AS apellidos,
p1.post_title AS product_name,
um3.meta_value AS direccion,
um4.meta_value AS provincia,
um5.meta_value AS pais,
um6.meta_value AS codigopostal,
um7.meta_value AS ciudad,
um8.meta_value AS dni,
fc.id AS idFiscal,
fc.idCliente AS idCliente,
fc.nombre AS nombreFiscal,
fc.apellidos AS apellidosFiscal,
fc.empresa AS empresaFiscal,
fc.dni AS dniFiscal,
fc.direccion AS direccionFiscal,
fc.ciudad AS ciudadFiscal,
fc.pais AS paisFiscal,
fc.provincia AS provinciaFiscal
FROM txsxekgr_intranet.facturas AS p2
LEFT JOIN txsxekgr_intranet.datosFiscalesCliente AS fc ON fc.idCliente = p2.clienteId
LEFT JOIN txsxekgr_esinec.wp_posts AS p1 ON p2.items = p1.ID
LEFT JOIN txsxekgr_esinec.wp_usermeta AS umf ON p2.clienteId = umf.user_id AND umf.meta_key = 'first_name'
LEFT JOIN txsxekgr_esinec.wp_usermeta AS uml ON p2.clienteId = uml.user_id AND uml.meta_key = 'last_name'
LEFT JOIN txsxekgr_esinec.wp_usermeta AS um3 ON p2.clienteId = um3.user_id AND um3.meta_key = 'billing_address_1'
LEFT JOIN txsxekgr_esinec.wp_usermeta AS um4 ON p2.clienteId = um4.user_id AND um4.meta_key = 'billing_state'
LEFT JOIN txsxekgr_esinec.wp_usermeta AS um5 ON p2.clienteId = um5.user_id AND um5.meta_key = 'billing_country'
LEFT JOIN txsxekgr_esinec.wp_usermeta AS um6 ON p2.clienteId = um6.user_id AND um6.meta_key = 'billing_postcode'
LEFT JOIN txsxekgr_esinec.wp_usermeta AS um7 ON p2.clienteId = um7.user_id AND um7.meta_key = 'billing_city'
LEFT JOIN txsxekgr_esinec.wp_usermeta AS um8 ON p2.clienteId = um8.user_id AND um8.meta_key = 'billing_nif'
WHERE p2.id = 19
GROUP BY p2.id"); 

$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Access individual columns using the column name
    $date = new DateTime($row['fecha']);
        $year = $date->format('Y');
        $formattedDate = $date->format('d-m-Y');
        $orderId = $row['order_id'];
        $producto = $row['product_name'];
        $productoVariante = $row['productoVariante'];
        $precio_neto = $row['total'];
        $direccion = $row['direccion'];
        $state = $row['provincia'];
        $pais = $row['pais'];
        $codigopostal = $row['codigopostal'];
        $ciudad = $row['ciudad'];
        $dni = $row['dni'];
        $idFiscal = $row['idFiscal'];

        //datos fiscales
        if (!empty($idFiscal)) {
            $idCliente = $row['idCliente'];
            $nobmbreFiscal = $row['nombreFiscal'];
            $apellidosFiscal = $row['apellidosFiscal'];
            $empresaFiscal = $row['empresaFiscal'];
            $dniFiscal = $row['dniFiscal'];
            $direccionFiscal = $row['direccionFiscal'];
            $ciudadFiscal = $row['ciudadFiscal'];
            $paisFiscal = $row['paisFiscal'];
            $provinciaFiscal = $row['provinciaFiscal'];
        }

        if ($state == 'A') {
            $stateNom = 'Álava';
        } elseif ($state == 'AB') {
            $stateNom = 'Albacete';
        } elseif ($state == 'AL') {
            $stateNom = 'Alicante';
        } elseif ($state == 'AM') {
            $stateNom = 'Almería';
        } elseif ($state == 'O') {
            $stateNom = 'Asturias';
        } elseif ($state == 'AV') {
            $stateNom = 'Ávila';
        } elseif ($state == 'BA') {
            $stateNom = 'Badajoz';
        } elseif ($state == 'PM') {
            $stateNom = 'Baleares';
        } elseif ($state == 'B') {
            $stateNom = 'Barcelona';
        } elseif ($state == 'BU') {
            $stateNom = 'Burgos';
        } elseif ($state == 'CC') {
            $stateNom = 'Cáceres';
        } elseif ($state == 'CA') {
            $stateNom = 'Cádiz';
        } elseif ($state == 'S') {
            $stateNom = 'Cantabria';
        } elseif ($state == 'CS') {
            $stateNom = 'Castellón';
        } elseif ($state == 'CE') {
            $stateNom = 'Ceuta';
        } elseif ($state == 'CR') {
            $stateNom = 'Ciudad Real';
        } elseif ($state == 'CO') {
            $stateNom = 'Córdoba';
        } elseif ($state == 'CU') {
            $stateNom = 'Cuenca';
        } elseif ($state == 'GI') {
            $stateNom = 'Girona';
        } elseif ($state == 'GR') {
            $stateNom = 'Granada';
        } elseif ($state == 'GU') {
            $stateNom = 'Guadalajara';
        } elseif ($state == 'SS') {
            $stateNom = 'Guipúzcoa';
        } elseif ($state == 'H') {
            $stateNom = 'Huelva';
        } elseif ($state == 'HU') {
            $stateNom = 'Huesca';
        } elseif ($state == 'J') {
            $stateNom = 'Jaén';
        } elseif ($state == 'LO') {
            $stateNom = 'La Rioja';
        } elseif ($state == 'GC') {
            $stateNom = 'Las Palmas';
        } elseif ($state == 'LE') {
            $stateNom = 'León';
        } elseif ($state == 'L') {
            $stateNom = 'Lleida';
        } elseif ($state == 'LU') {
            $stateNom = 'Lugo';
        } elseif ($state == 'M') {
            $stateNom = 'Madrid';
        } elseif ($state == 'MA') {
            $stateNom = 'Málaga';
        } elseif ($state == 'ML') {
            $stateNom = 'Melilla';
        } elseif ($state == 'MU') {
            $stateNom = 'Murcia';
        } elseif ($state == 'NA') {
            $stateNom = 'Navarra';
        } elseif ($state == 'OR') {
            $stateNom = 'Ourense';
        } elseif ($state == 'P') {
            $stateNom = 'Palencia';
        } elseif ($state == 'PO') {
            $stateNom = 'Pontevedra';
        } elseif ($state == 'SA') {
            $stateNom = 'Salamanca';
        } elseif ($state == 'TF') {
            $stateNom = 'Santa Cruz de Tenerife';
        } elseif ($state == 'SG') {
            $stateNom = 'Segovia';
        } elseif ($state == 'SE') {
            $stateNom = 'Sevilla';
        } elseif ($state == 'SO') {
            $stateNom = 'Soria';
        } elseif ($state == 'T') {
            $stateNom = 'Tarragona';
        } elseif ($state == 'TE') {
            $stateNom = 'Teruel';
        } elseif ($state == 'TO') {
            $stateNom = 'Toledo';
        } elseif ($state == 'V') {
            $stateNom = 'Valencia';
        } elseif ($state == 'VA') {
            $stateNom = 'Valladolid';
        } elseif ($state == 'BI') {
            $stateNom = 'Vizcaya';
        } elseif ($state == 'ZA') {
            $stateNom = 'Zamora';
        } elseif ($state == 'Z') {
            $stateNom = 'Zaragoza';
        }

        $precio_neto2 = floatval($precio_neto);
        $iva = $row['tax'];
        $iva2 = intval($iva); // Resultado: 456

        // calculo del IVA
        $vatAmount = $precio_neto2 * ($iva2 / 100);
        $vat_redondeado = ceil($vatAmount * 100) / 100;

        $precio_total = $precio_neto2 + $vat_redondeado;


        $payment = $row['payment_method'];
        $invoice_number = $row['invoice_number'];
        $nombre = $row['nombre'];
        $apellidos = $row['apellidos'];

        if ($payment == 1) {
            $paymentMethod = "Transferencia bancaria";
        } elseif ($payment == 2) {
            $paymentMethod = "Tarjeta";
        } elseif ($payment == 3) {
            $paymentMethod = "PayPal";
        }

        $status = $row['status'];
        if ($status == 1) {
            $statusName = "Pendiente de pago";
        } elseif ($status == 2) {
            $statusName = "Pagado";
        } elseif ($status == 3) {
            $statusName = "Cancelado";
        } else {
            $statusName = "";
        }
}

echo 'id fiscal ' . $idFiscal ;

if (!empty($idFiscal)) {
    echo ' ' . $nobmbreFiscal . ' ' . $apellidosFiscal . '<br>';
    echo  'Empresa: ' . $empresaFiscal . ' ';
    if (!empty($dni)) {
        echo 'NIF/CIF: ' . $dniFiscal . '<br>';
    }

    if ($direccion !== "") {
        $html .= '&nbsp;&nbsp;Dirección: '.$direccionFiscal. '<br>
        '.$ciudadFiscal.'';
        if ($paisFiscal == "ES") {
            $html .= ' ('.$provinciaFiscal.') ';
        }
            $html .= ''.$codigopostal.'<br>';
        if ($paisFiscal == "ES") {
            $html .= 'España<br>';
          } else {
            $html .= ''.$paisFiscal.'<br>';
          }
    }
     $html .= '' .$email . '';

} else {
    echo  ' ' . $nombre . ' ' . $apellidos . '<br>';
if (!empty($dni)) {
    $html .= 'DNI/NIF/CIF: ' . $dni . '<br>';
}
}