<?php
$url_root = $_SERVER['DOCUMENT_ROOT'];
$url_server = "https://" . $_SERVER['HTTP_HOST'] . "/";

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($url_root . '/inc/connection.php');

// JSON
if ( (isset($_GET['type']) && $_GET['type'] == 'comerciales') ) {
    global $conn;
    $data = array();
    $stmt = $conn->prepare(
        "SELECT c.id, c.comercial
        FROM comercial AS c
        ORDER BY c.comercial ASC");
        $stmt->execute();
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);

}  elseif ( (isset($_GET['type']) && $_GET['type'] == 'comercial') && (isset($_GET['id']) ) ) {
    global $conn;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn->prepare("SELECT c.id, c.comercial
        FROM comercial AS c
        WHERE c.id = :id
        ORDER BY c.comercial ASC");
        $stmt->execute(array(':id' => $id));
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);
}