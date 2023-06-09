<?php
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

// JSON
if ( (isset($_GET['type']) && $_GET['type'] == 'clientes') ) {
    global $conn2;
    $data = array();
    $stmt = $conn2->prepare(
        "SELECT u.ID, u.user_login, u.user_email, m.meta_value as first_name, m2.meta_value as last_name, m3.meta_value as billing_address, m4.meta_value as billing_city, m5.meta_value as billing_state, m6.meta_value as billing_zip, m7.meta_value as telephone
        FROM wp_users u
        LEFT JOIN wp_usermeta m ON u.ID = m.user_id AND m.meta_key = 'first_name'
        LEFT JOIN wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'last_name'
        LEFT JOIN wp_usermeta m3 ON u.ID = m3.user_id AND m3.meta_key = 'billing_address_1'
        LEFT JOIN wp_usermeta m4 ON u.ID = m4.user_id AND m4.meta_key = 'billing_city'
        LEFT JOIN wp_usermeta m5 ON u.ID = m5.user_id AND m5.meta_key = 'billing_state'
        LEFT JOIN wp_usermeta m6 ON u.ID = m6.user_id AND m6.meta_key = 'billing_postcode'
        LEFT JOIN wp_usermeta m7 ON u.ID = m7.user_id AND m7.meta_key = 'billing_phone'
        where u.ID NOT IN (SELECT user_id FROM wp_usermeta WHERE meta_key = 'wp_capabilities' AND meta_value LIKE '%administrator%')
        ORDER BY last_name ASC");
        $stmt->execute();
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);

} elseif ( (isset($_GET['type']) && $_GET['type'] == 'clientes') && (isset($_GET['id']) ) ) {
    global $conn2;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn2->prepare(
        "SELECT p.ID AS 'Order ID', p.post_date,
        ( select order_item_name from wp_woocommerce_order_items where order_id = p.ID LIMIT 1 ) as order_items
        FROM  wp_posts AS p
        JOIN  wp_postmeta AS pm ON p.ID = pm.post_id
        JOIN  wp_woocommerce_order_items AS oi ON p.ID = oi.order_id
        WHERE pm.meta_key = '_customer_user' AND pm.meta_value = $id
        GROUP BY p.ID;");
        $stmt->execute();
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);

} elseif ( (isset($_GET['type']) && $_GET['type'] == 'pagos-pendientes') && (isset($_GET['id']) ) ) {
    global $conn;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn->prepare("SELECT p.importe,p.tipoPago, p.fecha, p.estado, wp.post_title, p.numPago, p.id, wp.ID as IDproducto
    FROM txsxekgr_intranet.pagos_programados AS p
    LEFT JOIN txsxekgr_esinec.wp_posts AS wp ON p.producto = wp.ID
    WHERE p.cliente = $id");
        $stmt->execute();
        if($stmt->rowCount() === 0) {
            echo json_encode(array("message" => "No rows to show"));
        } else {
            while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
                $data[] = $users;
            }
            echo json_encode($data);
        }

}  elseif ( (isset($_GET['type']) && $_GET['type'] == 'pago-total-cliente') && (isset($_GET['id']) ) ) {
    global $conn;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn->prepare("SELECT 	
    ic.id,
    ic.importeTotal,
    ic.asistencia,
    c.codigo,
    co.comercial,
    co2.comercial AS comercialCierre,
    ic.notas, 
    e.edicion, e.id AS idEdicion
    FROM txsxekgr_intranet.inscripcion_clientes AS ic
    INNER JOIN txsxekgr_intranet.codigoCurso AS c ON ic.codigo = c.id
    LEFT JOIN txsxekgr_intranet.comercial AS co ON ic.captacionComercial = co.id
    LEFT JOIN txsxekgr_intranet.comercial AS co2 ON ic.comercialCierre = co2.id
    LEFT JOIN txsxekgr_intranet.edicionCurso AS e ON ic.edicion = e.id
    WHERE ic.cliente = $id");
        $stmt->execute();
        if($stmt->rowCount() === 0) {
            echo json_encode(array("message" => "No rows to show"));
        } else {
            while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
                $data[] = $users;
            }
            echo json_encode($data);
        }

}  elseif ( (isset($_GET['type']) && $_GET['type'] == 'inscripcion-cliente') && (isset($_GET['id']) ) ) {
        global $conn;
        $id = $_GET['id'];
        $data = array();
        $stmt = $conn->prepare("SELECT 	
        ic.id, ic.importeTotal, ic.asistencia, ic.cliente, ic.codigo, ic.captacionComercial, ic.comercialCierre, ic.notas, ic.edicion
        FROM txsxekgr_intranet.inscripcion_clientes AS ic
        WHERE ic.id = $id");
            $stmt->execute();
            if($stmt->rowCount() === 0) {
                echo json_encode(array("message" => "No rows to show"));
            } else {
                while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
                    $data[] = $users;
                }
                echo json_encode($data);
            }
} elseif ( (isset($_GET['type']) && $_GET['type'] == 'pago-cliente-json') && (isset($_GET['id']) ) ) {
    global $conn;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn->prepare("SELECT p.importe, p.tipoPago, p.fecha, p.estado, p.numPago, p.id, p.cliente, p.producto
    FROM txsxekgr_intranet.pagos_programados AS p
    WHERE p.id = $id");
        $stmt->execute();
        if($stmt->rowCount() === 0) {
            echo json_encode(array("message" => "No rows to show"));
        } else {
            while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
                $data[] = $users;
            }
            echo json_encode($data);
        }
}  elseif ( (isset($_GET['type']) && $_GET['type'] == 'facturas-intranet') && (isset($_GET['id']) ) ) {
    global $conn;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn->prepare("SELECT
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
    WHERE p2.clienteId = $id
    GROUP BY p2.id
    ORDER BY p2.date DESC");
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