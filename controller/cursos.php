<?php
$url_root = $_SERVER['DOCUMENT_ROOT'];
$url_server = "https://" . $_SERVER['HTTP_HOST'] . "/";

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($url_root . '/inc/connection.php');

// JSON
if ( (isset($_GET['type']) && $_GET['type'] == 'inscripcion-cursos') ) {
    global $conn2;
    $data = array();
    $stmt = $conn2->prepare(
        "SELECT e.id, e.edicion, COUNT( i.edicion) AS total, c.codigo
        FROM txsxekgr_intranet.inscripcion_clientes AS i
        JOIN txsxekgr_intranet.edicionCurso AS e ON e.id = i.edicion
        LEFT JOIN txsxekgr_intranet.codigoCurso AS c ON e.curso = c.id
        GROUP BY i.edicion
        ORDER BY e.edicion ASC");
        $stmt->execute();
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);

}  elseif ( (isset($_GET['type']) && $_GET['type'] == 'inscripcion-curso') && (isset($_GET['id']) ) ) {
    global $conn2;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn->prepare("SELECT e.id, u.ID AS idCliente, m.meta_value as first_name, m2.meta_value as last_name
    FROM txsxekgr_intranet.inscripcion_clientes AS i
    JOIN txsxekgr_intranet.edicionCurso AS e ON e.id = i.edicion
    JOIN txsxekgr_esinec.wp_users AS u ON i.cliente = u.ID
    LEFT JOIN txsxekgr_esinec.wp_usermeta m ON u.ID = m.user_id AND m.meta_key = 'first_name'
    LEFT JOIN txsxekgr_esinec.wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'last_name'
    WHERE i.edicion = :id
    ORDER BY last_name ASC");
        $stmt->execute(array(':id' => $id));
        if($stmt->rowCount() === 0) {
            echo json_encode(array("message" => "No rows to show"));
        } else {
            while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
                $data[] = $users;
            }
            echo json_encode($data);
        }
        
}  elseif ( (isset($_GET['type']) && $_GET['type'] == 'edicion-curso') && (isset($_GET['id']) ) ) {
    global $conn2;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn->prepare("SELECT e.id, e.edicion, e.curso
    FROM txsxekgr_intranet.edicionCurso AS e
    WHERE e.id = :id");
        $stmt->execute(array(':id' => $id));
        if($stmt->rowCount() === 0) {
            echo json_encode(array("message" => "No rows to show"));
        } else {
            while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
                $data[] = $users;
            }
            echo json_encode($data);
        }

}  elseif ( (isset($_GET['type']) && $_GET['type'] == 'curso') && (isset($_GET['id']) ) ) {
    global $conn2;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn->prepare("SELECT e.edicion, c.codigo
    FROM  txsxekgr_intranet.edicionCurso AS e
    JOIN txsxekgr_intranet.codigoCurso AS c ON e.curso = c.id
    WHERE e.id = :id");
        $stmt->execute(array(':id' => $id));
        if($stmt->rowCount() === 0) {
            echo json_encode(array("message" => "No rows to show"));
        } else {
            while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
                $data[] = $users;
            }
            echo json_encode($data);
        }
}