<?php

// woocommerce restful api get customer all orders with meta key wcpdf_invoice_number
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$url_server = "https://" . $_SERVER['HTTP_HOST'];

$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once($rootDirectory . '/vendor/autoload.php');

use Automattic\WooCommerce\Client;

require_once($rootDirectory . '/vendor/tcpdf/tcpdf.php');

if(isset($_GET['id'])){
    $facturaId = $_GET['id'];
}

function wc_price( $price ) {
  $currency_symbol = '€'; // replace with your currency symbol
  $decimal_separator = ','; // replace with your decimal separator
  $thousands_separator = '.'; // replace with your thousands separator
  
  $price = number_format( $price, 2, $decimal_separator, $thousands_separator );
  
  return $price . $currency_symbol;
}

// Authenticate with the API
$woocommerce = new Client(
  'https://esinec.com/',
    WC_API_KEY, 
    WC_API_SECRET,
  [
      'version' => 'wc/v3',
  ]
);

// Get the order ID from the query string
$order_id = $facturaId;

// Retrieve the order from the WooCommerce API
$order = $woocommerce->get('orders/' . $order_id);

// Get the meta data for the order
$meta_data = $order->meta_data;

// Initialize variables
$invoiceNumber = '';
$nif = '';
$items = '';
$date = '';
$payment_method = '';

// Loop through the meta data and extract values
foreach ($meta_data as $meta) {
  if ($meta->key === '_wcpdf_invoice_number') {
    $wcpdf_invoice_number = $meta->value;
    break;
  }
}

// Get order details
$createDate = new DateTime($order->date_created);
$createDate_format = $createDate->format('d-m-Y');
$any = $createDate->format('Y');
$payment_method = $order->payment_method_title;
$items = $order->line_items;
$customer_id = $order->customer_id;

$string = $wcpdf_invoice_number;
$parts = explode(".", $string);

if (count($parts) === 3) {
    $invoice_number = $parts[0] . "." . $parts[2] . "." . $parts[1];
} else {
}


// SACAR DATOS DEL CLIENTE
$url = 'https://esinec.com/wp-json/wc/v3/customers/' . $customer_id;

// Configurar la autenticación
$auth = base64_encode(WC_API_KEY. ':' . WC_API_SECRET);

// Configurar la solicitud cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Basic ' . $auth
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Realizar la solicitud GET
$response = curl_exec($ch);

// Verificar si hubo errores en la solicitud
if (curl_errno($ch)) {
    $error_message = curl_error($ch);
    echo "Error: " . $error_message;
} else {
    // Solicitud exitosa
    $customer_data = json_decode($response);

    // Obtener los datos del cliente
    $billing_address = $customer_data->billing->address_1;
    $billing_city = $customer_data->billing->city;
    $state = $customer_data->billing->state;
    $billing_postcode = $customer_data->billing->postcode;
    $billing_country = $customer_data->billing->country;
    $phone = $customer_data->billing->phone;

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


     // Obtener los metadatos del cliente
     $metadata = $customer_data->meta_data;

     // Buscar el metadato "_billing_nif"
     foreach ($metadata as $meta) {
         if ($meta->key === 'billing_nif') {
             $billing_nif = $meta->value;
             break;
         }
     }
}

// Cerrar la conexión cURL
curl_close($ch);

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

  // Page footer
  public function Footer() {
      // Position at 15 mm from bottom
      $this->SetY(-15);
      // Set font
      $this->SetFont('helvetica', 'I', 8);
      // Page number
      $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }
}

// Create a new TCPDF instance
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

// Set the document information
$pdf->SetCreator('ESINEC');
$pdf->SetAuthor('ESINEC');
$pdf->SetTitle('ESINEC PDF');

// Add a page
$pdf->AddPage();

// Add the image to the PDF
$imagePath = $url_server . '/inc/img/logo.png';
$pdf->Image($imagePath, $x = 10, $y = 10, $w = 100, $h = 0, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = '');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Write HTML content to the PDF

// Agregar estilos CSS para la tabla
$styles = '<style>
            .table-custom thead tr {
                background-color: black;
                color: white;
            }

            .table,
            .table th,
            .table td {
                padding: 5px;
                border: 1px solid black;
            }
          </style>';
          
