<?php
// Recibir los datos enviados desde el frontend
$datos = json_decode(file_get_contents('php://input'), true);

// Conexión a la base de datos utilizando PDO
$dsn = 'mysql:host=nombre_host;dbname=nombre_base_datos';
$username = 'nombre_usuario';
$password = 'contraseña';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertar los datos en la base de datos
    $stmt = $db->prepare('INSERT INTO tabla (comisionista, valor, facturaId) VALUES (?, ?, ?)');
    foreach ($datos as $dato) {
        $stmt->execute([$dato['comisionista'], $dato['valor'], $dato['facturaId']]);
    }

    echo 'Datos guardados correctamente.';
} catch (PDOException $e) {
    echo 'Error al guardar los datos: ' . $e->getMessage();
}