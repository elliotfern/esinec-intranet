<?php
global $conn;

function wc_price( $price ) {
    $currency_symbol = '€'; // replace with your currency symbol
    $decimal_separator = ','; // replace with your decimal separator
    $thousands_separator = '.'; // replace with your thousands separator
    
    $price = number_format( $price, 2, $decimal_separator, $thousands_separator );
    
    return $price . $currency_symbol;
}


echo '<div class="container">';
echo '<h1>Gestión de comerciales ESINEC</h1>';
echo '<h1>Pagos mensuales</h1>';

echo "<hr>";
echo '<h3>Aitor:</h3>';

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
        FROM (
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Aitor'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL
            
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Aitor'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 5 THEN comision1 + comision2
                        WHEN comisionista1 = 5 THEN comision1
                        ELSE comision2 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 2 OR comisionista2 = 2
            GROUP BY mes
        ) AS combined_data
        GROUP BY mes
        ORDER BY mes";

    // Ejecutar la consulta
    $stmt = $conn->query($sql);

    // Obtener los resultados en un arreglo asociativo
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($resultados)) {
    echo "<div class='table-responsive' style='margin-top:20px;margin-bottom:25px'>";
    echo "<table class='table table-striped'>";
    echo "<thead class='".TABLE_THREAD."'>";
    echo '<tr>
        <th>Fecha</th>
        <th>Total facturas</th>
        <th>Total importe comisión</th>

        <th></th>
        </tr>
        </thead>
        <tbody>';

    foreach ($resultados as $fila) {
        $mes = $fila['mes'];
        $total_facturas_sum = $fila['total_facturas_sum'];
        $total_comision_sum = $fila['total_comision_sum'];

        echo '<tr>';
        echo '<td>'.$mes.'</td>';
        echo '<td>' . $total_facturas_sum . '</td>';
        echo '<td>' . wc_price($total_comision_sum) . '</td>';
        echo '<td></td>';
        echo '</tr>';
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo '';
}


echo "<hr>";
echo '<h3>Gemma:</h3>';

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
        FROM (
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Gemma'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL
            
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Gemma'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 5 THEN comision1 + comision2
                        WHEN comisionista1 = 5 THEN comision1
                        ELSE comision2 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 9 OR comisionista2 = 9
            GROUP BY mes
        ) AS combined_data
        GROUP BY mes
        ORDER BY mes";

    // Ejecutar la consulta
    $stmt = $conn->query($sql);

    // Obtener los resultados en un arreglo asociativo
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($resultados)) {
    echo "<div class='table-responsive' style='margin-top:20px;margin-bottom:25px'>";
    echo "<table class='table table-striped'>";
    echo "<thead class='".TABLE_THREAD."'>";
    echo '<tr>
        <th>Fecha</th>
        <th>Total facturas</th>
        <th>Total importe comisión</th>

        <th></th>
        </tr>
        </thead>
        <tbody>';

    foreach ($resultados as $fila) {
        $mes = $fila['mes'];
        $total_facturas_sum = $fila['total_facturas_sum'];
        $total_comision_sum = $fila['total_comision_sum'];

        echo '<tr>';
        echo '<td>'.$mes.'</td>';
        echo '<td>' . $total_facturas_sum . '</td>';
        echo '<td>' . wc_price($total_comision_sum) . '</td>';
        echo '<td></td>';
        echo '</tr>';
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo '';
}
    

echo "<hr>";
echo '<h3>Brian:</h3>';

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
FROM (
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/2) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_1'
      AND p1.meta_value = 'Braian-Cesc'
      AND p2.meta_key = 'comision_1'
    GROUP BY mes

    UNION ALL

    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/2) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_2'
      AND p1.meta_value = 'Braian-Cesc'
      AND p2.meta_key = 'comision_2'
    GROUP BY mes

    UNION ALL
    
     SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_1'
      AND p1.meta_value = 'Braian-Carmeta-Sil'
      AND p2.meta_key = 'comision_1'
    GROUP BY mes

    UNION ALL
    
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_2'
      AND p1.meta_value = 'Braian-Carmeta-Sil'
      AND p2.meta_key = 'comision_2'
    GROUP BY mes

    UNION ALL
    
     SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_1'
      AND p1.meta_value = 'Braian'
      AND p2.meta_key = 'comision_1'
    GROUP BY mes

    UNION ALL
    
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_2'
      AND p1.meta_value = 'Braian'
      AND p2.meta_key = 'comision_2'
    GROUP BY mes

    UNION ALL
       
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_1'
      AND p1.meta_value = 'Braian-Cesc-Sil'
      AND p2.meta_key = 'comision_1'
    GROUP BY mes

    UNION ALL
    
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_2'
      AND p1.meta_value = 'Braian-Cesc-Sil'
      AND p2.meta_key = 'comision_2'
    GROUP BY mes

    UNION ALL
    
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_1'
      AND p1.meta_value = 'Abraham-Brain-Vanesa'
      AND p2.meta_key = 'comision_1'
    GROUP BY mes

    UNION ALL
    
     SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_2'
      AND p1.meta_value = 'Abraham-Brain-Vanesa'
      AND p2.meta_key = 'comision_2'
    GROUP BY mes

    UNION ALL

    SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
       SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 2 THEN comision1 + comision2
                WHEN comisionista1 = 2 THEN comision1
                ELSE comision2 END) AS total_comision,
        COUNT(id) AS total_facturas
    FROM txsxekgr_intranet.facturas
    WHERE comisionista1 = 5 OR comisionista2 = 5
    GROUP BY mes
    ORDER BY mes
) AS combined_data
GROUP BY mes
ORDER BY mes";

    // Ejecutar la consulta
    $stmt = $conn->query($sql);

    // Obtener los resultados en un arreglo asociativo
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($resultados)) {
    echo "<div class='table-responsive' style='margin-top:20px;margin-bottom:25px'>";
    echo "<table class='table table-striped'>";
    echo "<thead class='".TABLE_THREAD."'>";
    echo '<tr>
        <th>Fecha</th>
        <th>Total facturas</th>
        <th>Total importe comisión</th>

        <th></th>
        </tr>
        </thead>
        <tbody>';

    foreach ($resultados as $fila) {
        $mes = $fila['mes'];
        $total_facturas_sum = $fila['total_facturas_sum'];
        $total_comision_sum = $fila['total_comision_sum'];

        echo '<tr>';
        echo '<td>'.$mes.'</td>';
        echo '<td>' . $total_facturas_sum . '</td>';
        echo '<td>' . wc_price($total_comision_sum) . '</td>';
        echo '<td></td>';
        echo '</tr>';
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo '';
}
    

echo '</div>';


include_once('modals-comerciales.php');

# footer
include_once(APP_ROOT. '/inc/footer.php');