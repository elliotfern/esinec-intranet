<?php

global $conn;

require_once(APP_ROOT. '/inc/php/functions.php');

echo '<div class="container">';
echo '<h1>Gestión facturación clientes</h1>';
echo '<h1>Totales mensuales</h1>';


// 01 - Consulta SELECT FACTURAS INTRANET
$sql = "SELECT
            DATE_FORMAT(p2.date, '%Y-%m') AS mes,
            SUM(p2.orderTotal) AS total_order_total,
            SUM(p2.totalTax) AS total_order_tax
        FROM
            txsxekgr_intranet.facturas AS p2
        GROUP BY DATE_FORMAT(p2.date, '%Y-%m')
        ORDER BY p2.date DESC";

// Ejecutar la consulta
$stmt = $conn->query($sql);

// Obtener los resultados en un arreglo asociativo
$facturas_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear una nueva array para almacenar los datos con los cálculos adicionales
$facturas_con_calculos = array();


    foreach ($facturas_array as $factura) {
            $total = $factura['total_order_total'] + $factura['total_order_tax'];

            // Agregar los datos a la nueva array
            $factura_con_calculos = array(
                'mes' => $factura['mes'],
                'total_order_total' => $total,
                'total_net' => $factura['total_order_total'],
                'total_order_tax' => $factura['total_order_tax'],
            );

            $facturas_con_calculos[] = $factura_con_calculos;
           }
  
// 2 - Consulta FACTURAS WEB WOOCOMMERCE
// Consulta SELECT TOTAL
$sql = "SELECT
        DATE_FORMAT(p.post_date, '%Y-%m') AS month,
        SUM(CASE WHEN pm.meta_key = '_order_total' THEN pm.meta_value ELSE 0 END) AS total_order_total,
        SUM(CASE WHEN pm.meta_key = '_order_tax' THEN pm.meta_value ELSE 0 END) AS total_order_tax
        FROM
        txsxekgr_esinec.wp_posts AS p
        INNER JOIN txsxekgr_esinec.wp_postmeta AS pm ON p.ID = pm.post_id
        WHERE
        p.post_type = 'shop_order'
        AND (pm.meta_key = '_order_total' OR pm.meta_key = '_order_tax')
        GROUP BY DATE_FORMAT(p.post_date, '%Y-%m')
        ORDER BY p.post_date DESC";

// Ejecutar la consulta
$stmt = $conn->query($sql);

// Obtener los resultados en un arreglo asociativo
$facturasTotal = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear una nueva array para almacenar los datos con los cálculos adicionales
$facturas_wordpress = array();

 foreach ($facturasTotal as $factura) {
        $total_neto = $factura['total_order_total'] - $factura['total_order_tax'];

            // Agregar los datos a la nueva array
            $facturas_wordpress2 = array(
                'mes' => $factura['month'],
                'total_order_total' => $factura['total_order_total'],
                'total_net' => $total_neto,
                'total_order_tax' => $factura['total_order_tax'],
            );

            $facturas_wordpress[] = $facturas_wordpress2;

       }

echo "<hr>";

// Combina las arrays
// Combina los meses sin duplicados
$combinedMonths = array_unique(array_merge(array_column($facturas_con_calculos, 'mes'), array_column($facturas_wordpress, 'mes')));

// Crea una nueva array combinada sin duplicados de meses
$combinedArray = array();
foreach ($combinedMonths as $month) {
    $combinedRow = array(
        'mes' => $month,
        'total_order_total' => 0,
        'total_net' => 0,
        'total_order_tax' => 0
    );

    foreach ($facturas_con_calculos as $row) {
        if ($row['mes'] === $month) {
            $combinedRow['total_order_total'] += $row['total_order_total'];
            $combinedRow['total_net'] += $row['total_net'];
            $combinedRow['total_order_tax'] += $row['total_order_tax'];
        }
    }

    foreach ($facturas_wordpress as $row) {
        if ($row['mes'] === $month) {
            $combinedRow['total_order_total'] += $row['total_order_total'];
            $combinedRow['total_net'] += $row['total_net'];
            $combinedRow['total_order_tax'] += $row['total_order_tax'];
        }
    }

    $combinedArray[] = $combinedRow;
}

// Función para obtener el nombre del mes en español
function obtenerNombreMes($mes) {
    $nombresMeses = array(
        '01' => 'enero',
        '02' => 'febrero',
        '03' => 'marzo',
        '04' => 'abril',
        '05' => 'mayo',
        '06' => 'junio',
        '07' => 'julio',
        '08' => 'agosto',
        '09' => 'septiembre',
        '10' => 'octubre',
        '11' => 'noviembre',
        '12' => 'diciembre'
    );
    return $nombresMeses[$mes];
}

// Función de comparación para ordenar los meses en orden descendente
function compararMesesDescendente($a, $b) {
    return strcmp($b['mes'], $a['mes']);
}

// Ordenar la array combinada por meses en orden descendente
usort($combinedArray, 'compararMesesDescendente');

// Imprime la tabla HTML
echo '<div class="'.TABLE_DIV_CLASS.'">
<table class="table table-striped datatable">
    <thead class="'.TABLE_THREAD.'">
<tr>
        <th>Mes</th>
        <th>Total neto</th>
        <th>Importe IVA</th>
        <th>Total (neto+IVA)</th>
    </tr>
    </thead>';
    
foreach ($combinedArray as $row) {
    $fecha = strtoupper(obtenerNombreMes(substr($row['mes'], 5))) . ' - ' . substr($row['mes'], 0, 4);
    echo '<tbody>
    <tr>';
    echo '<td><strong>' . $fecha . '</strong></td>';
    echo '<td><strong>' . wc_price($row['total_net'] ). '</strong></td>';
    echo '<td>' . wc_price($row['total_order_tax']) . '</td>';
    echo '<td>' . wc_price($row['total_order_total'] ). '</td>';
    echo '</tr>';
}
echo '</tbody>
</table></div>';

echo "</div>";

# footer
include_once(APP_ROOT. '/inc/footer.php');