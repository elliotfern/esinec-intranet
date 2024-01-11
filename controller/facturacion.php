<?php
session_start(); // Iniciar sesión (asegúrate de colocar esto al principio de tu archivo PHP si aún no se ha iniciado la sesión)

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$root_server= $_SERVER['SERVER_NAME'];

$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

// JSON
if ( (isset($_GET['type']) && $_GET['type'] == 'facturas') ) {

    global $conn2;
    $data = array();
    $stmt = $conn2->prepare("SELECT
    p.ID as order_id,
    p.post_date, p.post_status,
    max( CASE WHEN pm.meta_key = '_wcpdf_invoice_number' and p.ID = pm.post_id THEN pm.meta_value END ) as invoice_number,
    max( CASE WHEN pm.meta_key = '_billing_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_first_name,
    max( CASE WHEN pm.meta_key = '_billing_last_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_last_name,
    max( CASE WHEN pm.meta_key = '_order_total' and p.ID = pm.post_id THEN pm.meta_value END ) as order_total,
    max( CASE WHEN pm.meta_key = '_order_tax' and p.ID = pm.post_id THEN pm.meta_value END ) as order_tax,
    max( CASE WHEN pm.meta_key = '_payment_method_title' and p.ID = pm.post_id THEN pm.meta_value END ) as payment_type,
    ( select group_concat( order_item_name separator '|' ) from wp_woocommerce_order_items where order_id = p.ID ) as order_items
    from txsxekgr_esinec.wp_posts AS p 
        join txsxekgr_esinec.wp_postmeta AS pm on p.ID = pm.post_id
        join txsxekgr_esinec.wp_woocommerce_order_items AS oi on p.ID = oi.order_id
    where p.post_type = 'shop_order'
    group by p.ID

    UNION
(SELECT
    p2.id as order_id,
    p2.date AS post_date,
    p2.status AS post_status,
    p2.invoiceNumber AS invoice_number,
    umf.meta_value AS first_name,
    uml.meta_value AS last_name,
    p2.orderTotal AS order_total,
    p2.orderTax AS order_tax,
    p2.paymentType AS paymentType,
    p.post_title AS items
FROM txsxekgr_intranet.facturas AS p2
JOIN txsxekgr_esinec.wp_posts AS p ON p2.items = p.ID
LEFT JOIN
    txsxekgr_esinec.wp_usermeta AS umf ON p2.clienteId = umf.user_id AND umf.meta_key = 'first_name'
LEFT JOIN
    txsxekgr_esinec.wp_usermeta AS uml ON p2.clienteId = uml.user_id AND uml.meta_key = 'last_name'
GROUP BY
    p2.id)
ORDER BY post_date DESC");
        $stmt->execute();
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);

} elseif ( (isset($_GET['type']) && $_GET['type'] == 'pagos-programados') ) {

    global $conn2;
    $data = array();
    $stmt = $conn2->prepare("SELECT p.cliente, SUM(importe) AS importe, m.meta_value as first_name, m2.meta_value as last_name
    FROM txsxekgr_intranet.pagos_programados AS p
    JOIN txsxekgr_esinec.wp_users AS u ON p.cliente = u.ID
        LEFT JOIN txsxekgr_esinec.wp_usermeta m ON u.ID = m.user_id AND m.meta_key = 'first_name'
        LEFT JOIN txsxekgr_esinec.wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'last_name'
    WHERE p.estado = 1
    GROUP BY p.cliente");
        $stmt->execute();
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);

} elseif ( (isset($_GET['type']) && $_GET['type'] == 'pagos-programados-mensuales') ) {
    global $conn2;
    $data = array();
    $stmt = $conn2->prepare("SELECT 
        DATE_FORMAT(p.fecha, '%Y/%m') AS mes_ano,
        SUM(CASE WHEN p.estado IN (1, 2) THEN p.importe ELSE 0 END) AS pagos_totales,
        SUM(CASE WHEN p.estado = 1 THEN p.importe ELSE 0 END) AS pagos_pendientes,
        SUM(CASE WHEN p.estado = 2 THEN p.importe ELSE 0 END) AS pagos_completados,
        COUNT(p.ID) AS total_pagos
    FROM txsxekgr_intranet.pagos_programados AS p
    GROUP BY mes_ano DESC;");
        $stmt->execute();
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);


}  elseif ( (isset($_GET['type']) && $_GET['type'] == 'pago-programado') && (isset($_GET['id']) ) ) {
    global $conn2;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn2->prepare("SELECT p.cliente, p.importe AS importe, u.user_email AS email, pro.post_title AS producto, p.fecha, p.numPago, p.estado, p.tipoPago
    FROM txsxekgr_intranet.pagos_programados AS p
    JOIN txsxekgr_esinec.wp_users AS u ON p.cliente = u.ID
    JOIN txsxekgr_esinec.wp_posts AS pro ON p.producto = pro.ID
    WHERE p.id = $id");
        $stmt->execute();
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);

}  elseif ( (isset($_GET['type']) && $_GET['type'] == 'factura-intranet-cliente') && (isset($_GET['id']) ) ) {
    global $conn;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn->prepare("SELECT
    p2.date AS fecha,
    p2.clienteId AS clienteId,
    p2.status AS status,
    p2.invoiceNumber AS invoice_number,
    p2.orderTotal AS total,
    p2.orderTax AS tax,
    p2.paymentType AS payment_method,
    p2.numPago,
    p2.productoVariante AS productoVariante,
    p2.items AS producto,
    p2.notas AS notas,
    p2.comision1 AS comision1,
    p2.comision2 AS comision2,
    p2.comisionista1 AS comisionista1,
    p2.comisionista2 AS comisionista2,
    umf.meta_value AS nombre,
    uml.meta_value AS apellidos,
    p1.post_title AS productoNombre,
    um3.meta_value AS direccion,
    um4.meta_value AS provincia,
    um5.meta_value AS pais,
    um6.meta_value AS codigopostal,
    um7.meta_value AS ciudad,
    um8.meta_value AS dni,
    um9.meta_value AS telefono,
    um10.meta_value AS email
    FROM txsxekgr_intranet.facturas AS p2
    LEFT JOIN txsxekgr_esinec.wp_posts AS p1 ON p2.items = p1.ID
    LEFT JOIN txsxekgr_esinec.wp_usermeta AS umf ON p2.clienteId = umf.user_id AND umf.meta_key = 'first_name'
    LEFT JOIN txsxekgr_esinec.wp_usermeta AS uml ON p2.clienteId = uml.user_id AND uml.meta_key = 'last_name'
    LEFT JOIN txsxekgr_esinec.wp_usermeta AS um3 ON p2.clienteId = um3.user_id AND um3.meta_key = 'billing_address_1'
    LEFT JOIN txsxekgr_esinec.wp_usermeta AS um4 ON p2.clienteId = um4.user_id AND um4.meta_key = 'billing_state'
    LEFT JOIN txsxekgr_esinec.wp_usermeta AS um5 ON p2.clienteId = um5.user_id AND um5.meta_key = 'billing_country'
    LEFT JOIN txsxekgr_esinec.wp_usermeta AS um6 ON p2.clienteId = um6.user_id AND um6.meta_key = 'billing_postcode'
    LEFT JOIN txsxekgr_esinec.wp_usermeta AS um7 ON p2.clienteId = um7.user_id AND um7.meta_key = 'billing_city'
    LEFT JOIN txsxekgr_esinec.wp_usermeta AS um8 ON p2.clienteId = um8.user_id AND um8.meta_key = '_billing_nif'
    LEFT JOIN txsxekgr_esinec.wp_usermeta AS um9 ON p2.clienteId = um9.user_id AND um9.meta_key = 'billing_phone'
    LEFT JOIN txsxekgr_esinec.wp_usermeta AS um10 ON p2.clienteId = um10.user_id AND um10.meta_key = 'billing_email'
    WHERE p2.id = $id");
        $stmt->execute();
        if($stmt->rowCount() === 0) {
            echo json_encode(array("message" => "No rows to show"));
        } else {
            while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
                $data[] = $users;
            }
            echo json_encode($data);
        }
}