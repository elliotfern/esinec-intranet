<?php

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";

// Definir la URL de la API de WooCommerce y las credenciales de autenticación
$url = 'https://esinec.com/wp-json/wc/v3/customers/244';

// ID del usuario que deseas editar
$customer_id = 123; // Reemplaza con el ID del usuario que deseas editar

// Datos actualizados del usuario
$usuario = array(
    //'first_name' => 'NuevoNombre',
    //'last_name' => 'NuevoApellido',
    'billing' => array(
        //'first_name' => 'NuevoNombre',
        //'last_name' => 'NuevoApellido',
        'address_1' => 'Calle Desengaño 21',
        'city' => 'Madrid',
        'state' => 'Madrid',
        'country' => 'ES',
        'postcode' => '08225',
        'phone' => 'NuevoTelefono',
        'meta_data' => array(
            array(
                'key' => '_billing_nif',
                'value' => '45323454F'
            ),
        )
    )      
);
// Convertir el arreglo en formato JSON
$data = json_encode($usuario);

// Construir la URL completa con el ID del usuario
$url = str_replace('{customer_id}', $customer_id, $url);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode(WC_API_KEY . ':' . WC_API_SECRET),
));

$response = curl_exec($ch);

if ($response === false) {
    die('Error al editar el usuario: ' . curl_error($ch));
}

$user = json_decode($response);

if (isset($user->id)) {
    echo 'Usuario editado con éxito. ID: ' . $user->id;
} else {
    echo 'Error al editar el usuario: ' . $response;
}

curl_close($ch);

?>