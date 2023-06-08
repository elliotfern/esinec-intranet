<?php
$url_root = $_SERVER['DOCUMENT_ROOT'];
$url_server = "https://" . $_SERVER['HTTP_HOST'] . "/";

require_once($url_root . '/inc/connection.php');

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
    from
        wp_posts p 
        join wp_postmeta pm on p.ID = pm.post_id
        join wp_woocommerce_order_items oi on p.ID = oi.order_id
    where post_type = 'shop_order'
    group by p.ID
    ORDER BY invoice_number DESC");
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

}