<?php
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

global $conn2; // Declarar la variable como global
$stmt = $conn2->prepare("SELECT
p2.id as order_id,
p2.date AS date,
p2.status AS status,
p2.invoiceNumber AS invoice_number,
p2.orderTotal AS total,
p2.orderTax AS tax,
p2.paymentType AS payment_method,
p1.post_title AS product_name,
p2.numPago
FROM txsxekgr_intranet.facturas AS p2
LEFT JOIN txsxekgr_esinec.wp_posts AS p1 ON p2.items = p1.ID
WHERE p2.clienteId = :customer_id
GROUP BY p2.id");

$stmt->bindParam(':customer_id', $customer_id);
$stmt->execute();

$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($resultSet) > 0) {
  $html = '<div class="table-responsive" style="margin-top:20px;margin-bottom:25px">';
  $html .= '<table class="table table-striped">';
  $html .= '<thead class="'.TABLE_THREAD.'">';
  $html .= '<tr>
    <th>Número factura</th>
    <th>Fecha</th>
    <th>Producto</th>
    <th>Neto</th>
    <th>IVA</th>
    <th>Total</th>
    <th>Método de pago</th>
    <th>Estado</th>
    <th>Num pago</th>
    <th></th>
    <th></th>';
  $html .= '</tr>';
  $html .= '</thead>';
  $html .= '<tbody>';

  foreach ($resultSet as $row) {
    $date = new DateTime($row['date']);
    $year = $date->format('Y');
    $formattedDate = $date->format('d-m-Y');
    $orderId = $row['order_id'];
    $precio_neto = $row['total'];
    $iva = $row['tax'];

    $ivaPorcentaje = 21; // Porcentaje del IVA

    $iva2 = $precio_neto * ($iva / 100);
    $precio_total = $precio_neto + $iva2;

    $payment = $row['payment_method'];

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

    $html .= '<tr>';
    $html .= '<td>ESINEC.'.$year.'.' . $row['invoice_number'] . '</td>';
    $html .= '<td>' . $formattedDate. '</td>';
    $html .= '<td>' . $row['product_name'] . '</td>';
    $html .= '<td>' . wc_price($precio_neto) . '</td>';
    $html .= '<td>' . wc_price($iva2) . '</td>';
    $html .= '<td>' . wc_price($precio_total) . '</td>';
    $html .= '<td>' . $paymentMethod . '</td>';
    $html .= '<td>' . $statusName . '</td>';
    $html .= '<td>Pago ' . $row['numPago'] . '</td>';
    $html .= '<td><button type="button" onclick="modificarFacturaIntranet('.$orderId.')" id="btnModificarFactura" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalModificarFactura" data-id="'.$orderId. '" value="'.$orderId. '" data-title="'.$orderId. '" data-slug="'.$orderId. '" data-text="'.$orderId. '">Modificar factura</button></td>';
    $html .= '<td><button type="button" id="btnCrearFacturaIntranet'.$orderId.'" class="btn btn-sm btn-warning" onclick="facturasIntranetGenerarPDF('.$orderId.')">PDF</button></td>';
    $html .= '</tr>';
  }

  $html .= '</tbody>';
  $html .= '</table>';
  $html .= '</div>';
} else {
  $html = '<p>No se encontraron facturas adicionales.</p>';
}

// Output the HTML
echo $html;
?>