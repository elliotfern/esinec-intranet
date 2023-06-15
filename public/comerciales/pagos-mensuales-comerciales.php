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

            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 3) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Cesc-Gemma-Sil'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 3) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Cesc-Gemma-Sil'
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

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 8 THEN (comision1 + comision2) / 2
                        WHEN comisionista1 = 8 THEN comision1 / 2
                        ELSE comision2 / 2 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 8 OR comisionista2 = 8
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
// 3, 4, 6

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
FROM (
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/2) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_1' AND p1.meta_value = 'Braian-Cesc' AND p2.meta_key = 'comision_1'
    GROUP BY mes

    UNION ALL

    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/2) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_2' AND p1.meta_value = 'Braian-Cesc' AND p2.meta_key = 'comision_2'
    GROUP BY mes

    UNION ALL
    
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_1' AND p1.meta_value = 'Braian-Carmeta-Sil' AND p2.meta_key = 'comision_1'
    GROUP BY mes

    UNION ALL
    
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_2' AND p1.meta_value = 'Braian-Carmeta-Sil' AND p2.meta_key = 'comision_2'
    GROUP BY mes

    UNION ALL
    
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_1' AND p1.meta_value = 'Braian' AND p2.meta_key = 'comision_1'
    GROUP BY mes

    UNION ALL
    
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_2' AND p1.meta_value = 'Braian' AND p2.meta_key = 'comision_2'
    GROUP BY mes

    UNION ALL
       
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_1' AND p1.meta_value = 'Braian-Cesc-Sil' AND p2.meta_key = 'comision_1'
    GROUP BY mes

    UNION ALL
    
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_2' AND p1.meta_value = 'Braian-Cesc-Sil' AND p2.meta_key = 'comision_2'
    GROUP BY mes

    UNION ALL
    
    SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_1' AND p1.meta_value = 'Abraham-Braian-Vanesa' AND p2.meta_key = 'comision_1'
    GROUP BY mes

    UNION ALL
    
     SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
           SUM(p2.meta_value/3) AS total_comision, COUNT(p.ID) AS total_facturas
    FROM txsxekgr_esinec.wp_postmeta p1
    JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
    JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
    WHERE p1.meta_key = 'comisionista_2' AND p1.meta_value = 'Abraham-Braian-Vanesa' AND p2.meta_key = 'comision_2'
    GROUP BY mes
    
    UNION ALL
    SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
       SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 5 THEN (comision1 + comision2) / 2
                WHEN comisionista1 = 5 THEN comision1 / 2
                ELSE comision2 / 2 END) AS total_comision,
        COUNT(id) AS total_facturas
    FROM txsxekgr_intranet.facturas
    WHERE comisionista1 = 5 OR comisionista2 = 5
    GROUP BY mes
    ORDER BY mes
  
    ) AS combined_data
GROUP BY mes
ORDER BY mes;";

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
echo '<h3>Abraham:</h3>';

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
        FROM (
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 3) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Abraham-Braian-Vanesa'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL
            
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 3) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Abraham-Braian-Vanesa'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 5 THEN (comision1 + comision2) / 3
                        WHEN comisionista1 = 1 / 3 THEN comision1
                        ELSE comision2 / 3 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 1 OR comisionista2 = 1
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
echo '<h3>Vanesa:</h3>';

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
        FROM (
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 3) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Abraham-Braian-Vanesa'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL
            
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 3) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Abraham-Braian-Vanesa'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 5 THEN (comision1 + comision2) / 3
                        WHEN comisionista1 = 1 THEN comision1 / 3
                        ELSE comision2 / 3 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 1 OR comisionista2 = 1
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
echo '<h3>Juanjo:</h3>';

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
        FROM (
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Juanjo'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL
            
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Juanjo'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 10 THEN (comision1 + comision2)
                        WHEN comisionista1 = 10 THEN comision1
                        ELSE comision2 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 10 OR comisionista2 = 10
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
echo '<h3>Lihan:</h3>';

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
        FROM (
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Lihan'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL
            
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Lihan'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 11 THEN (comision1 + comision2)
                        WHEN comisionista1 = 11 THEN comision1
                        ELSE comision2 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 11 OR comisionista2 = 11
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
echo '<h3>Manu:</h3>';

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
        FROM (
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Manu'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL
            
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Manu'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 12 THEN (comision1 + comision2)
                        WHEN comisionista1 = 12 THEN comision1
                        ELSE comision2 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 12 OR comisionista2 = 12
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

echo '<h3>Cesc:</h3>';

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
        FROM (
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 2) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Braian-Cesc'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL
            
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 2) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Braian-Cesc'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 5 THEN (comision1 + comision2) / 2
                        WHEN comisionista1 = 5 THEN comision1 / 2
                        ELSE comision2 / 2 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 5 OR comisionista2 = 5
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 3) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Braian-Cesc-Sil'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 3) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Braian-Cesc-Sil'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 6 THEN (comision1 + comision2) / 3
                        WHEN comisionista1 = 6 THEN comision1 / 3
                        ELSE comision2 / 3 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 6 OR comisionista2 = 6
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Cesc'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Cesc'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 7 THEN (comision1 + comision2)
                        WHEN comisionista1 = 7 THEN comision1 
                        ELSE comision2  END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 7 OR comisionista2 = 7
            GROUP BY mes

            UNION ALL
            
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value / 3) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Cesc-Gemma-Sil'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 8 THEN (comision1 + comision2) / 3
                        WHEN comisionista1 = 8 THEN comision1 / 3
                        ELSE comision2 / 3 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 8 OR comisionista2 = 8
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
echo '<h3>Alexcomunica:</h3>';

// Consulta SELECT
$sql = "SELECT mes, SUM(total_comision) AS total_comision_sum, SUM(total_facturas) AS total_facturas_sum
        FROM (
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_1'
            AND p1.meta_value = 'Alexcomunica'
            AND p2.meta_key = 'comision_1'
            GROUP BY mes

            UNION ALL
            
            SELECT DATE_FORMAT(p.post_date, '%Y-%m') AS mes,
                SUM(p2.meta_value) AS total_comision, COUNT(p.ID) AS total_facturas
            FROM txsxekgr_esinec.wp_postmeta p1
            JOIN txsxekgr_esinec.wp_postmeta p2 ON p1.post_id = p2.post_id
            JOIN txsxekgr_esinec.wp_posts p ON p1.post_id = p.ID
            WHERE p1.meta_key = 'comisionista_2'
            AND p1.meta_value = 'Alexcomunica'
            AND p2.meta_key = 'comision_2'
            GROUP BY mes

            UNION ALL

            SELECT DATE_FORMAT(date, '%Y-%m') AS mes,
            SUM(CASE WHEN comisionista1 = comisionista2 AND comisionista1 = 13 THEN (comision1 + comision2)
                        WHEN comisionista1 = 13 THEN comision1
                        ELSE comision2 END) AS total_comision, COUNT(id) AS total_facturas
            FROM txsxekgr_intranet.facturas
            WHERE comisionista1 = 13 OR comisionista2 = 13
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


echo '</div>';




include_once('modals-comerciales.php');

# footer
include_once(APP_ROOT. '/inc/footer.php');