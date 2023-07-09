<?php
session_start(); // Iniciar sesión (asegúrate de colocar esto al principio de tu archivo PHP si aún no se ha iniciado la sesión)

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$root_server= $_SERVER['SERVER_NAME'];

$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

// JSON
if ( (isset($_GET['type']) && $_GET['type'] == 'comerciales') ) {
    if (!isset($_SESSION['user'])) {
        // Si el usuario no está autenticado, redirigir a la página de inicio de sesión o mostrar un mensaje de error.
        header('Location: '.$root_server. 'login.php');
        exit(); // O simplemente salir del script sin mostrar nada.
    }

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
    if (!isset($_SESSION['user'])) {
        // Si el usuario no está autenticado, redirigir a la página de inicio de sesión o mostrar un mensaje de error.
        header('Location: '.$root_server. 'login.php');
        exit(); // O simplemente salir del script sin mostrar nada.
    }

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

    if (!isset($_SESSION['user'])) {
        // Si el usuario no está autenticado, redirigir a la página de inicio de sesión o mostrar un mensaje de error.
        header('Location: '.$root_server. 'login.php');
        exit(); // O simplemente salir del script sin mostrar nada.
    }


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