$html = '
<br><br><br><br><br><br><br><br><br>
<div class="container">
<strong>Número de factura: '.$wcpdf_invoice_number.'</strong><br>
Fecha de la factura: '.$createDate_format.'<br>
Método de pago: '.$payment_method.'
</div>';

$html .= '<div class="container">
  <table class="table">
          <thead>
          <tr>
            <th>
                <strong>Facturado a:</strong><br>
               '.$order->billing->first_name . ' '  . $order->billing->last_name .'<br>';
               if (!empty($billing_nif)) {
                $html .= 'DNI/NIF/CIF: '.$billing_nif.'<br>';
                }

                if (!empty($billing_address)) {
                  $html .= 'Dirección: '.$billing_address .'<br>
                  '.$billing_city .'';
                  if ($billing_country == "ES") {
                      $html .= ' ('.$stateNom.') ';
                  }
                      $html .= ''.$billing_postcode .'<br>';
                  if ($billing_country == "ES") {
                    $html .= 'España<br>';
                  } else {
                    $html .= ''.$billing_country.'<br>';
                  }
                }           
                $html .= '' . $order->billing->email . '
            </th>
            <th>
            <strong>ESINEC S.L</strong><br>
            CIF: B-66821802<br>
            Carrer Muntaner, 200 4º 6ª<br>
            Barcelona, (CP: 08036)<br>
            España
            </th>
          </tr>
          </thead>
  </table>
</div>';

$html = $styles . $html;
$html .= '
<div class="container">
<h2 style="text-align: center;"><strong>DETALLES DE LA FACTURA</strong></h2>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr style="background-color: black; color: white;">
                    <th style="padding: 5px; border: 1px solid black;">Producto</th>
                    <th style="padding: 5px; border: 1px solid black;">Precio sin IVA</th>
                </tr>
            </thead>
            <tbody>';

foreach ($items as $item) {
    $html .= '<tr>
                    <td style="padding: 5px; border: 1px solid black;">' . $item->name . ' ';
                    if (!empty($item->notes)) {
                        $html .= '(' . $item->notes . ')';
                    }
                    $html .= '</td>
                    <td style="padding: 5px; border: 1px solid black;">€' . $item->price . '</td>
               </tr>';
}

$html .= '</tbody>                       
        </table>
    </div>
</div>';

$subtotal = 0;
$vatAmount = 0;
$total = 0;

foreach ($items as $item) {
    $subtotal += $item->subtotal;
    $vatAmount += $item->subtotal_tax;
}

$total = $subtotal + $vatAmount;

$html .= '<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">SubTotal (sin IVA)</th>
                <th scope="col">€' . wc_price($subtotal) . '</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">IVA</th>
                <td>€' . wc_price($vatAmount) . '</td>
            </tr>
            <tr>
                <th scope="row">Total</th>
                <td><strong>€' . wc_price($total) . '</strong></td>
            </tr>
        </tbody>
    </table>
</div>';

if ($payment_method == "Transferencia bancaria") {
    $html .= '
  <div class="container">
  <h5 style="text-align: center;">PAGO POR TRANSFERENCIA BANCARIA
  <span style="text-align: center;">CAIXABANK<br>
  IBAN: ES0221000725930200215943<br>
  BIC-SWIFT: CAIXESBBXXX</h5></span>
  </div>';
} elseif ($payment_method == "Tarjeta (terminal)") {
    $html .= '
  <div class="container">
  <h5 style="text-align: center;">PAGADO POR TARJETA</h5>
  </div>';
} elseif ($payment_method == "Paypal") {
    $html .= '
  <div class="container">
  <h5 style="text-align: center;">PAGADO POR PAYPAL</h5>
  </div>';
}

// Establecer el espaciado vertical entre las celdas
$pdf->SetHtmlVSpace(array(0, 0, 0, 0));

// Agregar el contenido HTML a través de la función writeHTML()
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF as a downloadable file
$pdf->Output('invoice_'.$invoiceNumber.'.pdf', 'D');
?>