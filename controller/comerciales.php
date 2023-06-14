<?php
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

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

}  elseif ( (isset($_GET['type']) && $_GET['type'] == 'comercial-equipo') && (isset($_GET['id']) ) ) {
    global $conn;
    $id = $_GET['id'];
    $data = array();
    $stmt = $conn->prepare("SELECT c.id, c.equipo
        FROM comercialesEquipos AS c
        WHERE c.id = :id
        ORDER BY c.equipo ASC");
        $stmt->execute(array(':id' => $id));
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);
} elseif ( (isset($_GET['type']) && $_GET['type'] == 'comerciales-equipos') ) {
    global $conn;
    $data = array();
    $stmt = $conn->prepare(
        "SELECT c.id, c.equipo
        FROM comercialesEquipos AS c
        ORDER BY c.equipo ASC");
        $stmt->execute();
        if($stmt->rowCount() === 0) echo ('No rows');
        while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
            $data[] = $users;
        }
    echo json_encode($data);
}