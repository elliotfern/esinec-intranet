<?php
// Realiza la conexión a la base de datos utilizando PDO
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

// Obtén los datos enviados desde el formulario
$idCliente = $_GET['idCliente'];
// Obtén los demás campos del formulario

// Verifica si los datos existen en la base de datos
$query = "SELECT 
nombre,
apellidos,
empresa,
dni,
direccion,
ciudad,
pais,
provincia 
FROM txsxekgr_intranet.datosFiscalesCliente WHERE idCliente = :idCliente";
global $conn;
$stmt = $conn->prepare($query);
$stmt->bindParam(':idCliente', $idCliente);
$stmt->execute();
$datos_existentes = $stmt->rowCount() > 0;

// Crea un arreglo con los datos existentes, si los hay
$datos = array();
if ($datos_existentes) {
    // Obtiene los valores de los campos correspondientes
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    $datos['nombre'] = $fila['nombre'];
    $datos['apellidos'] = $fila['apellidos'];
    $datos['empresa'] = $fila['empresa'];
    $datos['dni'] = $fila['dni'];
    $datos['direccion'] = $fila['direccion'];
    $datos['ciudad'] = $fila['ciudad'];
    $datos['pais'] = $fila['pais'];
    $datos['provincia'] = $fila['provincia'];
}

// Cierra la conexión a la base de datos
$conexion = null;

// Devuelve la respuesta al cliente en formato JSON
$response = array(
    'status' => $datos_existentes,
    'datos' => $datos
);

echo json_encode($response);
?>