<?php

// woocommerce restful api get customer all orders with meta key wcpdf_invoice_number
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$url_server = "https://" . $_SERVER['HTTP_HOST'];

require_once($rootDirectory . '/vendor/tcpdf/tcpdf.php');

$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
}

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
WHERE p2.id = :orderId
GROUP BY p2.id"); 

$stmt->bindParam(':orderId', $orderId); // Change :id to :orderId
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

        $stateNames = array(
            'A' => 'Álava',
            'AB' => 'Albacete',
            'AL' => 'Alicante',
            'AM' => 'Almería',
            'O' => 'Asturias',
            'AV' => 'Ávila',
            'BA' => 'Badajoz',
            'PM' => 'Baleares',
            'B' => 'Barcelona',
            'BU' => 'Burgos',
            'CC' => 'Cáceres',
            'CA' => 'Cádiz',
            'S' => 'Cantabria',
            'CS' => 'Castellón',
            'CE' => 'Ceuta',
            'CR' => 'Ciudad Real',
            'CO' => 'Córdoba',
            'CU' => 'Cuenca',
            'GI' => 'Girona',
            'GR' => 'Granada',
            'GU' => 'Guadalajara',
            'SS' => 'Guipúzcoa',
            'H' => 'Huelva',
            'HU' => 'Huesca',
            'J' => 'Jaén',
            'LO' => 'La Rioja',
            'GC' => 'Las Palmas',
            'LE' => 'León',
            'L' => 'Lleida',
            'LU' => 'Lugo',
            'M' => 'Madrid',
            'MA' => 'Málaga',
            'ML' => 'Melilla',
            'MU' => 'Murcia',
            'NA' => 'Navarra',
            'OR' => 'Ourense',
            'P' => 'Palencia',
            'PO' => 'Pontevedra',
            'SA' => 'Salamanca',
            'TF' => 'Santa Cruz de Tenerife',
            'SG' => 'Segovia',
            'SE' => 'Sevilla',
            'SO' => 'Soria',
            'T' => 'Tarragona',
            'TE' => 'Teruel',
            'TO' => 'Toledo',
            'V' => 'Valencia',
            'VA' => 'Valladolid',
            'BI' => 'Vizcaya',
            'ZA' => 'Zamora',
            'Z' => 'Zaragoza'
        );
        
        if (isset($stateNames[$state]) || isset($stateNames[$provinciaFiscal])) {
            $stateNom = isset($stateNames[$state]) ? $stateNames[$state] : $stateNames[$provinciaFiscal];
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


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create a new TCPDF instance
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8'); // Use the custom MYPDF class

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

// Add styles for the table
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

            ul {
                list-style: none;
              }
          </style>';

$html = '
<br><br><br><br><br><br><br><br><br>
<div class="container">
<strong>Número de factura: ESINEC.' . $year . '.' . $invoice_number . '</strong><br>
Fecha de la factura: ' . $formattedDate . '<br>
Método de pago: ' . $paymentMethod . '
</div>';

$html .= '<div class="container">
  <table class="table">
          <thead>
          <tr>
            <th>
                <strong>Facturado a:</strong><br>';
                if (!empty($idFiscal)) {
                    $html .= $nobmbreFiscal . ' ' . $apellidosFiscal . '<br>';
                    $html .= 'Empresa: ' . $empresaFiscal . '<br>';
                    
                    if (!empty($dniFiscal)) {
                        $html .= 'NIF/CIF: ' . $dniFiscal . '<br>';
                    }
                
                    if ($direccionFiscal !== "") {
                        $html .= 'Dirección: ' . $direccionFiscal . '<br>';
                        $html .= $ciudadFiscal ;
                        
                        if ($paisFiscal == "ES") {
                            $html .= ' (' . $stateNom . ') <br>';
                        }
                        
                        if ($paisFiscal == "ES") {
                            $html .= 'España' .'<br>';
                        } else {
                            $html .= $paisFiscal . '<br>';
                        } 
                    }

                } else {
                    $html .= ' ' . $nombre . ' ' . $apellidos . '<br>';
                if (!empty($dni)) {
                    $html .= 'DNI/NIF/CIF: ' . $dni . '<br>';
                }

                if ($direccion !== "") {
                    $html .= '&nbsp;&nbsp;Dirección: '.$direccion. '<br>
                    '.$ciudad.'';
                    if ($pais == "ES") {
                        $html .= ' ('.$stateNom.') ';
                    }
                        $html .= ''.$codigopostal.'<br>';
                    if ($pais == "ES") {
                        $html .= 'España<br>';
                      } else {
                        $html .= ''.$pais.'<br>';
                      }
                }
                    $html .= '' .$email . '';
                }

                $html .= ' </th>
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
    $html .= '<tr><td style="padding: 5px; border: 1px solid black;">' . $producto . ' ';
    if (!empty($productoVariante)) {
        $html .= ' - ' . $productoVariante . '';
    }
    $html .= '</td>
                    <td style="padding: 5px; border: 1px solid black;">'.wc_price($precio_neto).' </td>
               </tr>';
$html .= '</tbody>                       
        </table>
    </div>
</div>';

$html .= '<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">SubTotal (sin IVA)</th>
                <th scope="col">'. wc_price($precio_neto).' </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">IVA '.$iva.'%</th>
                <td>'. wc_price($vat_redondeado).' </td>
            </tr>
            <tr>
                <th scope="row">Total</th>
                <td><strong>'. wc_price($precio_total).' </strong></td>
            </tr>
        </tbody>
    </table>
</div>';

if ($payment == 1) {
    $html .= '
  <div class="container">
  <h5 style="text-align: center;">PAGO POR TRANSFERENCIA BANCARIA
  <span style="text-align: center;">CAIXABANK<br>
  IBAN: ES0221000725930200215943<br>
  BIC-SWIFT: CAIXESBBXXX</h5></span>
  </div>';
} elseif ($payment == 2) {
    $html .= '
  <div class="container">
  <h5 style="text-align: center;">PAGO POR TARJETA</h5>
  </div>';
} elseif ($payment == 3) {
    $html .= '
  <div class="container">
  <h5 style="text-align: center;">PAGO POR PAYPAL</h5>
  </div>';
}

$html .= '<div class="container">
<h6>PROTECCIÓN DE DATOS: De conformidad con lo dispuesto en las normativas vigentes en protección de datos personales, el
Reglamento (UE) 2016/679 de 27 de abril de 2016 (GDPR) y la Ley Orgánica (ES) 15/1999 de 13 de diciembre (LOPD), le
informamos que sus datos, serán tratados bajo la responsabilidad de ESCUELA SUPERIOR DE INTELIGENCIA EMOCIONAL
Y COACHING, S.L para la gestión de la relación comercial establecida y se conservarán mientras exista un interés mutuo para
ello. Los datos no serán comunicados a terceros, salvo obligación legal. Le informamos que puede ejercer los derechos de
acceso, rectificación, portabilidad y supresión de sus datos y los de limitación y oposición a su tratamiento enviando un
mensaje al correo electrónico a info@esinec.com. Si considera que el tratamiento no se ajusta a la normativa vigente, podrá
presentar una reclamación ante la autoridad de control en www.agpd.es.</h6>
</div>';


// Output the HTML as PDF content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output the PDF document
$pdf->Output('example.pdf', 'I');
?>